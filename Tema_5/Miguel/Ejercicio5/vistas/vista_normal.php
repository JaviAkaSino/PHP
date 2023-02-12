<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SW</title>
    <style>
        .enlinea{display:inline}
        .enlace{border:none;background:none;text-decoration:underline;color:blue;cursor:pointer}
    </style>
</head>
<body>
    <h1>Login SW</h1>
    <div>Bienvenido <strong><?php echo $datos_usuario_log->usuario;?></strong> - 
        <form class="enlinea" method="post" action="index.php">
            <button name="btnSalir" class="enlace">Salir</button>
        </form>
    </div>
    
</body>
</html>