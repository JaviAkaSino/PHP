<?php

if (isset($_POST["boton_volver"])) {
    header("Location:index.php");
    exit();
}

if (isset($_POST["boton_continuar"])) {

    $error_nombre = $_POST["nombre"] == "";
    $error_usuario = $_POST["usuario"] == ""/* || repetido()*/;
    $error_clave = $_POST["clave"] == "";
    $error_email = $_POST["email"] == "" || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    $error_form = $error_nombre || $error_usuario || $error_clave || $error_email;
    if (!$error_form) {
        echo "Inserto en BD y salto a index";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Práctica 1er CRUD</title>
</head>

<body>
    <h1>Nuevo usuario</h1>
    <form action="usuario_nuevo.php" method="post">
        <p>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" maxlength="30" value="<?php if (isset($_POST["nombre"])) echo $_POST["nombre"] ?>">
            <?php if (isset($_POST["nombre"]) && $error_nombre) echo "<span class='error'> Campo vacío </span>" ?>
        </p>
        <p>
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" id="usuario" maxlength="20" value="">
            <?php if (isset($_POST["usuario"]) && $error_usuario) echo "<span class='error'> Campo vacío </span>" ?>
        </p>
        <p>
            <label for="clave">Contraseña:</label>
            <input type="password" name="clave" id="clave" maxlength="20" value="">
            <?php if (isset($_POST["clave"]) && $error_clave) echo "<span class='error'> Campo vacío </span>" ?>
        </p>

        <p>
            <label for="email">E-mail:</label>
            <input type="text" name="email" id="email" maxlength="50" value="<?php if (isset($_POST["email"])) echo $_POST["email"] ?>">
            <?php if (isset($_POST["email"]) && $error_email) {
                if ($_POST["email"] == "")
                    echo "<span class='error'> Campo vacío </span>";
                else
                    echo "<span class='error'> E-mail no válido</span>";
            }


            ?>
        </p>
        <p>
            <button type="submit" name="boton_volver">Volver</button>
            <button type="submit" name="boton_continuar">Continuar</button>
        </p>
    </form>
</body>

</html>