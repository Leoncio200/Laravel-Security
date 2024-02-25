<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code</title>
</head>
<body>
    <div class="contenedor">
        <form action="/code/verify"  method="post">
            @csrf
            <input type="number" name="">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        </form>
    </div>
</body>
</html>