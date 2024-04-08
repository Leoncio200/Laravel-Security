<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function index()
{
    $user = Auth::user(); // Obtener el usuario autenticado

    // Obtener los usuarios con el nombre del rol
    $users = User::select('users.*', 'rols.rol as nombre_rol')
                ->leftJoin('rols', 'users.rol_id', '=', 'rols.id')
                ->get();
    
    return view('users', compact('users', 'user'));
}

    public function create()
    {
        return view('createUser');
    }

    public function store(Request $request)
    {

        // Valida los datos del formulario
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'nullable',
            'number' => 'required',
            'password' => 'required',
            'rol_id' => 'required|integer|min:0',
        ]);


        // Crea un nuevo producto con los datos validados
        User::create($validatedData);

        // Redirecciona a la página de listado de productos
        return redirect()->route('users.index');
    }






    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('editUser', compact('user'));
    }
    
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
    
        // Valida los datos del formulario
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'nullable',
            'number' => 'required',
            'password' => 'required',
            'rol_id' => 'required|integer|min:0',
        ]);
    
        // Actualiza el producto con los datos validados
        $user->update($validatedData);
    
        // Redirecciona a la página de listado de productos
        return redirect()->route('users.index');
    }

    public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    // Redirecciona a la página de listado de productos
    return redirect()->route('users.index');
}
}
