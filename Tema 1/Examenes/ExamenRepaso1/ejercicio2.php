<?php
if (isset($_POST["boton_submit"])) {

    $error_form = $_FILES["ruta"]["name"] == "" || $_FILES["ruta"]["error"] || $_FILES["ruta"]["type"] != "text/plain" ||  $_FILES["ruta"]["size"] > 1000000;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Subida txt - Javier Parodi</title>
</head>

<body>
    <h1>Subida fichero .txt</h1>
    <form action="ejercicio2.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="ruta">Introduzca la ruta del fichero .txt inferior a 1 MB</label>
            <input type="file" name="ruta" id="ruta" accept=".txt" />
            <?php
            if (isset($_POST["boton_submit"])) {

                if ($error_form) {

                    if ($_FILES["ruta"]["name"] != "") {

                        if ($_FILES["ruta"]["error"])
                            echo "<span class='error'>Error subiendo el archivo al servidor</span>";
                        elseif ($_FILES["ruta"]["type"] != "text/plain")
                            echo "<span class='error'>No ha seleccionado un archivo .txt</span>";
                        else
                            echo "<span class='error'>El archivo es demasiado grande</span>";
                    }
                } else {

                    @$var = move_uploaded_file($_FILES["ruta"]["tmp_name"], "Ficheros/archivo.txt");

                    if (!$var) {

                        echo "<p>El archivo no ha podido guardarse por falta de permisos</p>";
                    } else {

                        echo "<h2>El archivo se ha copiado a la carpeta de destino</h2>";
                    }
                }
            }


            ?>
        </p>
        <p><button type="submit" name="boton_submit">Enviar</button></p>
    </form>
</body>

</html>