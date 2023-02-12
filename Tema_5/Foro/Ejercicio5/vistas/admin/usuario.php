<?php

//Usamos el servicio

$url = DIR_SERV . "/usuario/" . urlencode($_POST["boton_usuario"]);
$respuesta = consumir_servicios_rest($url, "GET", $key);
$obj = json_decode($respuesta);

if (!$obj) { //Problema al consumir el servicio
    $url = DIR_SERV . "/salir";
    consumir_servicios_rest($url, "POST", $key); //Salimos de la api
    session_destroy();
    die("<p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta . "</body></html>");
}

if (isset($obj->error)) { //Problema conexion
    $url = DIR_SERV . "/salir";
    consumir_servicios_rest($url, "POST", $key);
    session_destroy();
    die("<p>" . $obj->error . "</p></body></html>");
}

if (isset($obj->no_login)) { //No admin/login
    session_unset();
    $_SESSION["seguridad"] = "El tiempo de sesión de la API ha expirado.";
    header("Location:index.php");
    exit;
}

echo "<p><strong>Nombre: </strong>" . $obj->usuario->nombre . "</p>";
echo "<p><strong>Usuario: </strong>" . $obj->usuario->usuario . "</p>";
echo "<p><strong>E-mail: </strong>" . $obj->usuario->email . "</p>";
