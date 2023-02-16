<?php

$url = DIR_SERV . "/info/" . $_POST["boton_info"];
$respuesta = consumir_servicios_rest($url, "GET", $_SESSION["api_session"]);
$obj = json_decode($respuesta);

if (!$obj) {
    $url_salir = DIR_SERV . "/salir";
    consumir_servicios_rest($url_salir, "POST", $_SESSION["api_session"]);
    session_destroy();
    die("<p>Error al consumir servicio REST: " . $url . "</p>" . $respuesta . "</body></html>");
}

if (isset($obj->error)) {
    $url_salir = DIR_SERV . "/salir";
    consumir_servicios_rest($url_salir, "POST", $_SESSION["api_session"]);
    session_destroy();
    die("<p>" . $obj->error . "</p></body></html>");
}

if (isset($obj->no_login)) {

    session_destroy();
    die("<p>El tiempo de sesión de la API ha expirado. Vuelva a loguearse</p></body></html>");
}

echo "<p>ID: <strong>" . $obj->cliente->id_cliente . "</strong></p>";
echo "<p>Usuario: <strong>" . $obj->cliente->usuario . "</strong></p>";
echo "<p>Nombre foto: <strong>" . $obj->cliente->foto . "</strong></p>";

