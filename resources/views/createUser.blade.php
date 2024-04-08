@extends('layout')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>Añadir Nuevo Usuario</h1>
            <form method="POST" action="{{ route('users.store') }}">
                @csrf
                <div class="form-group">
                    <label for="name">Nombre:</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="number">Numero:</label>
                    <input type="number" name="number" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="Password">Password:</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="cantidad">Rol:</label>
                    <select name="rol_id" id="3">
                        <option value="3">Invitado</option>
                        <option value="2">Coordinador</option>
                        <option value="1">Administrador</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </div>
@endsection
