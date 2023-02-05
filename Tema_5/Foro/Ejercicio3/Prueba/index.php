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

function pag_error($titulo, $cabecera, $mensaje)
{
    return '<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . $titulo . '</title>
    </head>
    <body>
        <h1>' . $cabecera . '</h1>
        <p>' . $mensaje . '</p>
    </body>
    </html>';
}

define("DIR_SERV", "http://localhost/PHP/Tema_5/Foro/login_restful");

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pueba REST - Foro</title>
</head>

<body>

    <?php

    //LISTA PRODUCTOS

    $url = DIR_SERV . "/usuarios";

    $respuesta = consumir_servicios_rest($url, "GET");

    $obj = json_decode($respuesta);

    if (!$obj) { //Si falla el servicio REST
        die("<p>Error al consumir el servicio REST: " . $url . "</p>" . $respuesta . " </body></html>");
    }

    if (isset($obj->error))
        die("<p>" . $obj->error . "</p></body></html>");

    foreach ($obj->usuarios as $tupla){

        echo "<p>".$tupla->nombre."</p>";
    }





    ?>

</body>

</html>