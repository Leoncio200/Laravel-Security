<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProductController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Obtener el usuario autenticado
        $products = Product::all();
        $rol = $user->rol_id;
        return view('products', compact('products', 'user', 'rol'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        // Valida los datos del formulario
        $validatedData = $request->validate([
            'nombre' => 'required',
            'descripcion' => 'nullable',
            'cantidad' => 'required|integer|min:0',
        ]);

        // Crea un nuevo producto con los datos validados
        Product::create($validatedData);

        // Redirecciona a la página de listado de productos
        return redirect()->route('products.index');
    }

    public function edit($id)
{
    $product = Product::findOrFail($id);
    return view('edit', compact('product'));
}

public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    // Valida los datos del formulario
    $validatedData = $request->validate([
        'nombre' => 'required',
        'descripcion' => 'nullable',
        'cantidad' => 'required|integer|min:0',
    ]);

    // Actualiza el producto con los datos validados
    $product->update($validatedData);

    // Redirecciona a la página de listado de productos
    return redirect()->route('products.index');
}

public function destroy($id)
{
    $product = Product::findOrFail($id);
    $product->delete();

    // Redirecciona a la página de listado de productos
    return redirect()->route('products.index');
}

}

