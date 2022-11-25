<?php
require "src/bd_config.php";

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

/***************** CONFIRMAR BORRAR PELÍCULA ****************/

if (isset($_POST["boton_confirmar_borrar"])) {

        $consulta = "DELETE FROM peliculas WHERE idPelicula='" . $_POST["boton_confirmar_borrar"] . "'";
    try {
        mysqli_query($conexion, $consulta);
        $mensaje_accion = "Usuario ".$_POST["boton_confirmar_borrar"]." borrado con éxito.";
        if ($_POST["nombre_caratula"] != "no_imagen.jpg")
            unlink("Img/" . $_POST["nombre_caratula"]);
    } catch (Exception $e) {
        die(pag_error(
            "Práctica 9 - Javier Parodi",
            "Videoclub",
            "No ha sido posible conectar a la base de datos. Error Nº " . mysqli_connect_errno() . ": " . mysqli_connect_error()
        ));
    }
}
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

        p>img {
            max-width: 150px;
            max-height: 100px;
            box-shadow: 0px 2px 10px 5px orange;
        }

        .centrar {
            width: 80%;
            margin: 1rem auto;
        }

        .negrita {
            font-weight: 800;
        }
    </style>
</head>

<body>
    <h1>Videoclub</h1>
    <h2 class='centrar'>Películas</h2>

    <?php

    /***************** TABLA PRINCIPAL ****************/

    require "vistas/tabla.php";

    /***************** LISTAR PELÍCULA ****************/

    if (isset($_POST["boton_listar"])) {

        require "vistas/listar.php";
    }

    /***************** NUEVA PELÍCULA ****************/

    if(isset($_POST["boton_nueva"]) || (isset($_POST["boton_confirmar_nueva"]) && $error_form)){

        require "vistas/nueva.php";
    }
    /***************** BORRAR PELÍCULA ****************/

    if (isset($_POST["boton_borrar"])) {

        require "vistas/borrar.php";
    }




    if (isset($mensaje_accion)) {
        echo "<p class='centrar'>" . $mensaje_accion . "</p>";
    }
    mysqli_close($conexion);
    ?>
</body>

</html>