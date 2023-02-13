<?php

/************************************* CONFIRMA NUEVO ***********************************/
if (isset($_POST["boton_confirmar_nuevo"])) {

    $error_nombre = $_POST["nombre"] == "";
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_email = $_POST["email"] == "" || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);

    if (!$error_usuario) {
        $url = DIR_SERV . "/repetido_insert/usuarios/usuario/" . urlencode($_POST["usuario"]);
        $respuesta = consumir_servicios_rest($url, "GET", $key);
        $obj = json_decode($respuesta);

        if (!$obj) {
            $url = DIR_SERV . "/salir";
            consumir_servicios_rest($url, "POST", $key);
            session_destroy();
            die(pag_error("Error consumiendo el servicio REST: " . $url . "</p>" . $respuesta));
        }

        if (isset($obj->mensaje_error)) {
            $url = DIR_SERV . "/salir";
            consumir_servicios_rest($url, "POST", $key);
            session_destroy();
            die(pag_error($obj->mensaje_error));
        }

        if (isset($obj->no_login)) {
            session_unset();
            $_SESSION["seguridad"] = "El tiempo de sesión de la API ha expirado.";
            header("Location:index.php");
            exit;
        }

        $error_usuario = $obj->repetido;
    }

    if (!$error_email) {

        $url = DIR_SERV . "/repetido_insert/usuarios/email/" . urlencode($_POST["email"]);
        $respuesta = consumir_servicios_rest($url, "GET", $key);
        $obj = json_decode($respuesta);

        if (!$obj) {
            $url = DIR_SERV . "/salir";
            consumir_servicios_rest($url, "POST", $key);
            session_destroy();
            die(pag_error("Error consumiendo el servicio REST: " . $url . "</p>" . $respuesta));
        }

        if (isset($obj->error)) {
            $url = DIR_SERV . "/salir";
            consumir_servicios_rest($url, "POST", $key);
            session_destroy();
            die(pag_error($obj->error));
        }

        if (isset($obj->no_login)) {
            session_unset();
            $_SESSION["seguridad"] = "El tiempo de sesión de la API ha expirado.";
            header("Location:index.php");
            exit;
        }

        $error_email = $obj->repetido;
    }

    $error_form = $error_nombre || $error_usuario || $error_clave || $error_email;

    if (!$error_form) {

        $datos_insert["nombre"] = $_POST["nombre"];
        $datos_insert["usuario"] = $_POST["usuario"];
        $datos_insert["clave"] = md5($_POST["clave"]);
        $datos_insert["email"] = $_POST["email"];
        $datos_insert["api_session"] = $_SESSION["api_session"]; //$key

        $url = DIR_SERV . "/crearUsuario";
        $respuesta = consumir_servicios_rest($url, "POST", $datos_insert);
        $obj = json_decode($respuesta);

        if (!$obj) {
            $url = DIR_SERV . "/salir";
            consumir_servicios_rest($url, "POST", $key);
            session_destroy();
            die(pag_error("Error consumiendo el servicio REST: " . $url . "</p>" . $respuesta));
        }

        if (isset($obj->error)) {
            $url = DIR_SERV . "/salir";
            consumir_servicios_rest($url, "POST", $key);
            session_destroy();
            die(pag_error($obj->error));
        }

        if (isset($obj->no_login)) {
            session_unset();
            $_SESSION["seguridad"] = "El tiempo de sesión de la API ha expirado.";
            header("Location:index.php");
            exit;
        }

        $_SESSION["mensaje_accion"] = "El usuario " . $obj->ult_id . " ha sido insertado con éxito";
        header("Location:index.php");
        exit;
    }
}

