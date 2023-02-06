<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .linea{
            display:flex;
        }
        .enlace{
            background: none;
            border: none;
            text-decoration: underline;
            color: #FF600A;
            cursor: pointer;
        }
    </style>
    <title>Normal Servicios Web</title>
</head>
<body>
    <h1>Normal Servicios Web</h1>
    <div class ="linea">
        <span>Bienvenido <strong><?php echo $datos_usuario_log->nombre ?></strong></span>
        <form action="index.php" method="post">
            <button name="boton_salir" class="enlace">Salir</button>
        </form>
    </div>
</body>
</html>