<?php
if (isset($_POST["boton_volver"])) {
    header("Location:index.php");
    exit();
}

if (isset($_POST["boton_continuar"])) { //Al pulsar botón, revisamos errores normales

    $error_nombre = $_POST["nombre"] == "";
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_email = $_POST["email"] == "" || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    $error_form = $error_nombre || $error_usuario || $error_clave || $error_email;

    if (!$error_usuario || !$error_email) { //Si ya están rellenos, mirar si están repetidos

        try { //Try catch de la conexión

            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {

            die(error_page("Prácitca 1º CRUD", "Nuevo Usuario", "Imposible conectar. Error Nº " .
                mysqli_connect_errno() . ": " . mysqli_connect_error()));
        }

        if (!$error_usuario) { //SI USUARIO YA ESTÁ RELLENO

            $error_usuario = repetido($conexion, "usuarios", "usuario", $_POST["usuario"]); //Error si repetido

            if (is_string($error_usuario)) { //Si se obtiene un mensaje de error, se enseña

                mysqli_close($conexion);
                die(error_page("Prácitca 1º CRUD", "Nuevo Usuario", $error_usuario));
            }
        }

        if (!$error_email) { // IGUAL PARA EMAIL

            $error_email = repetido($conexion, "usuarios", "email", $_POST["email"]);

            if (is_string($error_email)) {

                mysqli_close($conexion);
                die(error_page("Prácitca 1º CRUD", "Nuevo Usuario", $error_email));
            }
        }


        $error_form = $error_nombre || $error_usuario || $error_clave || $error_email;

        if (!$error_form) {

            $consulta = "insert into usuarios (nombre, usuario, clave, email) values ('" . $_POST["nombre"] .
                "', '" . $_POST["usuario"] . "', '" . md5($_POST["clave"]) . "', '" . $_POST["email"] . "')";

            try {

                mysqli_query($conexion, $consulta);

                $_SESSION["usuario"] = $_POST["usuario"];
                $_SESSION["clave"] = $_POST["clave"];

                mysqli_close($conexion);
                header("Location:index.php");
                exit();
            } catch (Exception $e) {

                $mensaje = "Imposible realizar la consulta. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
                mysqli_close($conexion);
                die(error_page("Prácitca 1º CRUD", "Nuevo Usuario", $mensaje));
            }
        }
    }
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Primer Login</title>
</head>

<body>
    <h1>Registro</h1>
    <form action="index.php" method="post">
        <p>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" maxlength="30" value="<?php if (isset($_POST["nombre"])) echo $_POST["nombre"] ?>">
            <?php if (isset($_POST["nombre"]) && $error_nombre) echo "<span class='error'> Campo vacío </span>" ?>
        </p>
        <p>
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" id="usuario" maxlength="20" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"] ?>">
            <?php if (isset($_POST["boton_continuar"]) && $error_usuario) {
                if ($_POST["usuario"] == "")
                    echo "<span class='error'> Campo vacío </span>";
                else
                    echo "<span class='error'> Usuario ya existente </span>";
            }  ?>
        </p>
        <p>
            <label for="clave">Contraseña:</label>
            <input type="password" name="clave" id="clave" maxlength="20" value="">
            <?php if (isset($_POST["boton_continuar"]) && $error_clave) echo "<span class='error'> Campo vacío </span>" ?>
        </p>

        <p>
            <label for="email">E-mail:</label>
            <input type="text" name="email" id="email" maxlength="50" value="<?php if (isset($_POST["email"])) echo $_POST["email"] ?>">
            <?php if (isset($_POST["email"]) && $error_email) {
                if ($_POST["email"] == "")
                    echo "<span class='error'> Campo vacío </span>";
                elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
                    echo "<span class='error'> E-mail no válido</span>";
                else
                    echo "<span class='error'>E-mail ya en uso</span>";
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