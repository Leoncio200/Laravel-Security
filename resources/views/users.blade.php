@extends('layout')

@section('content')
    <div class="row">
        <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
                <h1>Listado de Usuarios</h1>
            </div>
            
            <a href="{{ route('users.create') }}" class="btn btn-primary">Añadir Nuevo Usuario</a>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Email</th>
                        <th scope="col">Numero</th>
                        <th scope="col">Rol</th>
                        <th scope="col">Acciones</th> <!-- Nueva columna para acciones -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->number }}</td>
                        <td>{{ $user->nombre_rol }}</td>
                        <td>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Editar</a>
                            <!-- Enlace para editar cada producto -->
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
