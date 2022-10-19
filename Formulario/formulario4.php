<?php

function error_num($num)
{

    return $num == "" || !is_numeric($num);
}

if (isset($_POST["boton_submit"])) {

    $error_form = error_num($_POST["num1"]) || error_num($_POST["num2"]);
}
?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ejercicio de Formularios 4 - Javier Parodi</title>
</head>

<body>
    <h1>Ejercicio 4 Formularios</h1>
    <form action="formulario4.php" method="post">
        <p>
            <label for="num1">Introduzca un número</label>
            <input type="text" name="num1" id="num1" value="<?php if (isset($_POST["num1"])) echo $_POST["num1"]; ?>" />
            <?php
            if (isset($_POST["num1"]) && $error_form) {

                if ($_POST["num1"] == "")
                    echo "<span class='error'>* Campo vacío *</span>";
                else
                    echo "<span class='error'>* No has introducido un número *</span>";
            }
            ?>
        </p>
        <p>
            <label for="num2">Introduzca otro número</label>
            <input type="text" name="num2" id="num2" value="<?php if (isset($_POST["num2"])) echo $_POST["num2"]; ?>" />
            <?php
            if (isset($_POST["num2"]) && $error_form) {

                if ($_POST["num2"] == "")
                    echo "<span class='error'>* Campo vacío *</span>";
                else
                    echo "<span class='error'>* No has introducido un número *</span>";
            }
            ?>
        </p>
        <p><button type="submit" name="boton_submit">Calcular</button></p>
    </form>

    <?php
    if (isset($_POST["boton_submit"]) && !$error_form) {

        echo "<h2>Resultados: </h2>";

        echo "<p><strong>Valor 1: </strong>".$_POST["num1"]."</p>";
        echo "<p><strong>Valor 2: </strong>".$_POST["num2"]."</p>";
        echo "<p><strong>Suma: </strong>".$_POST["num1"]+$_POST["num2"]."</p>";
        echo "<p><strong>Resta: </strong>".$_POST["num1"]-$_POST["num2"]."</p>";
        echo "<p><strong>Producto: </strong>".$_POST["num1"]*$_POST["num2"]."</p>";
        echo "<p><strong>Cociente: </strong>".$_POST["num1"]/$_POST["num2"]."</p>";
        echo "<p><strong>Módulo: </strong>".$_POST["num1"]%$_POST["num2"]."</p>";
    }
    ?>
</body>

</html>