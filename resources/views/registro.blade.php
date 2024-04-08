<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="register-body">
        <div class="register-wrapper">
            <form action="{{route('register')}}" method="post">
                @csrf
                <h1>Registro</h1>
                <div class="input-box-register">
                    <input type="text" name="name" placeholder="Nombre" value="{{ old('name') }}" required>
                    
                </div>
                
                <div class="input-box-register">
                    <input type="email" name="email" placeholder="Correo" value="{{ old('email') }}" required>
                   
                </div>

                <div class="input-box-register">
                    <input type="number" name="number" placeholder="Numero" value="{{ old('number') }}" required>
                    
                </div>
                
                <div class="input-box-register">
                    <input type="password" name="password" placeholder="Contraseña" required>
                  
                </div>
                
                <div class="input-box-register">
                    <input type="password" name="password2" placeholder="Confirmacion de contraseña" required>
                    
                </div>
                @error('email')
                    <div class="alerta">{{$message}}</div>
                @enderror
                @error('passwords')
                    <div class="alerta">{{$message}}</div>
                @enderror
                <button type="submit" class="register-btn">Registrar</button>

                <div class="login-link">
                    <p>Ya tiene cuenta? <a href="/login">Login</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>