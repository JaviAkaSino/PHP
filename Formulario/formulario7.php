<?php
if (isset($_POST["boton_submit"])) {

    $error_num =  $_POST["euros"] == "" || !is_numeric($_POST["euros"]);
    $error_divisa = !isset($_POST["divisa"]);
    $error_form = $error_num || $error_divisa;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ejercicio 7 Formularios - Javier Parodi</title>
</head>

<body>
    <h1>Euros a pesetas o dólares</h1>
    <form action="formulario7.php" method="post">
        <p>
            <label for="euros">Introduzca una cantidad en euros: </label>
            <input type="text" name="euros" id="euros" value="<?php if (isset($_POST["euros"])) echo $_POST["euros"]; ?>">
            <?php

            if (isset($_POST["boton_submit"]) && $error_num) {

                if ($_POST["euros"] == "")
                    echo "<span class='error'>* Campo vacío *</span>";
                else
                    echo "<span class='error'>* Introduce un número válido *</span>";
            }
            ?>
        </p>
        <p>
            <input type="radio" name="divisa" value="pes" id="pes" <?php if (isset($_POST["divisa"]) && $_POST["divisa"] == "pes") echo "checked"; ?>>
            <label for="pes"> Pesetas</label>
        </p>
        <p>
            <input type="radio" name="divisa" value="dol" id="dol" <?php if (isset($_POST["divisa"]) && $_POST["divisa"] == "dol") echo "checked"; ?>>
            <label for="dol"> Dólares</label>
        </p>
        <?php
        if (isset($_POST["boton_submit"]) && $error_divisa)
            echo "<p>Debe elegir una divisa a la cual pasar los €</p>"
        ?>
        <p>
            <button type="submit" name="boton_submit">Calcular</button>
        </p>

    </form>

    <?php
    if (isset($_POST["boton_submit"]) && !$error_form) {

        echo "<h3>Conversión:</h3>";

        if ($_POST["divisa"] == "pes")
            echo $_POST["euros"] . " € son " . $_POST["euros"] * 166.39 . " pesetas";
        else
            echo $_POST["euros"] . " € son " . $_POST["euros"] * 0.98 . " $";
    }
    ?>

</body>

</html>