<?php

function texto_array($separador, $texto)
{

    $lista = [];
    $i = 0;
    $palabra = "";

    while (isset($texto[$i])) {

        if ($texto[$i] != $separador) {

            $palabra .= $texto[$i];
        } else {
            if ($palabra != "") {

                $lista[] = $palabra;
                $palabra = "";
            }
        }

        $i++;
    }

    if ($palabra != "")
        $lista[] = $palabra; //Ultima palabra

    return $lista;
}


if (isset($_POST["boton_submit"])) {

    $error_form = $_FILES["archivo"]["name"] == "" || $_FILES["archivo"]["error"] || $_FILES["archivo"]["type"] != "text/plain" ||  $_FILES["archivo"]["size"] > 1000000;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Horario - Javier Parodi</title>
    <style>
        table,
        td,
        th {
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
        }

        th {
            background-color: #bbb;
        }
    </style>
</head>

<body>
    <h1>Ejercicio 4</h1>
    <?php
    @$file = fopen("Horario/horarios.txt", "r");
    if (!$file) {

    ?>
        <h2>No se encuentra el archivo <em>Horario/horarios.txt</em></h2>
        <form action="ejercicio4.php" method="post" enctype="multipart/form-data">
            <p>
                <label for="archivo">Introduzca la ruta del fichero .txt inferior a 1 MB</label>
                <input type="file" name="archivo" id="archivo" accept=".txt">

                <?php
                if (isset($_POST["boton_submit"]) && $error_form) {

                    if ($_FILES["archivo"]["name"] != "") {

                        if ($_FILES["archivo"]["error"])
                            echo "<span class='error'>Error subiendo el archivo al servidor</span>";
                        elseif ($_FILES["archivo"]["type"] != "text/plain")
                            echo "<span class='error'>No ha seleccionado un archivo .txt</span>";
                        else
                            echo "<span class='error'>El archivo es demasiado grande</span>";
                    }
                }
                ?>

            </p>
            <p><button type="submit" name="boton_submit">Subir</button></p>
        </form>

        <?php
        if (isset($_POST["boton_submit"]) && !$error_form) {

            @$var = move_uploaded_file($_FILES["archivo"]["tmp_name"], "Horario/horarios.txt");

            if (!$var) {

                echo "<p>El archivo no ha podido guardarse por falta de permisos</p>";
            } else {

                echo "<h2>El archivo se ha copiado a la carpeta de destino</h2>";
            }
        }
    } else {

        ?>

        <h2>Horario de los Profesores</h2>
        <p>
        <form action="ejercicio4.php" method="post" enctype="multipart/form-data">
            <label for='profesor'>Selecciona el Profesor: </label>
            <select id='profesor' name='profesor'>
                <?php
                while ($linea = fgets($file)) {
                    $fila_datos = texto_array("\t", $linea);
                    if (isset($_POST["profesor"]) && $_POST["profesor"] == $fila_datos[0]) {
                        echo "<option selected value='" . $fila_datos[0] . "'>" . $fila_datos[0] . "</option>";
                        $profesor = $fila_datos[0];
                    } else {
                        echo "<option value='" . $fila_datos[0] . "'>" . $fila_datos[0] . "</option>";
                    }

                    for ($i = 1; $i < count($fila_datos); $i += 3) {
                        if (isset($horario[$fila_datos[0]][$fila_datos[$i]][$fila_datos[$i + 1]]))
                            $horario[$fila_datos[0]][$fila_datos[$i]][$fila_datos[$i + 1]] .= " / " . $fila_datos[$i + 2];
                        else
                            $horario[$fila_datos[0]][$fila_datos[$i]][$fila_datos[$i + 1]] = $fila_datos[$i + 2];
                    }
                }
                ?>
            </select>
            <button type="submit" name="boton_horario">Ver Horario</button>
        </form>
        </p>
        <?php
        if (isset($_POST["boton_horario"])) {
            $horas[1] = "8:15 - 9:15";
            $horas[] = "9:15 - 10:15";
            $horas[] = "10:15 - 11:15";
            $horas[] = "11:15 - 11:45";
            $horas[] = "11:45 - 12:45";
            $horas[] = "12:45 - 13:45";
            $horas[] = "13:45 - 14:45";

            echo "<h3>Horario del profesor: " . $profesor . "</h3>";
            echo "<table class='tabla'>";
            echo "<tr>
                        <th></th>
                        <th>Lunes</th>
                        <th>Martes</th>
                        <th>Miércoles</th>
                        <th>Jueves</th>
                        <th>Viernes</th>
                    </tr>";

            for ($hora = 1; $hora <= 7; $hora++) {

                echo "<tr>";
                echo "<th>" . $horas[$hora] . "</th>";
                if ($hora == 4) {
                    echo "<td colspan='5'>RECREO</td>";
                } else {

                    for ($dia = 1; $dia <= 5; $dia++) {
                        if (isset($horario[$profesor][$dia][$hora])) {
                            echo "<td>" . $horario[$profesor][$dia][$hora] . "</td>";
                        } else {
                            echo "<td></td>";
                        }
                    }
                }
                echo "</tr>";
            }

            echo "</table>";
        }


        ?>

    <?php

        fclose($file);
    }
    ?>


</body>

</html>