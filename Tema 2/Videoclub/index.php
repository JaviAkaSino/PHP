<?php
require "src/bd_config.php";
require "src/funciones.php";
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
/***************** CONFIRMAR NUEVA PELÍCULA ****************/

if (isset($_POST["boton_confirmar_nueva"])) {

    $error_titulo = $_POST["titulo"] == "";
    $error_director = $_POST["director"] == "";

    if (!$error_titulo && !$error_director) {

        $titulo_repetido = repetido($conexion, "peliculas", "titulo", $_POST["titulo"]);
        $director_repetido = repetido($conexion, "peliculas", "director", $_POST["director"]);

        $error_titulo = $titulo_repetido && $director_repetido;
        $error_director = $titulo_repetido && $director_repetido;

        if (is_string($error_titulo)) {
            mysqli_close($conexion);
            die(pag_error("Práctica 9 - Javier Parodi", "Videoclub", $error_titulo));
        }
    }

    $error_tematica = $_POST["tematica"] == "";
    $error_sinopsis = $_POST["sinopsis"] == "";
    $error_caratula = $_FILES["caratula"]["name"] != "" &&
        ($_FILES["caratula"]["error"] || !getimagesize($_FILES["caratula"]["tmp_name"]) || $_FILES["caratula"]["size"] > 1000000);



    $error_form = $error_titulo || $error_director || $error_tematica || $error_sinopsis || $error_caratula;

    if (!$error_form) {

        $consulta = "INSERT INTO peliculas (titulo, director, tematica, sinopsis)
                VALUES ('" . $_POST["titulo"] . "','" . $_POST["director"] . "','" . $_POST["tematica"] . "','" . $_POST["sinopsis"] . "')";

        try {
            mysqli_query($conexion, $consulta); //Realizamos la inserción sin foto
            $mensaje_accion = "Película insertada con éxito"; //Hasta aquí, éxito
            if ($_FILES["caratula"]["name"] != "") { //Si hay foto
                //Trataremos de moverla
                $ultimo_id = mysqli_insert_id($conexion); //Último id
                $extension = "";
                $arr_nombre = explode(".", $_FILES["caratula"]["name"]); //Separamos por puntos
                if (count($arr_nombre) > 1) //Si tiene extension
                    $extension = "." . strtolower(end($arr_nombre)); //La cogemos
                $nueva_imagen = "img_" . $ultimo_id . $extension; //Montamos el nombre
                //E intentamos moverla a la carpeta Img
                @$var = move_uploaded_file($_FILES["caratula"]["tmp_name"], "Img/" . $nueva_imagen);
                if ($var) { //Si se ha movido

                    try { //Intentamos agregarla
                        $consulta = "UPDATE peliculas SET caratula = '" . $nueva_imagen . "' WHERE idPelicula ='" . $ultimo_id . "'";
                        mysqli_query($conexion, $consulta);
                    } catch (Exception $e) { //Si hay error
                        if (is_file("Img/" . $nueva_imagen)) //Y hay imagen
                            unlink("Img/" . $nueva_imagen); //La borramos

                        $mensaje = "Ha sido imposible añadir la carátula. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
                        mysqli_close($conexion);
                        die(pag_error("Práctica 9", "Práctica 9", $mensaje));
                    }
                } else { //Si no se ha podido mover la foto
                    $mensaje_accion = "Película añadida con imagen por defecto. No ha sido posbile subir la imagen al servidor";
                }
            }
        } catch (Exception $e) {

            $mensaje = "Imposible realizar la inserción. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
            mysqli_close($conexion);
            die(pag_error("Práctica 9", "Videoclub", $mensaje));
        }
    }
}

/***************** CONFIRMAR EDITAR PELÍCULA ****************/

