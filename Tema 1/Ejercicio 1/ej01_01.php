<?php
session_name("ej01");
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Sesiones - Ejercicio 1</title>
    <style>
        label {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h2>FORMULARIO NOMBRE 1 (FORMULARIO)</h2>
    <form action="ej01_02.php" method="post">
        <?php
        if (isset($_SESSION["nombre"]))
            echo "<p>Su nombre es: <strong>" . $_SESSION['nombre'] . "</strong></p>"
        ?>
        <p>Escriba su nombre</p>
        <p>
            <label for="nombre">Nombre: </label>
            <input type="text" name="nombre" id="nombre" />
            <?php
            if (isset($_SESSION["error"])) {
                echo "<span class='error'>" . $_SESSION["error"] . "</span>";
                unset($_SESSION["error"]);
            }
            ?>
        </p>
        <p>
            <button type="submit" name="boton_siguiente">Siguiente</button>
            <button type="submit" name="boton_borrar">Borrar</button>
        </p>
    </form>
</body>

</html>