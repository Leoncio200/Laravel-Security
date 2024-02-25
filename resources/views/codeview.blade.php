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
            <input type="number" name="code">
            <input type="number" name="user_id" value=_id hidden>
        </form>
    </div>
</body>
</html>