<?php

$datos_seguridad["usuario"] = $_SESSION["usuario"];
$datos_seguridad["clave"] = $_SESSION["clave"];

$url = DIR_SERV . "/login";

$respuesta = consumir_servicios_rest($url, "POST", $datos_seguridad);

$obj = json_decode($respuesta);

if (!$obj) //Fallo servicio
    die(pag_error("Error consumiendo el servicio: " . $url . "<br/>" . $respuesta));

if (isset($obj->error)) //Falla algo de la BD
    die(pag_error("Problema con la BD. Error: " . $obj->error));

if (isset($obj->mensaje)) { //BANEADO

    session_unset();
    $_SESSION["seguridad"] = "Ha sido baneado. No se encuentra en la BD";
    header("Location:index.php");
    exit;
    
} else { //Sigue logado correctamente

    $datos_usuario_log = $obj->usuario; //Guardamos los datos
}

if (time() - $_SESSION["ultimo_acceso"] > MINUTOS * 60) { //Comprobamos el tiempo

    $_SESSION["seguridad"] = "Su tiempo de sesión ha expirado";
} else {
    $_SESSION["ultimo_acceso"] = time();
}
