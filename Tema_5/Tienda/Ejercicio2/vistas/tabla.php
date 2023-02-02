<?php
$url = DIR_SERV . "/productos";
$respuesta = consumir_servicios_rest($url, "GET");

$obj = json_decode($respuesta);

if (!$obj) {
    die("<p>Error consumiendo el servicio REST: " . $url . "</p>" . $respuesta . "</body></html>");
}

//Si falla la bd
if (isset($obj->mensaje_error))
    die("<p>" . $obj->mensaje_error . "</p></body></html>");


echo "<table class='centro texto-centrado'>";
echo "<tr>
<th>Código</th>
<th>Nombre</th>
<th>PVP</th>
<th><form action='index.php' method='post'><label for='boton_nuevo'>Producto</label><button name='boton_nuevo' id='boton_nuevo'>[+]</button></form></th></tr>";
foreach ($obj->productos as $tupla) {

    echo "<tr>";
    echo "<td><form action='index.php' method='post'><button name='boton_producto' value='" . $tupla->cod . "' class='enlace'>" . $tupla->cod . "</button></form></td>";
    echo "<td>" . $tupla->nombre_corto . "</td>";
    echo "<td>" . $tupla->PVP . "</td>";
    echo "<td><form action='index.php' method='post'>
        <button type='submit' name='boton_borrar' value='" . $tupla->cod . "' class='enlace' >Borrar</button>
         - 
        <button type='submit' name='boton_editar' value='" . $tupla->cod . "' class='enlace'>Editar</button>
    </form></td>";
    echo "</tr>";
}
echo "</table>";
