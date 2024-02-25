<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://www.google.com/recaptcha/enterprise.js" async defer></script>
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="body">
        <div class='wrapper'>
            <form action="{{route('login')}}" method="post">
                @csrf
                <h1>Login</h1>
                <div class='input-box'>
                    <input type="email" name='email' placeholder='Email' value="{{ old('email') }}" required/>
                    <x-entypo-email class="icon"/>
                </div>
                
                <div class='input-box'>
                    <input type="password"  name='password' placeholder='Password' required/>
                    <x-tni-password-o class="icon"/>
                </div>

                <div class="recaptcha">
                    <div class="g-recaptcha" data-sitekey="{{env('NOCAPTCHA_SITEKEY')}}" data-action="LOGIN"></div>
                </div>

                @error('Auth')
                <div class="alerta">{{$message}}</div>
                @enderror

                @error('g-recaptcha-response')
                <div class="alerta">{{$message}}</div>
                @enderror

                <div class="remember-forgot">
                    <label><input type="checkbox" name="remember"/>Recordarmelo</label>
                    <a href="/forgotpassword" class='li'>Olvido su contraseña?</a>
                </div>

                <button type='submit'>Login</button>

                <div class="register-link">
                    <p>No tiene cuenta? <a href="/registro" class='li'>Registrarme</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
