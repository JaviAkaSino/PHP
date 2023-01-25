<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Teoría Servicios WEB</h1>
    <?php
    //Versión a utilizar
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

    define("DIR_SERV", "http://localhost/PHP/Tema_5/Intro/servicios_rest_teor");

    //VERSION 1 - SÓLO VALE PARA GET
    //urlencode para cuando haya espacios
    @$respuesta = file_get_contents(DIR_SERV . "/saludo");

    $obj = json_decode($respuesta);

    if (!$obj)
        die("<p>Error consumiendo el servicio: " . DIR_SERV . "/saludo</p>" . $respuesta . "</body></html>");

    echo "<p>" . $obj->mensaje . "</p><hr/>";


    //VERSION 2 - VALE PARA OTROS MÉTODOS

    $respuesta = consumir_servicios_rest(DIR_SERV . "/saludo/" . urlencode("Juan Pablo"), "GET");

    $obj = json_decode($respuesta);

    if (!$obj)
        die("<p>Error consumiendo el servicio: " . DIR_SERV . "/saludo</p>" . $respuesta . "</body></html>");

    echo "<p>" . $obj->mensaje . "</p><hr/>";

    //POST

    $datos_post["datos1"] = "María";
    $datos_post["datos2"] = "Pedro Miguel";

    $respuesta = consumir_servicios_rest(DIR_SERV . "/saludo", "POST", $datos_post);

    $obj = json_decode($respuesta);

    if (!$obj)
        die("<p>Error consumiendo el servicio: " . DIR_SERV . "/saludo</p>" . $respuesta . "</body></html>");

    echo "<p>" . $obj->mensaje . "</p><hr/>";

    ?>
</body>

</html>