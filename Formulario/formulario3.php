<?php
if (isset($_POST["boton_submit"])) {

    $error_form = $_POST["cantidad"] == "" || !is_numeric($_POST["cantidad"]);
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ejercicio 3 Formularios - Javier Parodi</title>
</head>

<body>
    <h1>Cantidad de cuadernos</h1>
    <table border="2px solid black">
        <tr>
            <th>Cantidad</th>
            <th>Precio unitario</th>
        </tr>
        <tr>
            <th>menos de 10</th>
            <td>2 €</td>
        </tr>
        <tr>
            <th>entre 10 y 30</th>
            <td>1.5 €</td>
        </tr>
        <tr>
            <th>mas de 30</th>
            <td>1 €</td>
        </tr>
    </table>
    <form action="formulario3.php" method="post">
        <p>
            <label for="cantidad">Cantidad de cuadernos a comprar: </label>
            <input type="text" name="cantidad" id="cantidad" value="<?php if (isset($_POST["cantidad"])) echo $_POST["cantidad"]; ?>">
            <?php

            if (isset($_POST["boton_submit"]) && $error_form) {

                if ($_POST["cantidad"] == "")
                    echo "<span class='error'>* Campo vacío *</span>";
                else
                    echo "<span class='error'>* Introduce un número entero *</span>";
            }
            ?>
        </p>
        <p>
            <button type="submit" name="boton_submit">Calcular</button>
        </p>
    </form>

    <?php
    if (isset($_POST["boton_submit"]) && !$error_form) {

        echo "<h3>Precio total:</h3>";

        if ($_POST["cantidad"] < 10)
            echo $_POST["cantidad"] * 2 . " €";
        elseif ($_POST["cantidad"] > 30)
            echo $_POST["cantidad"] . " €";
        else
            echo $_POST["cantidad"] * 1.5 . " €";
    }
    ?>

</body>

</html>