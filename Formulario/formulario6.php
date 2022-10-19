<?php
if (isset($_POST["boton_submit"])) {

    $error_form = $_POST["euros"] == "" || !is_numeric($_POST["euros"]);
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ejercicio 6 Formularios - Javier Parodi</title>
</head>

<body>
    <h1>Euros a pesetas</h1>
    <form action="formulario6.php" method="post">
        <p>
            <label for="euros">Introduzca una cantidad en euros: </label>
            <input type="text" name="euros" id="euros" value="<?php if (isset($_POST["euros"])) echo $_POST["euros"]; ?>">
            <?php

            if (isset($_POST["boton_submit"]) && $error_form) {

                if ($_POST["euros"] == "")
                    echo "<span class='error'>* Campo vacío *</span>";
                else
                    echo "<span class='error'>* Introduce un número válido *</span>";
            }
            ?>
        </p>
        <p>
            <button type="submit" name="boton_submit">Calcular</button>
        </p>
    </form>

    <?php
    if (isset($_POST["boton_submit"]) && !$error_form) {

        echo "<h3>Conversión:</h3>";

        echo $_POST["euros"] . " € son " . $_POST["euros"] * 166.39 . " pesetas";
    }
    ?>

</body>

</html>