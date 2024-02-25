<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container">
        <h1>Welcome {{$user->name}}</h1>
        <button><a href="{{ route('logout') }}">Cerrar session</a></button>
    </div>
</body>
</html>