<?php

$datos_seguridad["usuario"] = $_SESSION["usuario"];
$datos_seguridad["clave"] = $_SESSION["clave"];
$datos_seguridad["api_session"] = $_SESSION["api_session"]; //Envía el numero de sesion


$url = DIR_SERV . "/logueado"; //Llama a logueado

$respuesta = consumir_servicios_rest($url, "POST", $datos_seguridad);

$obj = json_decode($respuesta);

if (!$obj) { //Fallo servicio
    $datos_salir["api_session"] = $_SESSION["api_session"];
    $url = DIR_SERV . "/salir"; //SALIR - Borrar la api_session
    $respuesta = consumir_servicios_rest($url, "POST", $datos_salir);

    session_destroy();
    die(pag_error("Error consumiendo el servicio: " . $url . "<br/>" . $respuesta));
}
if (isset($obj->error)) { //Falla algo de la BD
    $datos_salir["api_session"] = $_SESSION["api_session"];
    $url = DIR_SERV . "/salir"; //SALIR - Borrar la api_session
    $respuesta = consumir_servicios_rest($url, "POST", $datos_ssalir);
    
    session_destroy();
    die(pag_error("Problema con la BD. Error: " . $obj->error));
}

//Tiempo de sesión de la API por defecto es 24 min, si el nuestro es superior puede salirse, informar
if (isset($obj->no_login)){ //Se cierra la sesión en la API

    session_unset();
    $_SESSION["seguridad"] = "El tiempo de sesión de la API ha expirado";
    header("Location:index.php");
    exit;

}


if (isset($obj->mensaje)) { //BANEADO
    $datos_salir["api_session"] = $_SESSION["api_session"];
    $url = DIR_SERV . "/salir"; //SALIR - Borrar la api_session
    $respuesta = consumir_servicios_rest($url, "POST", $datos_salir);

    session_unset();
    $_SESSION["seguridad"] = "Ha sido baneado. No se encuentra en la BD";
    header("Location:index.php");
    exit;
} else { //Sigue logado correctamente

    $datos_usuario_log = $obj->usuario; //Guardamos los datos
}

if (time() - $_SESSION["ultimo_acceso"] > MINUTOS * 60) { //Comprobamos el tiempo
    $datos_salir["api_session"] = $_SESSION["api_session"];
    $url = DIR_SERV . "/salir"; //SALIR - Borrar la api_session
    $respuesta = consumir_servicios_rest($url, "POST", $datos_salir);

    session_unset();
    $_SESSION["seguridad"] = "Su tiempo de sesión ha expirado";
    header("Location:index.php");
    exit;
} else {
    $_SESSION["ultimo_acceso"] = time();
}