/************************************* CONFIRMA EDITAR ***********************************/
if (isset($_POST["boton_confirmar_editar"])) {

    $error_nombre = $_POST["nombre"] == "";
    $error_usuario = $_POST["usuario"] == "";
    $error_email = $_POST["email"] == "" || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);

    if (!$error_usuario) {
        $url = DIR_SERV . "/repetido_edit/usuarios/usuario/" . urlencode($_POST["usuario"]) . "/id_usuario/" . urlencode($_POST["boton_confirmar_editar"]);
        $respuesta = consumir_servicios_rest($url, "GET", $key);
        $obj = json_decode($respuesta);

        if (!$obj) {
            $url_salir = DIR_SERV . "/salir";
            consumir_servicios_rest($url_salir, "POST", $key);
            session_destroy();
            die(pag_error("Error consumiendo el servicio REST: " . $url . "</p>" . $respuesta));
        }

        if (isset($obj->mensaje_error)) {
            $url_salir = DIR_SERV . "/salir";
            consumir_servicios_rest($url_salir, "POST", $key);
            session_destroy();
            die(pag_error($obj->mensaje_error));
        }

        if (isset($obj->no_login)) {
            session_unset();
            $_SESSION["seguridad"] = "El tiempo de sesión de la API ha expirado.";
            header("Location:index.php");
            exit;
        }

        $error_usuario = $obj->repetido;
    }

    if (!$error_email) {

        $url = DIR_SERV . "/repetido_edit/usuarios/email/" . urlencode($_POST["email"]) . "/id_usuario/" . urlencode($_POST["boton_confirmar_editar"]);
        $respuesta = consumir_servicios_rest($url, "GET", $key);
        $obj = json_decode($respuesta);

        if (!$obj) {
            $url = DIR_SERV . "/salir";
            consumir_servicios_rest($url, "POST", $key);
            session_destroy();
            die(pag_error("Error consumiendo el servicio REST: " . $url . "</p>" . $respuesta));
        }

        if (isset($obj->error)) {
            $url = DIR_SERV . "/salir";
            consumir_servicios_rest($url, "POST", $key);
            session_destroy();
            die(pag_error($obj->error));
        }

        if (isset($obj->no_login)) {
            session_unset();
            $_SESSION["seguridad"] = "El tiempo de sesión de la API ha expirado.";
            header("Location:index.php");
            exit;
        }

        $error_email = $obj->repetido;
    }

    $error_form = $error_nombre || $error_usuario  || $error_email;

    if (!$error_form) {

        $datos_update["nombre"] = $_POST["nombre"];
        $datos_update["usuario"] = $_POST["usuario"];
        if ($_POST["clave"] == "")
            $datos_update["clave"] = $_SESSION["clave"];
        else
            $datos_update["clave"] = md5($_POST["clave"]);
        $datos_update["email"] = $_POST["email"];
        $datos_update["api_session"] = $_SESSION["api_session"]; //$key

        $url = DIR_SERV . "/actualizarUsuario/" . $_POST["boton_confirmar_editar"];
        $respuesta = consumir_servicios_rest($url, "PUT", $datos_update);
        $obj = json_decode($respuesta);

        if (!$obj) {
            $url_salir = DIR_SERV . "/salir";
            consumir_servicios_rest($url_salir, "POST", $key);
            session_destroy();
            die(pag_error("Error consumiendo el servicio REST: " . $url . "</p>" . $respuesta));
        }

        if (isset($obj->error)) {
            $url_salir = DIR_SERV . "/salir";
            consumir_servicios_rest($url_salir, "POST", $key);
            session_destroy();
            die(pag_error($obj->error));
        }

        if (isset($obj->no_login)) {
            session_unset();
            $_SESSION["seguridad"] = "El tiempo de sesión de la API ha expirado.";
            header("Location:index.php");
            exit;
        }

        $_SESSION["mensaje_accion"] = $obj->mensaje;
        header("Location:index.php");
        exit;
    }
}


