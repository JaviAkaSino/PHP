<?php

if (isset($_POST["boton_login"])) {

    //Comprobamos errores

    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";

    $error_form = $error_usuario || $error_clave;

    if (!$error_form) {

        //Array ASOCIATIVO
        $datos_login["usuario"] = $_POST["usuario"];
        $datos_login["clave"] = md5($_POST["clave"]);

        $url = DIR_SERV . "/login";
        $respuesta = consumir_servicios_rest($url, "POST", $datos_login);
        $obj = json_decode($respuesta);
        if (!$obj) {

            die(pag_error("Error al consumir servicios REST: " . $url . "<br/>" . $respuesta));
        }

        if (isset($obj->error)) {

            die(pag_error($obj->error));
        }

        if (isset($obj->mensaje)) { //User o clave incorrectas

            $error_usuario = true; //Para que de error y vuelva al form

        } else { //Si está todo OK

            $_SESSION["usuario"] = $datos_login["usuario"]; //Guarda user y clave en api normal
            $_SESSION["clave"] = $datos_login["clave"];
            $_SESSION["ultimo_acceso"] = time(); //Tiempo de sesión
            //Guarda la sesión de la api
            $_SESSION["api_session"]["api_session"] = $obj->api_session;

            header("Location:index.php"); //Salto a index
            exit;
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
    <title>Videoclub - Login</title>
</head>

<body>
    <h1>Videoclub - Login</h1>

    <form action="index.php" method="post">

        <p>
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario" id="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"] ?>" />
            <?php if (isset($_POST["boton_login"]) && $error_usuario) {
                if ($_POST["usuario"] == "")
                    echo "<span class='error'>* Campo vacío</span>";
                else
                    echo "<span class='error'>" . $obj->mensaje . "</span>";
            }
            ?>
        </p>

        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave" id="clave" />
            <?php if (isset($_POST["boton_login"]) && $error_clave)
                echo "<span class='error'>* Campo vacío</span>";
            ?>
        </p>

        <p>
            <button type="submit" name="boton_login">Entrar</button>
        </p>

    </form>
    <?php

    //SEGURIDAD

    if (isset($_SESSION["seguridad"])) {
        echo "<p>" . $_SESSION["seguridad"] ."</p>";
        session_destroy(); //Destruye la sesión, para borrar mensaje y datos
    }

    ?>

</body>

</html>