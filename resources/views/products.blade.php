@extends('layout')

@section('content')
    <div class="row">
        <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
                <h1>Listado de Productos</h1>
                @if ($rol == 1)
                <a href="{{ route('users.index') }}" class="btn btn-primary">Usuarios</a>
                @endif
            </div>
            <p>Usuario: {{ $user->name }}</p>
<p>Rol ID: {{ $rol }}</p>
@if ($rol != 3)
                <a href="{{ route('products.create') }}" class="btn btn-primary">Añadir Nuevo Producto</a>
                
            @endif
            <form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Cerrar sesión</button>
</form>
            <table class="table">

                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Cantidad</th>
                        @if ($rol != 3)
                        <th scope="col">Acciones</th> <!-- Nueva columna para acciones -->
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->nombre }}</td>
                        <td>{{ $product->descripcion }}</td>
                        <td>{{ $product->cantidad }}</td>
                        <td>
                          <!-- Mostrar botones solo si el usuario tiene rol diferente de invitado -->
                          @if ($rol != 3)
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">Editar</a>
                                    <!-- Enlace para editar cada producto -->
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>
                                @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
