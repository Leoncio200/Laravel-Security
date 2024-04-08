@extends('layout')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>Editar Usuario</h1>
            <form method="POST" action="{{ route('users.update', $user->id) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                </div>
                <div class="form-group">
                <label for="email">Email:</label>
                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" required >
                </div>
                <div class="form-group">
                    <label for="number">Numero:</label>
                    <input type="number" name="number" class="form-control" value="{{ $user->number }}" required>
                </div>
                <div class="form-group">
                    <label for="Password">Password:</label>
                    <input type="password" name="password" class="form-control" value="{{ $user->password }}" required>
                </div>
                <div class="form-group">
                    <label for="cantidad">Rol:</label>
                    <select name="rol_id" id="{{ $user->rol_id }}">
                        <option value="3">Invitado</option>
                        <option value="2">Coordinador</option>
                        <option value="1">Administrador</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </form>
        </div>
    </div>
@endsection