/************************************* CONFIRMA BORRAR ***********************************/
if (isset($_POST["boton_confirmar_borrar"])) {

    $url = DIR_SERV . "/borrarUsuario/" . $_POST["boton_confirmar_borrar"];
    $respuesta = consumir_servicios_rest($url, "DELETE", $key);
    $obj = json_decode($respuesta);

    if (!$obj) {
        $url = DIR_SERV . "/salir";
        $respuesta = consumir_servicios_rest($url, "post", $key);
        session_destroy();
        die("<p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta . "</body></html>");
    }

    if (isset($obj->error)) {
        $url = DIR_SERV . "/salir";
        $respuesta = consumir_servicios_rest($url, "post", $key);
        session_destroy();
        die("<p>" . $obj->error . "</p></body></html>");
    }

    if (isset($obj->no_login)) {
        session_unset();
        $_SESSION["seguridad"] = "El tiempo de sesión de la API ha expirado.";
        header("Location:index.php");
        exit;
    }

    $_SESSION["mensaje_accion"] = $obj->mensaje;
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
    <style>
        .linea {
            display: flex;
        }

        .enlace {
            background: none;
            border: none;
            text-decoration: underline;
            color: #FF600A;
            cursor: pointer;
            font-weight: bold;
        }

        table,
        td,
        th {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th {
            background-color: #FFA817;
        }
    </style>
    <title>Normal Servicios Web</title>
</head>

<body>
    <h1>Admin Servicios Web</h1>
    <div class="linea">
        <span>Bienvenido <strong><?php echo $datos_usuario_log->nombre ?></strong></span>
        <form action="index.php" method="post">
            <button name="boton_salir" class="enlace">Salir</button>
        </form>
    </div>

    <?php

    if (isset($_SESSION["mensaje_accion"])) {
        echo "<p>" . $_SESSION["mensaje_accion"] . "</p>";
        unset($_SESSION["mensaje_accion"]);
    }

    if (isset($_POST["boton_usuario"])) {

        require "admin/usuario.php";
    }

    if (isset($_POST["boton_nuevo"]) || (isset($_POST["boton_confirmar_nuevo"]) && $error_form)) {

        require "admin/nuevo.php";
    }

    if (isset($_POST["boton_editar"]) || (isset($_POST["boton_confirmar_editar"]) && $error_form)) {

        require "admin/editar.php";
    }


    if (isset($_POST["boton_borrar"])) {

        require "admin/borrar.php";
    }

    ?>

    <h2>Listado de los usuarios (no admin)</h2>
    <?php

    $url = DIR_SERV . "/usuarios";
    $respuesta = consumir_servicios_rest($url, "GET", $key);
    $obj = json_decode($respuesta);
    if (!$obj) {
        $url = DIR_SERV . "/salir";
        consumir_servicios_rest($url, "POST", $key);
        session_destroy();
        die("<p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta . "</body></html>");
    }
    if (isset($obj->error)) {
        $url = DIR_SERV . "/salir";
        consumir_servicios_rest($url, "POST", $key);
        session_destroy();
        die("<p>" . $obj->error . "</p></body></html>");
    }

    if (isset($obj->no_login)) {
        session_unset();
        $_SESSION["seguridad"] = "El tiempo de sesión de la API ha expirado.";
        header("Location:index.php");
        exit;
    }

    echo "<table>";
    echo "<tr><th>#ID</th><th>Nombre</th><th class='linea'>Acción - <form action='index.php' method='post'><button name='boton_nuevo' class='enlace'>Nuevo</button></form></th></tr>";
    foreach ($obj->usuarios as $tupla) {
        if ($tupla->tipo == "normal") {
            echo "<tr>";
            echo "<th>" . $tupla->id_usuario . "</th>";
            echo "<td><form action='index.php' method='post'><button name='boton_usuario' value='" . $tupla->id_usuario . "' class='enlace'>" . $tupla->nombre . "</button></form></td>";
            echo "<td>
            <form action='index.php' method='post'>
                <button name='boton_borrar' value='" . $tupla->id_usuario . "' class='enlace'>Borrar</button>
                <label> - </label>
                <button name='boton_editar' value='" . $tupla->id_usuario . "' class='enlace'>Editar</button>
            </form>";
            echo "</tr>";
        }
    }
    echo "</table>";
    ?>


</body>

</html>