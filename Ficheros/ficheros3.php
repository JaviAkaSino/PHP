<?php

function error_num($num)
{

    return $num == "" || !is_numeric($num) || $num < 1 || $num > 10;
}

if (isset($_POST["boton_submit"])) {

    $error_form = error_num($_POST["num1"]) || error_num($_POST["num2"]);
}
?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ejercicio de Ficheros 3 - Javier Parodi</title>
</head>

<body>
    <h1>Ejercicio 3 Ficheros</h1>
    <form action="ficheros3.php" method="post">
        <p>
            <label for="num1">Introduzca un número entre 1 y 10 (ambos inclusive)</label>
            <input type="text" name="num1" id="num1" value="<?php if (isset($_POST["num1"])) echo $_POST["num1"]; ?>" />
            <?php
            if (isset($_POST["num1"]) && $error_form) {

                if ($_POST["num1"] == "")
                    echo "<span class='error'>* Campo vacío *</span>";
                else
                    echo "<span class='error'>* No has introducido un número correcto *</span>";
            }
            ?>
        </p>
        <p>
            <label for="num2">Introduzca un número entre 1 y 10 (ambos inclusive)</label>
            <input type="text" name="num2" id="num2" value="<?php if (isset($_POST["num2"])) echo $_POST["num2"]; ?>" />
            <?php
            if (isset($_POST["num2"]) && $error_form) {

                if ($_POST["num2"] == "")
                    echo "<span class='error'>* Campo vacío *</span>";
                else
                    echo "<span class='error'>* No has introducido un número correcto *</span>";
            }
            ?>
        </p>
        <p><button type="submit" name="boton_submit">Generar</button></p>
    </form>

    <?php
    if (isset($_POST["boton_submit"]) && !$error_form) {

        echo "<h2>Ejercicio realizado</h2>";

        @$fd = fopen("tablas/tabla_" . $_POST["num1"] . ".txt", "r");

        if (!$fd)
            die("<p>No se ha podido leer el fichero 'tabla_" . $_POST["num1"] . ".txt'</p>");

        echo "<h2>" . $_POST["num1"] . " X " . $_POST["num2"] . ": </h2>";

        $i = 1;
        while ($i <= $_POST["num2"]) {

            $linea = fgets($fd);
            $i++;
        }


        echo "<p>" . $linea . "</p>";

        fclose($fd);
    }
    ?>
</body>

</html>