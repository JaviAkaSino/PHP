<?php
if (isset($_POST["boton_submit"])) {

    $error_num =  $_POST["edad"] == "" || !is_numeric($_POST["edad"]);
    $error_tipo = !isset($_POST["tipo"]);
    $error_form = $error_num || $error_tipo;
}

if (isset($_POST["boton_reset"]))
    $_POST = array();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ejercicio 8 Formularios - Javier Parodi</title>
</head>

<body>
    <h1>Entradas de cine</h1>
    <form action="formulario8.php" method="post">
        <p>
            <label for="edad">Introduzca su edad: </label>
            <input type="text" name="edad" id="edad" value="<?php if (isset($_POST["edad"])) echo $_POST["edad"]; ?>">
            <?php

            if (isset($_POST["boton_submit"]) && $error_num) {

                if ($_POST["edad"] == "")
                    echo "<span class='error'>* Campo vacío *</span>";
                else
                    echo "<span class='error'>* Introduce un número válido *</span>";
            }
            ?>
        </p>
        <p>
            <input type="radio" name="tipo" value="estudiante" id="estudiante" <?php if (isset($_POST["tipo"]) && $_POST["tipo"] == "estudiante") echo "checked"; ?>>
            <label for="estudiante"> Estudiante</label>
            <input type="radio" name="tipo" value="normal" id="normal" <?php if (isset($_POST["tipo"]) && $_POST["tipo"] == "normal") echo "checked"; ?>>
            <label for="normal"> No estudiante</label>
        </p>
        <p>
            <?php
            if (isset($_POST["boton_submit"]) && $error_tipo)
                echo "<p>Debe elegir si es estudiante o no</p>"
            ?>
            <select id="cantidad" name="cantidad">
                <option id="1" value="1" <?php if (isset($_POST["cantidad"]) && $_POST["cantidad"] == 1) echo "selected"; ?>>1</option>
                <option id="2" value="2" <?php if (isset($_POST["cantidad"]) && $_POST["cantidad"] == 2) echo "selected"; ?>>2</option>
                <option id="3" value="3" <?php if (isset($_POST["cantidad"]) && $_POST["cantidad"] == 3) echo "selected"; ?>>3</option>
                <option id="4" value="4" <?php if (isset($_POST["cantidad"]) && $_POST["cantidad"] == 4) echo "selected"; ?>>4</option>
                <option id="5" value="5" <?php if (isset($_POST["cantidad"]) && $_POST["cantidad"] == 5) echo "selected"; ?>>5</option>
            </select>
        </p>

        <p>
            <button type="submit" name="boton_submit">Calcular</button>
            <button type="submit" name="boton_reset">Borrar</button>
        </p>

    </form>

    <?php
    if (isset($_POST["boton_submit"]) && !$error_form) {

        echo "<h3>TOTAL:</h3>";

        if ($_POST["edad"] < 12 || $_POST["tipo"] == "estudiante")
            echo $_POST["cantidad"] . " entrada/s de precio reducido son " . $_POST["cantidad"] * 3.50 . " €";
        else
            echo $_POST["cantidad"] . " entrada/s normales son " . $_POST["cantidad"] * 5 . " €";
    }
    ?>

</body>

</html>