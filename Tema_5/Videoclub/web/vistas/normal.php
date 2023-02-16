<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Videoclub - NORMAL</title>
    <style>
        .enlace{
            border:none; background:none;color:blue;text-decoration: underline;cursor: pointer;
        }
        .linea{display:inline}
    </style>
</head>
<body>
    <h1>Videoclub - NORMAL</h1>

    <div>Bienvenido/a, <strong><?php echo $_SESSION["usuario"] ?></strong>
        <form  class="linea" action="index.php" method="post">
            <button class="enlace" name="boton_salir">Salir</button>
        </form>    
    </div>

</body>
</html>