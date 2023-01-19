<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login con PDO - NORMAL</title>
</head>

<body>
    <h1>Login con PDO</h1>

    <div>
        <form class="en_linea" action="index.php" method="post">
            <label><strong><?php echo $datos_usuario_log["usuario"] ?></strong> - </label>
            <button type="submit" name="boton_salir">Salir</button>
        </form>
    </div>


</body>

</html>