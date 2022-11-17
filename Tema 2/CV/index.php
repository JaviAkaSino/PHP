<?php
require "src/bd_config.php";
require "src/funciones.php";

/***************************  BORRAR - CONFIRMACIÓN   **************************/

if (isset($_POST["boton_confirmar_borrar"])) {

    try {

        $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {

        pag_error("Práctica 8", "Borrar usuario", "Imposible conectar. Error Nº " .
            mysqli_connect_errno() . ": " . mysqli_connect_error());
    }

    $consulta = "DELETE FROM usuarios WHERE id_usuario = '" . $_POST["boton_confirmar_borrar"] . "'";
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Practica 8 - Javier Parodi</title>
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

        .enlace {
            border: none;
            background: none;
            text-decoration: underline;
            color: blue;
        }

        .boton-accion {

            border: none;
            background: none;
        }
    </style>
</head>

<body>
    <h1 class="texto-centrado">Práctica 8</h1>

    <?php

    if (!isset($conexion)) {
    }
    try {
        $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {

        die("<p class='centrar'>Imposible conectar. Error Nº " . mysqli_connect_errno() . ": " . mysqli_connect_error() . "</p>");
    }


    /***************************  BOTON LISTAR  **************************/

    if (isset($_POST["boton_listar"])) {

        echo "<h2>Listado del usuario " . $_POST["boton_listar"] . "</h2>";
        $consulta = "SELECT * FROM usuarios WHERE id_usuario = '" . $_POST["boton_listar"] . "'";

        try {

            $resultado = mysqli_query($conexion, $consulta);
            if (mysqli_num_rows($resultado) > 0) {

                $tupla = mysqli_fetch_assoc($resultado);

                echo "<div id='datos_listados'>";
                echo "<p><img src='Img/" . $tupla["foto"] . "' alt='Foto de perfil' title='Foto de perfil'/></p>";
                echo "<p><strong>Nombre: </strong>" . $tupla["nombre"] . "</p>";
                echo "<p><strong>Usuario: </strong>" . $tupla["usuario"] . "</p>";
                echo "<p><strong>DNI: </strong>" . $tupla["dni"] . "</p>";
                echo "<p><strong>Sexo: </strong>" . $tupla["sexo"] . "</p>";
            }
        } catch (Exception $e) {

            die("<p class='centrar'>Imposible realizar consulta. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion) . "</p>");
        }
    }


    /***************************  BOTON BORRAR  **************************/

    if (isset($_POST["boton_borrar"])) {

        echo "<div class='centrar'>";
        echo "<h3>Borrado de usuario</h3>";
        echo "<p>¿Seguro que desea borrar el usuario " . $_POST["boton_borrar"] . "?</p>";
        echo "<form action='index.php' method='post'>
                    <button type='submit'>Volver</button>
                    <button name='boton_confirmar_borrar' type='submit'>Borrar</button>    
                </form>";
        echo "</div>";
    }

    /************************** TABLA PRINCIPAL **************************/

    try {
        $consulta = "SELECT * FROM usuarios";
        $resultado = mysqli_query($conexion, $consulta);

        echo "<h3 class='centrar'>Listado de los usuarios</h3>";
        echo "<table class='centrar texto-centrado'>";
        echo "<tr><th>#</th><th>Foto</th><th>Nombre</th><th>Usuario+</th></tr>";

        while ($tupla = mysqli_fetch_assoc($resultado)) {

            echo "<tr>";
            echo "<td>" . $tupla["id_usuario"] . "</td>";
            echo "<td><img src='Img/" . $tupla["foto"] . "' alt='Foto de perfil' title='Foto de perfil'/></td>";
            echo "<td><form method='post' action='index.php'>
                            <button class='enlace' name='boton_listar' value='" . $tupla["id_usuario"] . "' type='submit'>" . $tupla["nombre"] . "</button>
                        </form></td>";
            echo "<td><form method='post' action='index.php'>
                        <button name='boton_borrar' value='" . $tupla["id_usuario"] . "' class='enlace' type='submit'>Borrar</button> 
                        - 
                        <button name='boton_editar' value='" . $tupla["id_usuario"] . "' class='enlace' type='submit'>Editar</button></form></td>";
        }

        echo "</table>";
        mysqli_free_result($resultado);
        mysqli_close($conexion);
    } catch (Exception $e) {

        $mensaje = "<p>Imposible realizar la conexión. Error Nº " . mysqli_connect_errno() . ": " . mysqli_connect_error() . "</p>";
        mysqli_close($conexion);
        die($mensaje);
    }

    ?>
</body>

</html>