if (isset($_POST["boton_confirmar_editar"])) {

    //ERRORES
    $error_titulo = $_POST["titulo"] == "";
    $error_director = $_POST["director"] == "";

    //Si no estan vacíos, verificar que no existan ya 
    if (!$error_titulo && !$error_director) {

        $titulo_repetido = repetido($conexion, "peliculas", "titulo", $_POST["titulo"], "idPelicula", $_POST["idPelicula"]);
        $director_repetido = repetido($conexion, "peliculas", "director", $_POST["director"], "idPelicula", $_POST["idPelicula"]);

        $error_titulo = $titulo_repetido && $director_repetido;
        $error_director = $titulo_repetido && $director_repetido;

        if (is_string($error_titulo)) {

            mysqli_close($conexion);
            die(pag_error("Práctica 9", "Videoclub", $error_titulo));
        }
    }

    $error_tematica = $_POST["tematica"] == "";
    $error_sinopsis = $_POST["sinopsis"] == "";
    $error_caratula = $_FILES["caratula"]["name"] != "" && ($_FILES["caratula"]["error"] || !getimagesize($_FILES["caratula"]["tmp_name"]) || $_FILES["caratula"]["size"] > 1000000);

    $error_form = $error_titulo || $error_director || $error_tematica || $error_sinopsis || $error_caratula;

    //EDITAMOS SIN CARATULA

    if (!$error_form) {

        $consulta = "UPDATE peliculas SET titulo ='" . $_POST["titulo"] . "', director='" . $_POST["director"] . "', tematica='" . $_POST["tematica"] . "', sinopsis ='" . $_POST["sinopsis"] . "' WHERE idPelicula='" . $_POST["idPelicula"] . "'";

        try { //Intentamos la edicion

            mysqli_query($conexion, $consulta);
            $mensaje_accion = "Película editada con éxito";

            if ($_FILES["caratula"]["name"] != "") { //Si hay caratula, intentamos moverla

                $extension = "";
                $arr_nombre = explode(".", $_FILES["caratula"]["name"]);
                if (count($arr_nombre) > 1) //Si tiene extensión
                    $extension = "." . strtolower(end($arr_nombre)); //La guardamos
                $nueva_caratula = "img_" . $_POST["idPelicula"] . $extension;

                @$var = move_uploaded_file($_FILES["caratula"]["tmp_name"], "Img/" . $nueva_caratula);
                if ($var) {
                    if ($nueva_caratula != $_POST["caratula"]) { //Si el nombre cambia
                        try { //La editamos

                            $consulta = "UPDATE peliculas SET caratula='" . $nueva_caratula . "'  WHERE idPelicula='" . $_POST["idPelicula"] . "'";
                            mysqli_query($conexion, $consulta);

                            if ($_POST["caratula"] != "no_imagen.jpg" && is_file("Img/" . $_POST['caratula'])) //Si existe la antigua
                                unlink("Img/" . $_POST['caratula']); //La borramos
                        } catch (Exception $e) {
                            if (is_file("Img/" . $_POST['caratula'])) //Si existe la antigua
                                unlink("Img/" . $_POST['caratula']); //La borramos
                            $mensaje = "Imposible actualziar la carátula. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
                            mysqli_close($conexion);
                            die(pag_error("Práctica 9", "Videoclub", $mensaje));
                        }
                    }
                } else { //Si no se puede mover el archivo, cambia el mensaje de acción
                    $mensaje_accion = "Película editada a falta de la carátula. No ha sido posible subir la imagen al servidor";
                }
            }
        } catch (Exception $e) {
            $mensaje = "Imposible editar la película. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
            mysqli_close($conexion);
            die(pag_error("Práctica 9", "Videoclub", $mensaje));
        }
    }
}

/***************** CONFIRMAR BORRAR CARÁTULA ****************/

if (isset($_POST["boton_confirmar_borrar_caratula"])) {

    try {
        $consulta = "UPDATE peliculas SET caratula='no_imagen.jpg' WHERE idPelicula = '" . $_POST["idPelicula"] . "'";
        mysqli_query($conexion, $consulta);
        if (is_file("Img/" . $_POST["boton_confirmar_borrar_caratula"]))
            unlink("Img/" . $_POST["boton_confirmar_borrar_caratula"]);
    } catch (Exception $e) {

        $mensaje = "Imposible borrar esta carátula. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
        mysqli_close($conexion);
        die(pag_error("Práctica 9", "Videoclub", $mensaje));
    }
}

/***************** CONFIRMAR BORRAR PELÍCULA ****************/

if (isset($_POST["boton_confirmar_borrar"])) {

    $consulta = "DELETE FROM peliculas WHERE idPelicula='" . $_POST["boton_confirmar_borrar"] . "'";
    try {
        mysqli_query($conexion, $consulta);
        $mensaje_accion = "Película " . $_POST["boton_confirmar_borrar"] . " borrada con éxito.";
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

            width: 80%;
            font-size: large;
        }

        table#principal,
        table#principal td,
        table#principal th,
        table#principal tr {
            border-collapse: collapse;
            border: 1px solid black;
            padding: 1rem;
            text-align: center;
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

        .texto-centrado {
            text-align: center;
        }

        .error {
            color: orange;
            font-weight: bold;
        }

        #accion{

            color:orange;
            font-weight: bold;
            font-size: x-large;
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

    if (isset($_POST["boton_nueva"]) || (isset($_POST["boton_confirmar_nueva"]) && $error_form)) {

        require "vistas/nueva.php";
    }

    /***************** EDITAR PELÍCULA ****************/

    if (
        isset($_POST["boton_editar"]) || (isset($_POST["boton_confirmar_editar"]) && $error_form)
        || isset($_POST["boton_confirmar_borrar_caratula"]) || isset($_POST["boton_volver_borrar_caratula"])
    ) {

        require "vistas/editar.php";
    }

    /***************** BORRAR CARÁTULA ****************/

    if (isset($_POST["boton_borrar_caratula"])) {

        require "vistas/borrar_caratula.php";
    }


    /***************** BORRAR PELÍCULA ****************/

    if (isset($_POST["boton_borrar"])) {

        require "vistas/borrar.php";
    }

    if (isset($mensaje_accion)) {
        echo "<p class='centrar' id='accion'>" . $mensaje_accion . "</p>";
    }
    mysqli_close($conexion);
    ?>
</body>

</html>