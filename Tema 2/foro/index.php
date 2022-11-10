<?php
require "src/bd_config.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Foro</title>
    <style>
        table,
        td,
        th {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;

        }

        .texto-centrado {
            text-align: center;
        }

        .centrar {
            margin: 1em auto;
            width: 80%;
        }

        table img {
            width: 50px;
        }
    </style>
</head>

<body>
    <h1 class="texto-centrado">Listado de usuarios</h1>
    <?php

    try {

        $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_foro");
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {

        die("<p>Imposible conectar. Error Nº " . mysqli_connect_errno() . ": " . mysqli_connect_error() . "</p>");
    }


    $consulta = "SELECT * FROM usuarios";

    try {

        $resultado = mysqli_query($conexion, $consulta);
        echo "<table class='texto-centrado centrar'>";
        echo "<tr><th>Nombre de Usuario</th></th>Borrar</th><th>Editar</th></tr>";
        while ($tupla = mysqli_fetch_assoc($resultado)) {
            echo "<tr><td>" . $tupla["usuario"] . "</td>";
            echo "<td><img src='img/delete.png' alt='borrar' title='borrar'/></td>";
            echo "<td><img src='img/edit.png' alt='editar' title='editar'/></td></tr>";
        }
        echo "</table>";

        mysqli_free_result($resultado);
        mysqli_close($conexion);
    } catch (Exception $e) {
        $mensaje = "Imposible conectar; Error nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
        mysqli_close($conexion); //Cierra conexión
        die($mensaje);
    }

    ?>

    <button type='submit'>Nuevo usuario</button>
</body>

</html>