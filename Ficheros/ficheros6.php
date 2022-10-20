<!--Modificar el ejercicio anterior realizando una web con un formulario que contenga un select con las iniciales de un país y muestre el PIB per cápita de
todos los años disponibles del país seleccionado.-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Ejercicio Ficheros 6 - Javier Parodi</title>
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
    <h1>PIB per cápita de los países de la Unión Europea</h1>
    <form method='post' action='ficheros6.php'>
        <p>

            <?php
            @$fd = fopen("http://dwese.icarosproject.com/PHP/datos_ficheros.txt", "r");

            if (!$fd)
                die("<p>No se ha podido leer el fichero</p>");


            $linea = fgets($fd);

            echo "<label for'zona'><strong>Seleccione una zona: </strong></label>";

            echo "<select name='zona' id='zona'>";

            $i = 1;
            while ($linea = fgets($fd)) {

                $datos_linea = explode("\t", $linea);
                $datos_zona = explode(",", $datos_linea[0]);
                $codigo_zona = end($datos_zona);
                if (isset($_POST["boton_submit"]) && $_POST["zona"] == $codigo_zona)
                    echo "<option value = '" . $codigo_zona . "' selected>" . $codigo_zona . "</option>";
                else
                    echo "<option value = '" . $codigo_zona . "'>" . $codigo_zona . " </option>";
            }
            echo "</select>";

            fclose($fd);
            ?>

        </p>
        <p>
            <button type="submit" name="boton_submit">Consultar</button>
        </p>

    </form>

    <?php

    if (isset($_POST["boton_submit"])) {

        @$fd = fopen("http://dwese.icarosproject.com/PHP/datos_ficheros.txt", "r");

        if (!$fd)
            die("<p>No se ha podido leer el fichero</p>");

        echo "<table>";
        echo "<caption>PIB per cápita de " . $_POST["zona"] . "</caption>";

        $linea = fgets($fd);
        $datos_linea = explode("\t", $linea);
        $num_col = count($datos_linea);

        echo "<tr>";
        for ($i = 0; $i < $num_col; $i++) {
            echo "<th>" . $datos_linea[$i] . "</th>";
        }
        echo "</tr>";




        while ($linea = fgets($fd)) {

            $datos_linea = explode("\t", $linea);
            $datos_zona = explode(",", $datos_linea[0]);
            $codigo_zona = end($datos_zona);

            if ($codigo_zona == $_POST["zona"]) {

                echo "<tr>";
                echo "<th>" . $datos_linea[0] . "</th>";

                for ($i = 1; $i < $num_col; $i++) {
                    if (isset($datos_linea[$i]))
                        echo "<td>" . $datos_linea[$i] . "</td>";
                    else
                        echo "<td></td>";
                }
                echo "</tr>";
            }
        }

        echo "</table>";
    }

    fclose($fd);

    ?>





</body>

</html>