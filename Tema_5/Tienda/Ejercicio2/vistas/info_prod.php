<?php

echo "<div class='centro'>";



echo "<h2>Información del producto " . $_POST["boton_producto"] . "</h2>";

$url = DIR_SERV . "/producto/" . urlencode($_POST["boton_producto"]);
$respuesta = consumir_servicios_rest($url, "GET");
$obj = json_decode($respuesta);

if (isset($obj->mensaje_error))
    die("<p>Error consumiendo el servicio REST: " . $url . "</p>" . $respuesta . "</div></body></html>");

if (!$obj->producto)
    echo "<p>El producto ya no se encuentra en la BD</p>";

else {

    /************ LLAMAR A LA FAMILIA ************/

    $url = DIR_SERV . "/familia/" . urlencode($obj->producto->familia);
    $respuesta = consumir_servicios_rest($url, "GET");
    $obj2 = json_decode($respuesta);

    if (isset($obj2->mensaje_error))
        die("<p>Error consumiendo el servicio REST: " . $url . "</p>" . $respuesta . "</div></body></html>");

    if (!$obj2->familia)
        $familia = $obj2->producto->familia;

    else {
        $familia = $obj2->familia->nombre;
    }

    echo "<p><strong>Nombre: </strong>" . $obj->producto->nombre . "</p>";
    echo "<p><strong>Nombre corto: </strong>" . $obj->producto->nombre_corto . "</p>";
    echo "<p><strong>Descripción: </strong>" . $obj->producto->descripcion . "</p>";
    echo "<p><strong>P.V.P.: </strong>" . $obj->producto->PVP . "€</p>";
    echo "<p><strong>Familia: </strong>" . $familia . "</p>";
}
echo "</div>";
