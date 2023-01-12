<?php

if (isset($_POST["boton_login"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_form = $error_usuario || $error_clave;

    $error_login = false;

    if (!$error_form) {

        //CONEXION
        try {
            $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        } catch (Exception $e) {

            die(error_page("Login con PDO", "Login con PDO", "Imposible conectar. Error: " . $e->getMessage()));
        }

        //CONSULTA

        try {

            $consulta = "SELECT * FROM usuarios WHERE usuario=? and clave =?";
            $sentencia = $conexion->prepare($consulta);
            $datos[] = $_POST["usuario"];
            $datos[] = md5($_POST["clave"]);
            $sentencia->execute($datos);

            if ($sentencia->rowCount() > 0) {

                $_SESSION["usuario"] = $datos[0];
                $_SESSION["clave"] = $datos[1];
                $_SESSION["ultimo_acceso"] = time();

                header("Location:index.php");
            } else {
                $error_login = true;
                "<span class='error'>Usuario o contraseña incorrectos</span>";
            }
        } catch (PDOException $e) {

            $sentencia = null; //Libera sentencia
            $conexion = null; //Cierra conexión
            die("<p>Imposible realizar la consulta. Error: " . $e->getMessage() . "</p></body></html>");
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login con PDO - Javier Parodi Piñero</title>
</head>

<body>
    <h1>Login con PDO</h1>

    <?php

    if (isset($_SESSION["seguridad"])) { //Si hay baneo o expirada

        echo "<p class='mensaje'>" . $_SESSION["seguridad"] . "</p>";
        unset($_SESSION["seguridad"]);
    }

    ?>

    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" id="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"] ?>">
            <?php if (isset($_POST["usuario"]) && $error_usuario)
                echo "<span class='error'>* Campo vacío</span>" ?>
        </p>
        <p>
            <label for="clave">Contraseña:</label>
            <input type="password" name="clave" id="clave">
            <?php if (isset($_POST["clave"]) && $error_clave)
                echo "<span class='error'>* Campo vacío</span>" ?>
        </p>

        <?php
        if (isset($_POST["boton_login"]) && $error_login)
            echo "<p><span class='error'>* Usuario o contraseña incorrectos</span></p>"
        ?>

        <p>
            <button type="submit" name="boton_login">Login</button>
        </p>

    </form>
</body>

</html>