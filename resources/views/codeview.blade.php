<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="contenedor-codeview">
        <form action="{{route('code.verify')}}"  method="post">
            @csrf
            <input type="number" name="code">
            <input type="number" name="user_id" value="{{ $_id }}" hidden>
            <button type="submit">Enviar</button>
        </form>
    </div>
</body>
</html>