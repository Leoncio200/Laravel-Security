<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AppController extends Controller
{
    public function validarUsuario(Request $request)
    {
        if ($request->isMethod('post')) {
            // Si es una solicitud POST, solo devuelve un mensaje de éxito ya que la validación se realiza en el cliente Android
            return response()->json(['message' => 'Solicitud POST procesada']);
        } elseif ($request->isMethod('get')) {
            // Si es una solicitud GET, realiza la validación de las credenciales
            $usu_usuario = $request->query('usuario');
            $usu_password = $request->query('password');
    
            // Buscar el usuario por su email en la base de datos
            $usuario = User::where('email', $usu_usuario)
                        ->orWhere('password', Hash::make($usu_password))
                        ->first();

            // Verificar si se encontró el usuario y si la contraseña proporcionada es válida
            if ($usuario && Hash::check($usu_password, $usuario->password)) {
                return response()->json(['message' => 'Credenciales válidas']);
            } else {
                return response()->json(['error' => 'Credenciales inválidas'], 401);
            }
        } else {
            // Si es un método no permitido, devuelve un error 405
            return response()->json(['error' => 'Método no permitido'], 405);
        }
    
    }



    public function validarCodigo(Request $request)
    {
        if ($request->isMethod('post')) {
            // Si es una solicitud POST, solo devuelve un mensaje de éxito ya que la validación se realiza en el cliente Android
            return response()->json(['message' => 'Solicitud POST procesada']);
        } elseif ($request->isMethod('get')) {
            // Si es una solicitud GET, realiza la validación de las credenciales
            $codigo = $request->query('codigo');
            $usuario = $request->query('usuario');
            $password = $request->query('password');
    
            // Buscar el usuario por su email en la base de datos
            $usuario = User::where('email', $usuario)->first();
    
            // Verificar si se encontró el usuario y si la contraseña proporcionada es válida
            if ($usuario && Hash::check($password, $usuario->password) && Hash::check( $codigo, $usuario->code)) {
                // Generar un número aleatorio de 4 dígitos
            $nuevoCodigo = mt_rand(1000, 9999);

            // Aplicar el hash al nuevo código
          //  $codigoHash = Hash::make($nuevoCodigo);

            // Actualizar el campo codeAdmin del usuario con el nuevo código hasheado
          //  $usuario->codeAdmin = $codigoHash;
          $usuario->codeAdmin = $nuevoCodigo;
            $usuario->save();
                return response()->json(['message' => 'Credenciales válidas']);
            } else {
                return response()->json(['error' => 'Credenciales inválidas'], 401);
            }
        } else {
            // Si es un método no permitido, devuelve un error 405
            return response()->json(['error' => 'Método no permitido'], 405);
        }
    }



    public function codeAdmin(Request $request)
    {
        if ($request->isMethod('post')) {
            // Si es una solicitud POST, solo devuelve un mensaje de éxito ya que la validación se realiza en el cliente Android
            return response()->json(['message' => 'Solicitud POST procesada']);
        } elseif ($request->isMethod('get')) {
            // Si es una solicitud GET, realiza la validación de las credenciales
            $usuario = $request->query('usuario');
            $password = $request->query('password');
    
            // Buscar el usuario por su email en la base de datos
            $usuario = User::where('email', $usuario)->first();
    
            // Verificar si se encontró el usuario y si la contraseña proporcionada es válida
            if ($usuario && Hash::check($password, $usuario->password)) {


                // Devolver el código deshasheado en formato JSON
                return response()->json(['codigo' => $usuario->codeAdmin]);

            } else {
                return response()->json(['error' => 'Credenciales inválidas'], 401);
            }
        } else {
            // Si es un método no permitido, devuelve un error 405
            return response()->json(['error' => 'Método no permitido'], 405);
        }



        // Aquí se puede validar la solicitud si es necesario
        //$codigo = [
          //  "codigo" => "123456"
        //];

        //return response()->json($codigo);
    }
   }
