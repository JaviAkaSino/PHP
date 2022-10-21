<?php
if (isset($_POST["boton_submit"])) {

    $error_form = $_FILES["ruta"]["name"] == "" || $_FILES["ruta"]["error"] || $_FILES["ruta"]["type"] != "text/plain" ||  $_FILES["ruta"]["size"] > 25 * 100000;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ejercicio de Ficheros 4 - Javier Parodi</title>
</head>

<body>
    <h1>Ejercicio 4 Ficheros</h1>
    <form action="ficheros4.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="ruta">Introduzca la ruta del fichero .txt inferior a 2.5 MB para contar sus palabras</label>
            <input type="file" name="ruta" id="ruta" accept=".txt" />
            <?php
            if (isset($_POST["boton_submit"]) && $error_form) {

                if ($_FILES["ruta"]["name"] != "") {

                    if ($_FILES["ruta"]["error"])
                        echo "<span class='error'>Error subiendo el archivo al servidor</span>";
                    elseif ($_FILES["ruta"]["type"] != "text/plain")
                        echo "<span class='error'>No ha seleccionado un archivo .txt</span>";
                    else
                        echo "<span class='error'>El archivo es demasiado grande</span>";
                }
            }
            ?>
        </p>
        <p><button type="submit" name="boton_submit">Contar</button></p>
    </form>

    <?php
    if (isset($_POST["boton_submit"]) && !$error_form) {

        $numero_palabras = str_word_count(file_get_contents($_FILES["ruta"]["tmp_name"]));
        echo "<h2>Número de palabras: " . $numero_palabras . "</h2>";
    }
    ?>
</body>

</html>