<?php
if (isset($_POST["boton_submit"])) {

    $error_form = $_FILES["archivo"]["name"] == "" || $_FILES["archivo"]["error"] || $_FILES["archivo"]["type"] != "text/plain" ||  $_FILES["archivo"]["size"] > 1000000;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Horario - Javier Parodi</title>
</head>

<body>
    <h1>Ejercicio 4</h1>
    <?php
    @$file = fopen("Horario/horarios.txt", "r");
    if (!$file) {

    ?>
        <h2>No se encuentra el archivo <em>Horario/horarios.txt</em></h2>
        <form action="ejercicio4.php" method="post" enctype="multipart/form-data">
            <p>
                <label for="archivo">Introduzca la ruta del fichero .txt inferior a 1 MB</label>
                <input type="file" name="archivo" id="archivo">

                <?php
                if (isset($_POST["boton_submit"]) && $error_form) {

                    if ($_FILES["archivo"]["name"] != "") {

                        if ($_FILES["archivo"]["error"])
                            echo "<span class='error'>Error subiendo el archivo al servidor</span>";
                        elseif ($_FILES["archivo"]["type"] != "text/plain")
                            echo "<span class='error'>No ha seleccionado un archivo .txt</span>";
                        else
                            echo "<span class='error'>El archivo es demasiado grande</span>";
                    }
                }
                ?>

            </p>
            <p><button type="submit" name="boton_submit">Subir</button></p>
        </form>

        <?php
        if (isset($_POST["boton_submit"]) && !$error_form) {

            @$var = move_uploaded_file($_FILES["archivo"]["tmp_name"], "Horario/horarios.txt");

            if (!$var) {

                echo "<p>El archivo no ha podido guardarse por falta de permisos</p>";
            } else {

                echo "<h2>El archivo se ha copiado a la carpeta de destino</h2>";
            }
        }
    } else {

        ?>

        <h2>Horario de los Profesores</h2>
        <form action="ejercicio4.php" method="post" enctype="multipart/form-data">
            <label for='profesor'>Horario del Profesor: </label>
            <select id='profesor' name='profesor'>
                <?php
                while ($linea = fgets($file)) {
                    $fila_datos = explode("\t", $linea);
                    if (isset($_POST["profesor"]) && $_POST["profesor"] == $fila_datos[0]) {
                        $profesor = $fila_datos[0];
                        echo "<option selected value='" . $profesor . "'>" . $profesor . "</option>";
                    } else
                    echo "<option value='" . $profesor . "'>" . $profesor . "</option>";
                }
                ?>
            </select>
            <button type="submit" name="boton_horario">Ver Horario</button>
        </form>


    <?php


    }
    ?>


</body>

</html>