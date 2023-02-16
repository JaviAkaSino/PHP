<?php

$url = DIR_SERV . "/logueado";

$respuesta = consumir_servicios_REST($url, "POST", $_SESSION["api_session"]);
$obj = json_decode($respuesta);
if (!$obj) {
    //Añadir el salir de la api
    $url = DIR_SERV . "/salir";
    consumir_servicios_rest($url, "POST", $_SESSION["api_session"]);
    session_destroy();
    die(error_page("Examen4 PHP", "<h1>Examen4 PHP</h1><p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta));
}
if (isset($obj->error)) {
    //Añadir el salir de la api
    $url = DIR_SERV . "/salir";
    consumir_servicios_rest($url, "POST", $_SESSION["api_session"]);
    session_destroy();
    die(error_page("Examen4 PHP", "<h1>Examen4 PHP</h1><p>" . $obj->error . "</p>"));
}

if (isset($obj->no_login)) {
    //NO hay que salir, sólo unset
    session_unset();
    //Seguridad y salto
    $_SESSION["seguridad"] = "Tiempo de sessión de la API excedido";
    header("Location:index.php");
    exit;
}

if (isset($obj->mensaje)) {
    $url_salir = DIR_SERV . "/salir"; //Cerramos api sesion
    consumir_servicios_rest($url_salir, "POST", $_SESSION["api_session"]);

    session_unset();
    //Seguridad y salto, NO DIE, tiene que salir el login
    $_SESSION["seguridad"] = "Usted ya no se encuentra registrado en la BD";
    header("Location:index.php");
    exit;
} else {

    $datos_usuario_log = $obj->usuario;
}

if (time() - $_SESSION["ultimo_acceso"] > MINUTOS * 60) {

    

    //Cerramos sesion API
    $url = DIR_SERV . "/salir";
    consumir_servicios_rest($url, "POST", $_SESSION["api_session"]);
    //Unset de la sesión normal
    session_unset();
    $_SESSION["seguridad"] = "Su tiempo de sesión ha caducado. Vuelva a loguearse o registrarse";
    //Mandamos al login
    header("Location:index.php");
    exit;
}


$_SESSION["ultimo_acceso"] = time();
