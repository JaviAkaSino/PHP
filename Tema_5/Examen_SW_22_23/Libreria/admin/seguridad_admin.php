<?php

$url = DIR_SERV . "/logueado";
$respuesta = consumir_servicios_REST($url, "GET", $_SESSION["api_session"]);
$obj = json_decode($respuesta);


if (!$obj) {
    $url_salir = DIR_SERV . "/salir";
    consumir_servicios_REST($url_salir, "POST", $_SESSION["api_session"]);
    session_destroy();
    die(error_page("Página de Inicio", "Librería", "Error consumiendo servicios REST: " . $url . "<br/>" . $respuesta));
}

if (isset($obj->error)) {
    $url_salir = DIR_SERV . "/salir";
    consumir_servicios_REST($url_salir, "POST", $_SESSION["api_session"]);
    session_destroy();
    die(error_page("Página de Inicio", "Librería", $obj->error));
}

if (isset($obj->no_auth)) {
    session_unset();
    $_SESSION["seguridad"] = $obj->no_auth;
    header("Location:../index.php");
    exit;
}

if (isset($obj->mensaje)) {
    $_SESSION["seguridad"] = "Ya no se encuentra en la BD";

    header("Location:../index.php");
    exit;
} else {

    $datos_usuario_log = $obj->usuario;


    //Controla el tiempo

    if (time() - $_SESSION["ultimo_acceso"] > MINUTOS * 60) {
        $url_salir = DIR_SERV . "/salir";
        consumir_servicios_REST($url_salir, "POST", $_SESSION["api_session"]);

        session_unset();
        $_SESSION["seguridad"] = "Tiempo de sesión excedido";
    } // A Partir de aqui todo OK

    $_SESSION["ultimo_acceso"] = time();
}
