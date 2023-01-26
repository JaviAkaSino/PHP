<?php

function consumir_servicios_rest($url, $metodo, $datos = null)
{
    $llamada = curl_init(); //Prepara para hacer la llamada
    curl_setopt($llamada, CURLOPT_URL, $url);
    curl_setopt($llamada, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($llamada, CURLOPT_CUSTOMREQUEST, $metodo);

    if (isset($datos))
        curl_setopt($llamada, CURLOPT_POSTFIELDS, http_build_query($datos));

    $respuesta = curl_exec($llamada); //Ejecuta la llamada
    curl_close($llamada); //Cierra 

    return $respuesta;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba tienda</title>
</head>

<body>
    <h1>Listado de los productos</h1>
    <?php
    //Lista productos

    $url = "http://localhost/PHP/Tema_5/Tienda/servicios_rest/productos";

    $respuesta = consumir_servicios_rest($url, "GET");

    $obj = json_decode($respuesta);

    if (!$obj)
        die("<p>Error consumiendo el servicio REST: " . $url . "</p>" . $respuesta . "</body></html>");

    //Si falla la bd
    if (isset($obj->mensaje_error))
        die("<p>" . $obj->mensaje_error . "</p></body></html>");


    echo "<p>Número de productos: " . count($obj->productos) . "</p>";


    echo "<table>";
    echo "<tr><th>Nombre</th><th>PVP</th></tr>";
    foreach ($obj->productos as $tupla) {

        echo "<tr>";
        echo "<td>" . $tupla->nombre_corto . "</td>";
        echo "<td>" . $tupla->PVP . "</td>";
        echo "</tr>";
    }
    echo "</table>";



    ///////////////

    $url = "http://localhost/PHP/Tema_5/Tienda/servicios_rest/producto/3DSNG";

    $respuesta = consumir_servicios_rest($url, "GET");

    $obj = json_decode($respuesta);

    if (!$obj)
        die("<p>Error consumiendo el servicio REST: " . $url . "</p>" . $respuesta . "</body></html>");

    //Si falla la bd
    if (isset($obj->mensaje_error))
        die("<p>" . $obj->mensaje_error . "</p></body></html>");

    if (!$obj->producto)
        echo "<p>El producto solicitado no se encuentra en la BD</p>";
    else
        echo "<p><strong>Nombre corto: </strong>" . $obj->producto->nombre_corto . "</p>";





    ?>
</body>

</html>