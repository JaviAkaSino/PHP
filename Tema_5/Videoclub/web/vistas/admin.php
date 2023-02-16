<?php


/***************************CONFIRMAR NUEVO*******************/

if (isset($_POST["boton_confirmar_nuevo"])) {

    $error_user = $_POST["user"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_foto = $_FILES["foto"]["name"] != "" && ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500000);

    if (!$error_user) { //Se mira el repetido

        $url = DIR_SERV . "/repetido_insert/clientes/usuario/" . $_POST["user"];
        $respuesta = consumir_servicios_rest($url, "POST", $_SESSION["api_session"]);
        $obj = json_decode($respuesta);

        if (!$obj) {
            $url_salir = DIR_SERV . "/salir";
            consumir_servicios_rest($url, "POST", $_SESSION["api_session"]);
            session_destroy();
            die(pag_error("Error consumiendo servicio REST: " . $url . "<br/>" . $respuesta));
        }

        if (isset($obj->error)) {
            $url_salir = DIR_SERV . "/salir";
            consumir_servicios_rest($url, "POST", $_SESSION["api_session"]);
            session_destroy();
            die(pag_error($obj->error));
        }
        if (isset($obj->no_login)) {
            session_unset();
            $_SESSION["seguridad"] = "Tiempo excedido de la API";
            header("Location:index.php");
            exit;
        }

        $error_user = $obj->repetido;
    }

    $error_form = $error_user || $error_clave || $error_foto;

    if (!$error_form) {

        $datos_insert["user"] = $_POST["user"];
        $datos_insert["clave"] = $_POST["clave"];
        $datos_insert["foto"] = $_FILES["foto"];

        $datos_insert["api_session"] = $_SESSION["api_session"]["api_session"];

        $url = DIR_SERV . "/nuevo";
        $respuesta = consumir_servicios_rest($url, "POST", $datos_insert);
        $obj = json_decode($respuesta);

        if (!$obj) {
            $url_salir = DIR_SERV . "/salir";
            consumir_servicios_rest($url, "POST", $_SESSION["api_session"]);
            session_destroy();
            die(pag_error("Error consumiendo servicio REST: " . $url . "<br/>" . $respuesta));
        }

        if (isset($obj->error)) {
            $url_salir = DIR_SERV . "/salir";
            consumir_servicios_rest($url, "POST", $_SESSION["api_session"]);
            session_destroy();
            die(pag_error($obj->error));
        }
        if (isset($obj->no_login)) {
            session_unset();
            $_SESSION["seguridad"] = "Tiempo excedido de la API";
            header("Location:index.php");
            exit;
        }

        $_SESSION["mensaje_accion"] = $obj->mensaje;
        header("Location:index.php");
        exit;
    }
}


?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Videoclub - NORMAL</title>
    <style>
        .enlace {
            border: none;
            background: none;
            color: #FF600A;
            cursor: pointer;
            font-weight: bold;
        }

        .linea {
            display: inline
        }


        table,
        td,
        th {
            border-collapse: collapse;
            border: 1px solid black;
            text-align: center;
        }

        th {
            background-color: #FF600A;
        }
    </style>
</head>

<body>
    <h1>Videoclub - NORMAL</h1>

    <div>Bienvenido/a, <strong><?php echo $_SESSION["usuario"] ?></strong>
        <form class="linea" action="index.php" metohd="post">
            <button class="enlace" type="submit" name="boton_salir">Salir</button>
        </form>
    </div>

    <?php

    // MENSAJE ACCION

    if (isset($_SESSION["mensaje_accion"])) {
        echo "<p>" . $_SESSION["mensaje_accion"] . "</p>";
        unset($_SESSION["mensaje_accion"]);
    }


    //DATOS CLIENTE
    if (isset($_POST["boton_info"])) {

        require "admin/info.php";
    }

    //AÑADIR CLIENTE

    if (isset($_POST["boton_nuevo"]) || (isset($_POST["boton_confirmar_nuevo"]) && $error_form)) {

        require "admin/nuevo.php";
    }




    //TABLA CLIENTES

    require "admin/tabla.php";


    ?>
</body>

</html>