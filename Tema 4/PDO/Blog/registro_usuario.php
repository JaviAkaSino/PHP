<?php
require "src/config_bd.php";

if (isset($_POST["boton_registro"])){

    $error_usuario = $_POST["usuario"]=="";
    $error_clave = $_POST["clave"]=="";

    $error_form = $error_usuario || $error_clave;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>Blog Personal</h1>
    <form action="registro_usuario.php" method="post">
        <p>
            <label for="usuario">Nombre de usuario: </label>
            <input type="text" id="usuario" name="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"] ?>">
            <?php
            if (isset($_POST["usuario"]) && $error_usuario)
                echo "<span class='error'> *Campo vacío</span>";
            ?>
        </p>

        <p><label for="clave">Clave: </label>
            <input type="password" id="clave" name="clave">
            <?php
            if (isset($_POST["clave"]) && $error_clave)
                echo "<span class='error'> *Campo vacío</span>";
            ?>
        </p>

        <p>
            <button type="submit" name="boton_volver">Volver</button>
            <button type="submit" name="boton_registro" >Registarse</button>
        </p>
</body>
</html>