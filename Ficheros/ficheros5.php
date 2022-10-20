<!--Realizar una web que abra el fichero con información sobre el PIB per cápita
    de los países de la Unión Europea y muestre todo el contenido en una tabla, (
    url: http://dwese.icarosproject.com/PHP/datos_ficheros.txt).
    NOTA: Los datos del fichero datos_ficheros.txt vienen separados por un
    tabulador (“\t”)-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Ejercicio Ficheros 5 - Javier Parodi</title>
    <style>
        table,
        th,
        td {
            border: 2px solid black;
            border-collapse: collapse;
            padding: 10px 5px;
        }
    </style>
</head>

<body>
    <h1>PIB per cápita UE</h1>

    <?php
    @$fd = fopen("http://dwese.icarosproject.com/PHP/datos_ficheros.txt", "r");

    if (!$fd)
        die("<p>No se ha podido leer el fichero</p>");


    echo "<table>";
    echo "<caption>PIB per cápita de todos los países de la Unión Europea</caption>";

    $linea = fgets($fd);
    $datos_linea = explode("\t", $linea);
    $num_col = count($datos_linea);

    echo "<tr>";
    foreach ($datos_linea as $i => $v) {
        echo "<th>" . $v . "</th>";
    }
    echo "</tr>";

    while ($linea = fgets($fd)) {

        echo "<tr>";
        $datos_linea = explode("\t", $linea);

        echo "<th>".$datos_linea[0]."</th>";

        for ($i=1; $i < $num_col; $i++) {

            if (isset($datos_linea[$i]))
                echo "<td>" . $datos_linea[$i] . "</td>";
            else
                echo "<td></td>";
        }
        echo "</tr>";
    }

    echo "</table>";

    fclose($fd);

    ?>





</body>

</html>