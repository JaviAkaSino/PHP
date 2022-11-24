<?php
require "src/bd_config.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Práctica 9 - Javier Parodi</title>
    <style>
        h1 {
            text-align: center;
            text-decoration: underline;
        }

        table {
            text-align: center;
            width: 80%;
            font-size: large;
        }

        table,
        td,
        th,
        tr {
            border-collapse: collapse;
            border: 1px solid black;
            padding: 1rem;
        }

        th {
            background-color: orange;
        }

        button {
            background: none;
            border: none;
            color: orangered;
            font-size: large;
            font-weight: 800;
        }

        button:hover {
            cursor: pointer;
        }

        img {
            max-width: 150px;
            max-height: 100px;
            box-shadow: 0px 2px 10px 5px orangered;
        }

        p > img {
            max-width: 150px;
            max-height: 100px;
            box-shadow: 0px 2px 10px 5px orange;
        }

        .centrar {
            width: 80%;
            margin: 1rem auto;
        }

        .negrita{
            font-weight: 800;
        }
    </style>
</head>

<body>
    <h1>Videoclub</h1>
    <h2 class='centrar'>Películas</h2>

    <?php

    //CONEXIÓN
    try {
        $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die(pag_error(
            "Práctica 9 - Javier Parodi",
            "Videoclub",
            "No ha sido posible conectar a la base de datos. Error Nº " . mysqli_connect_errno() . ": " . mysqli_connect_error()
        ));
    }

    /***************** TABLA PRINCIPAL ****************/

    require "vistas/tabla.php";

    /***************** LISTAR PELÍCULA ****************/

    if (isset($_POST["boton_listar"])) {

        require "vistas/listar.php";

        try {

            $consulta = "SELECT * FROM peliculas WHERE idPelicula='" . $_POST["boton_listar"] . "'";
            $resultado = mysqli_query($conexion, $consulta);

            if (mysqli_num_rows($resultado) > 0)
                $tupla = mysqli_fetch_assoc($resultado);
                echo "<div class='centrar'>";
                echo "<h3>Datos de la película con ID - ".$tupla["idPelicula"]."</h3>";
                
                echo "<p><span class='negrita'>Título: </span>".$tupla["titulo"]."</p>";
                echo "<p><span class='negrita'>Director: </span>".$tupla["director"]."</p>";
                echo "<p><span class='negrita'>Temática: </span>".$tupla["tematica"]."</p>";
                echo "<p><span class='negrita'>Sinopsis: </span>".$tupla["sinopsis"]."</p>";
                echo "<p><span class='negrita'>Carátula: </span><br/><br/><img src='Img/".$tupla["caratula"]."'/></p>";
                echo "</div>";
        } catch (Exception $e) {

            $mensaje = "No se ha podido listar los datos de la película. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
            mysqli_close($conexion);
            die($mensaje);
        }
    }
    ?>
</body>

</html>