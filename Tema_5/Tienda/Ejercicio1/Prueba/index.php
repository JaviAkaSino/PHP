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

    define("DIR_SERV", "http://localhost/PHP/Tema_5/Ejercicio1/servicios_rest");

    //LISTAR PRODUCTOS

    $url = DIR_SERV . "/productos";

    $respuesta = consumir_servicios_rest($url, "GET");

    $obj = json_decode($respuesta);

    if (!$obj)
        die("<p>Error consumiendo el servicio REST: " . $url . "</p>" . $respuesta . "</body></html>");

    //Si falla la bd
    if (isset($obj->mensaje_error))
        die("<p>" . $obj->mensaje_error . "</p></body></html>");


    echo "<p>Número de productos: " . count($obj->productos) . "</p>";


    echo "<table>";
    echo "<tr><th>Código</th><th>Nombre</th><th>PVP</th></tr>";
    foreach ($obj->productos as $tupla) {

        echo "<tr>";
        echo "<td>" . $tupla->cod . "</td>";
        echo "<td>" . $tupla->nombre_corto . "</td>";
        echo "<td>" . $tupla->PVP . "</td>";
        echo "</tr>";
    }
    echo "</table><hr/>";



    //BUSCAR UN PRODUCTO

    $url = DIR_SERV . "/producto/3DSNG";

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
        echo "<p><strong>Nombre corto: </strong>" . $obj->producto->nombre_corto . "</p><hr/>";



    //INSERTAR UN PRODUCTO

    $datos_insert["cod"] = "MIAU";
    $datos_insert["nombre"] = "Mechero Iluminador Automático Ultravioleta";
    $datos_insert["nombre_corto"] = "Mecheraso";
    $datos_insert["descripcion"] = "Mechero con linterna y UV, eléctrico";
    $datos_insert["PVP"] = "19.95";
    $datos_insert["familia"] = "MULTIF";

    $url = DIR_SERV . "/producto/insertar";

    $respuesta = consumir_servicios_rest($url, "POST", $datos_insert);

    $obj = json_decode($respuesta);

    if (!$obj)
        die("<p>Error consumiendo el servicio REST: " . $url . "</p>" . $respuesta . "</body></html>");

    //Si falla la bd
    if (isset($obj->mensaje_error))
        die("<p>" . $obj->mensaje_error . "</p></body></html>");
    else
        echo "<p>El producto con código " . $obj->mensaje . " ha sido insertado con éxito</p><hr/>";



    //EDITAR UN PRODUCTO

    $datos_update["nombre"] = "Mechero Iluminador Automático Ultravioleta";
    $datos_update["nombre_corto"] = "Mecheraso PROMO";
    $datos_update["descripcion"] = "Mechero con linterna y UV, eléctrico";
    $datos_update["PVP"] = "10.95";
    $datos_update["familia"] = "MULTIF";

    $url = DIR_SERV . "/producto/actualizar/MIAU";

    $respuesta = consumir_servicios_rest($url, "PUT", $datos_update);

    $obj = json_decode($respuesta);

    if (!$obj)
        die("<p>Error consumiendo el servicio REST: " . $url . "</p>" . $respuesta . "</body></html>");

    //Si falla la bd
    if (isset($obj->mensaje_error))
        die("<p>" . $obj->mensaje_error . "</p></body></html>");
    else
        echo "<p>El producto con código " . $obj->mensaje . " ha sido editado con éxito</p><hr/>";




    //BORRAR UN PRODUCTO

    $url = DIR_SERV . "/producto/borrar/MIAU";

    $respuesta = consumir_servicios_rest($url, "DELETE");

    $obj = json_decode($respuesta);

    if (!$obj)
        die("<p>Error consumiendo el servicio REST: " . $url . "</p>" . $respuesta . "</body></html>");

    //Si falla la bd
    if (isset($obj->mensaje_error))
        die("<p>" . $obj->mensaje_error . "</p></body></html>");
    else
        echo "<p>El producto con código " . $obj->mensaje . " ha sido borrado con éxito</p><hr/>";



    //LISTAR FAMILIAS

    $url = DIR_SERV . "/familias";

    $respuesta = consumir_servicios_rest($url, "GET");

    $obj = json_decode($respuesta);

    if (!$obj)
        die("<p>Error consumiendo el servicio REST: " . $url . "</p>" . $respuesta . "</body></html>");

    //Si falla la bd
    if (isset($obj->mensaje_error))
        die("<p>" . $obj->mensaje_error . "</p></body></html>");


    echo "<p>Número de familias: " . count($obj->familias) . "</p>";


    echo "<table>";
    echo "<tr><th>Código</th><th>Nombre</th></tr>";
    foreach ($obj->familias as $tupla) {

        echo "<tr>";
        echo "<td>" . $tupla->cod . "</td>";
        echo "<td>" . $tupla->nombre . "</td>";
        echo "</tr>";
    }
    echo "</table><hr/>";

    
    //BUSCAR UNA FAMILIA

    $url = DIR_SERV . "/familia/CAMARA";

    $respuesta = consumir_servicios_rest($url, "GET");

    $obj = json_decode($respuesta);

    if (!$obj)
        die("<p>Error consumiendo el servicio REST: " . $url . "</p>" . $respuesta . "</body></html>");

    //Si falla la bd
    if (isset($obj->mensaje_error))
        die("<p>" . $obj->mensaje_error . "</p></body></html>");

    if (!$obj->familia)
        echo "<p>La familia solicitada no se encuentra en la BD</p>";
    else
        echo "<p><strong>Nombre: </strong>" . $obj->familia->nombre . "</p><hr/>";




    //BUSCAR UN REPETIDO

    $url = DIR_SERV . "/repet_insert/producto/cod/3DSNG";

    $respuesta = consumir_servicios_rest($url, "GET");

    $obj = json_decode($respuesta);

    if (!$obj)
        die("<p>Error consumiendo el servicio REST: " . $url . "</p>" . $respuesta . "</body></html>");

    //Si falla la bd
    if (isset($obj->mensaje_error))
        die("<p>" . $obj->mensaje_error . "</p></body></html>");

    if ($obj->repetido)
        echo "<p>El producto está repetido</p>";
    else
        echo "<p>El producto no está repetido</p><hr/>";






    ?>
</body>

</html>