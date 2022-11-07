<?php
if (isset($_POST["boton_submit"])) {

    $error_form = $_POST["num"] == "" || !is_numeric($_POST["num"]) || $_POST["num"] < 1 || $_POST["num"] > 10;
}
?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ejercicio de Ficheros 2 - Javier Parodi</title>
</head>

<body>
    <h1>Ejercicio 2 Ficheros</h1>
    <form action="ficheros2.php" method="post">
        <p>
            <label for="num">Introduzca un número entre 1 y 10 (ambos inclusive)</label>
            <input type="text" name="num" id="num" value="<?php if (isset($_POST["num"])) echo $_POST["num"]; ?>" />
            <?php
            if (isset($_POST["num"]) && $error_form) {

                if ($_POST["num"] == "")
                    echo "<span class='error'>* Campo vacío *</span>";
                else
                    echo "<span class='error'>* No has introducido un número correcto *</span>";
            }
            ?>
        </p>
        <p><button type="submit" name="boton_submit">Generar</button></p>
    </form>

    <?php
    if (isset($_POST["num"]) && !$error_form) {

        echo "<h2>Ejercicio realizado</h2>";

        @$fd = fopen("tablas/tabla_" . $_POST["num"] . ".txt", "r");

        if (!$fd)
            die("<p>No se ha podido leer el fichero 'tabla_" . $_POST["num"] . ".txt'</p>");

        echo "<h2>Tabla del " . $_POST["num"] . "</h2>";

        while ($linea = fgets($fd))
            echo "<p>" . $linea . "</p>";

        fclose($fd);
    }
    ?>
</body>

</html>