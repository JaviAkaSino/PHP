<?php

$url = DIR_SERV . "/clientes";
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

echo "<h2>
            Listado de los clientes (" . count($obj->clientes) . ")
            <form class='linea' method='post'><button name='boton_nuevo' class='enlace'> [+] </button></form>
        </h2>";




echo "<table>";
echo "<tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Foto</th>
            <th>Acción</th>
        </tr>";

foreach ($obj->clientes as $tupla) {

    echo "<tr>
                <th>" . $tupla->id_cliente . "</th>
                <td><form action='index.php' method='post'><button class='enlace' name='boton_info' value='$tupla->id_cliente'>" . $tupla->usuario . "</button></form></td>
                <td><img src='img/" . $tupla->foto . "' width='100px' height='auto'/></td>
                <td>
                    <form action='index.php' method='post'>
                        <button class='enlace' name='boton_editar' value='" . $tupla->id_cliente . "'>Editar</button>
                        <span> - </span>
                        <button class='enlace' name='boton_borrar' value='" . $tupla->id_cliente . "'>Borrar</button>
                    </form>
                </td>
            </tr>";
}
echo "</table>";
