<?php



if (isset($_POST["boton_entrar"])) {

    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";

    $error_form = $error_usuario || $error_clave;

    if (!$error_form) {

        try {
            $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        } catch (PDOException $e) {
            die(pag_error("Imposible conectar. Error: " . $e->getMessage()));
        }

        try {

            $consulta = "SELECT * FROM clientes WHERE usuario = ? AND clave = ?";

            $sentencia = $conexion->prepare($consulta);
            $datos_login[] = $_POST["usuario"];
            $datos_login[] = md5($_POST["clave"]);

            $sentencia->execute($datos_login);

            if ($sentencia->rowCount() > 0) { //Si lo encuentra

                $_SESSION["usuario"] = $datos_login[0];
                $_SESSION["clave"] = $datos_login[1];
                $_SESSION["ultimo_acceso"] = time();

                $sentencia = null;
                $conexion = null;

                header("Location:index.php");
                exit;
            } else {

                $error_form = true;
            }
        } catch (PDOException $e) {

            $conexion = null;
            $sentencia = null;
            die(pag_error("Imposible realizar consulta. Error: " . $e->getMessage()));
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
    <title>Videoclub</title>
</head>

<body>
    <h1>Videoclub</h1>

    <form action="index.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="usuario">Nombre de usuario: </label>
            <input type="text" name="usuario" id="usuario" value='<?php if (isset($_POST["usuario"])) echo $_POST["usuario"]; ?>'>
            <?php if (isset($_POST["boton_entrar"]) && $error_usuario)
                echo "<span class='error'>*Campo vacío</span>"; ?>
        </p>
        <p>
            <label for="clave">Clave: </label>
            <input type="password" name="clave" id="clave" value='<?php if (isset($_POST["clave"])) echo $_POST["clave"]; ?>'>
            <?php if (isset($_POST["boton_entrar"]) && $error_clave)
                echo "<span class='error'>*Campo vacío</span>"; ?>
        </p>
        <p>
            <?php if (isset($_POST["boton_entrar"]) && !$error_usuario && !$error_clave && $error_form)
                echo "<span class='error'>Usuario o contraseña no válidos</span>" ?>

            <?php if (isset($_SESSION["seguridad"]))
                echo "<span>" . $_SESSION["seguridad"] . "</span>"; ?>

        </p>
        <p>

            <button type="submit" name='boton_entrar'>Entrar</button>
            <button type="submit" name='boton_registro'>Registrarse</button>
        </p>







    </form>
</body>

</html>