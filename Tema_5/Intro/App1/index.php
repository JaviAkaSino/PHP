<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría Servicios WEB</title>
</head>

<body>
    <?php
    $url = "http://dwese.icarosproject.com/Guardias/guardias_rest/grupos/1";

    //Devuelve un String de toda la página (en este caso un JSON)
    @$respuesta = file_get_contents($url);

    //Decodifica el JSON, si no, da false
    $obj = json_decode($respuesta);

    //Si no coge el JSON, die con el error
    if (!$obj)
        die("<p>Error consumiendo el servicio: " . $url . "</p></body></html>");

    //Si lo coge, lista
    echo "<h1>Listado de los grupos del IES Mar de Alborán</h1>";
    echo "<table>";
    echo "<tr><th>#ID</th><th>Nombres</th></tr>";

    foreach ($obj->grupos as $grupos) {
        echo "<tr><td>" . $grupos->id_grupo . "</td><td>" . $grupos->nombre . "</td></tr>";
    }

    echo "</table>";


    ?>
</body>

</html>