<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use App\Jobs\MailSend;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class AuthController extends Controller
{
    
    public function getlogin(){
        return view('Login');
    }

    public function getregistro(){
        return view('registro');
    }

    public function registrar(Request $request){
        try{
            $validated = Validator::make($request->all(),[
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'number' => 'required',
                'password' => 'required',
                'password2' => 'required',
            ],[
                'name.required' => 'El nombre es requerido',
                'email.required' => 'El email es requerido',
                'number.required' => 'El numero es requerido',
                'email.unique' => 'No se puede usar ese email',
                'password.required' => 'La contraseña es requerido',
                'password2.required' => 'La confirmacion de la contraseña es requerido',
            ]);
    
            if(!$validated->fails()){
                if(!($request->password2 == $request->password)){
                    $validated->errors()->add(
                        'passwords', 'Las contraseñas no coinciden'
                    );
                    return redirect('/registro')->withInput()->withErrors($validated);
                }
    
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'rol_id' => User::count() > 0 ? 3 : 1,
                    'number' => $request->number,
                    'password' => Hash::make($request->password)
                ]);
                
                
                Log::channel('slack')->info("Se ha creado el usuario $user");
                                
                return redirect('/');
            }
            return redirect('/registro')->withInput()->withErrors($validated);
        }
        catch(Throwable $e){
            Log::channel('slack')->error($e);
            return view ('errors');
        }
    }

    public function login(Request $request){
        $validated = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => 'required'
        ],[
            'email.required' => 'El email es requerido',
            'password.required' => 'La contraseña es requerido',
            'g-recaptcha-response.required' => 'No ha seleccionado la casilla del recapcha',
        ]);

        if(!$validated->fails()){
            $secretkey = env('NOCAPTCHA_SECRETKEY');
            $recatcha = $request->input('g-recaptcha-response');
            $response = Http::post("https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$recatcha");

            if(!$response['success']){
                $validated->errors()->add(
                    'recaptcha', 'El recaptcha esta mal'
                );
                return redirect('/login')->withInput()->withErrors($validated);
            }

            if(!Auth::attempt($request->only(['email', 'password']))){
                $validated->errors()->add(
                    'Auth', 'Las credenciales no coinciden'
                );
                return redirect('/login')->withInput()->withErrors($validated);
            }

            $request->session()->regenerate();
            $user = Auth::user();

            if($user->rol_id == 1){
                if(!AuthController::ipInRange($request->getHost(), "10.0.0.0/24")){
                    $validated->errors()->add(
                        'Auth', 'Las credenciales no coinciden'
                    );

                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    
                    return redirect('/login')->withInput()->withErrors($validated);
                }
            }
            
            MailSend::dispatch($user)->delay(now()->addMinutes(1))->onQueue('MailSend');
            return view('confirmacionView',['user'=>$user]);
            

        }
        return redirect('/login')->withInput()->withErrors($validated);

    }

    public function verifyemail(Request $request, int $id){    
      
        $user = User::find($id);
        
        if($user->rol_id == 1 || $user->rol_id == 3 || $user->rol_id == 2){
            /*$numero = rand(1000,9999);
            
            $response = Http::post("https://rest.nexmo.com/sms/json",[
                "from"=>"Vonage APIs",
                "text"=>$numero,
                "to"=>"52$user->number",
                "api_key"=>env('VONAGE_API_KEY'),
                "api_secret"=>env('VONAGE_API_SECRET')]);
            */
           // $user->code = Hash::make(1111);
            //$user->save();

            return view("codeview",['_id' => $user->id]);
        }
        
        
        
        return redirect('/products');
    }

   

    public function verifycode(Request $request){  
        $validated = Validator::make($request->all(), [
            'code' => 'required',
            'user_id' => 'required'
        ], [
            'code.required' => 'El código es requerido',
        ]);   
        
        if (!$validated->fails()) {
            $user = User::find($request->user_id);
            
            if($user->rol_id == 1){
                if ($request->code == $user->codeAdmin) {
                    // Eliminar el código del usuario
                    $user->code = null;
                    $user->codeAdmin = null;
                    $user->save();
                    
                    // Redirigir al usuario a la página de productos
                    return redirect('/products')->with('user', $user);
                } else {
                    // Código incorrecto, redirigir de vuelta con un mensaje de error
                    return redirect()->back()->withInput()->withErrors(['code' => 'Código incorrecto']);
                } 
            }
            // Verificar si el código ingresado coincide con el código almacenado para el usuario
            if (Hash::check($request->code, $user->code)) {
                // Eliminar el código del usuario
                $user->code = null;
                $user->save();
                
                // Redirigir al usuario a la página de productos
                return redirect('/products')->with('user', $user);
            } else {
                // Código incorrecto, redirigir de vuelta con un mensaje de error
                return redirect()->back()->withInput()->withErrors(['code' => 'Código incorrecto']);
            }
        }
        
        // Validación fallida, redirigir de vuelta con los errores de validación
        return redirect()->back()->withInput()->withErrors($validated);         
    }

    
    public function logout(Request $request){        
        $request->session()->invalidate();
        
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
    
    public function gethome(){
        $user = Auth::user();
        return view('products', ['user'=>$user]);
    }

    public function ipInRange($ip, $range)
    {
        // Divide la dirección IP y la máscara de subred del rango
        list($range, $netmask) = explode('/', $range);

        // Convierte la máscara de subred a una máscara de bits
        $netmask = ~((1 << (32 - $netmask)) - 1);

        // Convierte las direcciones IP a números enteros
        $ipLong = ip2long($ip);
        $rangeLong = ip2long($range);

        // Aplica la máscara de subred a la dirección IP y al rango
        $ipMasked = $ipLong & $netmask;
        $rangeMasked = $rangeLong & $netmask;

        // Verifica si la dirección IP está dentro del rango
        return ($ipMasked == $rangeMasked);
    }

}
