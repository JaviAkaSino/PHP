<?php
if(isset($_POST["btnSalir"]))
{
    session_destroy();
    mysqli_close($conexion);
    header("Location:index.php");
    exit;
}


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen2 Curso 18_19</title>
    <style>
        .enlace{border:none;background:none;text-decoration:underline;color:blue;cursor:pointer}
        .enlinea{display:inline}
    </style>
</head>
<body>
    <?php
    require "vistas/cabecera_saludo.php";
    if(isset($_SESSION["mensaje_registro"]))
    {
        echo "<p class='mensaje'>".$_SESSION["mensaje_registro"]."</p>";
        unset($_SESSION["mensaje_registro"]);
    }
    ?>
</body>
</html>