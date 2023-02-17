<?php
if (isset($_POST["boton_entrar"])) {

    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";

    $error_form = $error_usuario || $error_clave;

    if (!$error_form) {

        $datos_login["lector"] = $_POST["usuario"];
        $datos_login["clave"] = md5($_POST["clave"]);

        $url = DIR_SERV . "/login";
        $respuesta = consumir_servicios_REST($url, "POST", $datos_login);
        $obj = json_decode($respuesta);


        if (!$obj) {

            die(error_page("Página de Inicio", "Librería", "Error consumiendo servicios REST: " . $url . "<br/>" . $respuesta));
        }

        if (isset($obj->error)) {

            die(error_page("Página de Inicio", "Librería", $obj->error));
        }

        if (isset($obj->mensaje)) {

            $error_usuario = true;
        } else {

            $_SESSION["usuario"] = $datos_login["lector"];
            $_SESSION["clave"] = $datos_login["clave"];
            $_SESSION["ultimo_acceso"] = time();

            $_SESSION["api_session"]["api_session"] = $obj->api_session;

            header("Location:index.php");
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
    <title>Página Inicio</title>
    <style>
        #contenido {
            display: flex;
            flex-flow: row wrap;
        }
        .info-libro {
            width: 33%;
            display: flex;
            flex-flow: row wrap;
            justify-content: center;
        }
        .foto-libro{
            width: 80%;
        }
    </style>
</head>

<body>
    <h1>Librería</h1>

    <form action="index.php" method="post">

        <p>
            <label for="usuario">Nombre de usuario: </label>
            <input type="text" name="usuario" id="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"] ?>" />
            <?php
            if (isset($_POST["boton_entrar"]) && $error_usuario) {
                if ($_POST["usuario"] == "")
                    echo "* Campo vacío";
                else
                    echo "Usuario y/o contraseña incorrecto/s";
            } ?>
        </p>

        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave" id="clave" />
            <?php
            if (isset($_POST["boton_entrar"]) && $error_clave) {
                echo "* Campo vacío";
            } ?>
        </p>
        <p>
            <button type="submit" name="boton_entrar">Entrar</button>
        </p>
    </form>

    <?php

    if (isset($_SESSION["seguridad"])) {
        echo $_SESSION["seguridad"];
        unset($_SESSION["seguridad"]);
    }


    //LISTA LIBROS

    echo "<h2>Listado de los Libros</h2>";



    $url = DIR_SERV . "/obtenerLibros";
    $respuesta = consumir_servicios_REST($url, "GET");
    $obj = json_decode($respuesta);

    if (!$obj) {

        die(error_page("Página de Inicio", "Librería", "Error consumiendo servicios REST: " . $url . "<br/>" . $respuesta));
    }

    if (isset($obj->error)) {

        die(error_page("Página de Inicio", "Librería", $obj->error));
    }

    echo "<div id='contenido'>";

    foreach ($obj->libros as $tupla) {

        echo "<p class= 'info-libro'>
                <img class='foto-libro' src='images/" . $tupla->portada . "' alt='" . $tupla->portada . "'/>
                <span>
                    " . $tupla->titulo . " - " . $tupla->precio . " €
                </span>
            </p>";
    }
    echo "</div>";
    ?>


</body>

</html>