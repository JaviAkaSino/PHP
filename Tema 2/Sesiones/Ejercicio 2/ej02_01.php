<?php
session_name("ej02");
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Sesiones - Ejercicio 2</title>
    <style>
        label {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h2>FORMULARIO NOMBRE 1 (FORMULARIO)</h2>

    <svg version="1.1" xmlns=http://www.w3.org/2000/svg width="600px" height="20px" viewbox="-300 0 600 20">
        <line x1="-300" y1="10" x2="300" y2="10" stroke="black" stroke-width="5" />
        <circle cx="0" cy="10" r="8" fill="red" />
    </svg>


    <form action="ej02_02.php" method="post">
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