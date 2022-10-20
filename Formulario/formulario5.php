<?php

if (isset($_POST["boton_submit"])) {

    $error_nombre = $_POST["nombre"] == "";
    $error_apellidos = $_POST["apellidos"] == "";
    $error_calle = $_POST["calle"] == "";
    $error_localidad = $_POST["localidad"] == "";
    $error_cp = $_POST["cp"] == "" || strlen($_POST["cp"]) != 5 || !is_numeric($_POST["cp"]);
    $error_form = $error_nombre || $error_apellidos || $error_calle || $error_localidad || $error_cp;
}
?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ejercicio de Formularios 5 - Javier Parodi</title>
</head>

<body>
    <h1>Ejercicio 5 Formularios</h1>
    <form action="formulario5.php" method="post">
        <p>
            <label for="nombre">Nombre: </label>
            <input type="text" name="nombre" id="nombre" value="<?php if (isset($_POST["nombre"])) echo $_POST["nombre"]; ?>" />
            <?php
            if (isset($_POST["nombre"]) && $error_nombre) {

                echo "<span class='error'>* Campo vacío *</span>";
            }
            ?>
        </p>
        <p>
            <label for="apellidos">Apellidos: </label>
            <input type="text" name="apellidos" id="apellidos" value="<?php if (isset($_POST["apellidos"])) echo $_POST["apellidos"]; ?>" />
            <?php
            if (isset($_POST["apellidos"]) && $error_apellidos) {

                echo "<span class='error'>* Campo vacío *</span>";
            }
            ?>
        </p>
        <p>
            <label for="calle">Calle: </label>
            <input type="text" name="calle" id="calle" value="<?php if (isset($_POST["calle"])) echo $_POST["calle"]; ?>" />
            <?php
            if (isset($_POST["calle"]) && $error_calle) {

                echo "<span class='error'>* Campo vacío *</span>";
            }
            ?>
        </p>
        <p>
            <label for="cp">Código Postal: </label>
            <input type="text" name="cp" id="cp" value="<?php if (isset($_POST["cp"])) echo $_POST["cp"]; ?>" />
            <?php
            if (isset($_POST["cp"]) && $error_cp) {

                if ($_POST["cp"] == "")
                    echo "<span class='error'>* Campo vacío *</span>";
                else
                    echo "<span class='error'>* CP no válido *</span>";
            }
            ?>
        </p>
        <p>
            <label for="localidad">Localidad: </label>
            <input type="text" name="localidad" id="localidad" value="<?php if (isset($_POST["localidad"])) echo $_POST["localidad"]; ?>" />
            <?php
            if (isset($_POST["localidad"]) && $error_localidad) {

                echo "<span class='error'>* Campo vacío *</span>";
            }
            ?>
        </p>

        <p><button type="submit" name="boton_submit">Calcular</button></p>
    </form>

    <?php
    if (isset($_POST["boton_submit"]) && !$error_form) {

        echo "<h2>Resultados: </h2>";

        echo "<p><strong>Nombre: </strong>" . $_POST["nombre"] . "</p>";
        echo "<p><strong>Apellidos: </strong>" . $_POST["apellidos"] . "</p>";
        echo "<p><strong>Calle: </strong>" . $_POST["calle"] . "</p>";
        echo "<p><strong>Código Postal: </strong>" . $_POST["cp"] . "</p>";
        echo "<p><strong>Localidad: </strong>" . $_POST["localidad"] . "</p>";
    }
    ?>
</body>

</html>