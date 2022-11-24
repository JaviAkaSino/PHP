<?php
require "src/bd_config.php";
require "src/funciones.php";

//Realizamos la conexión, ya que se acaba listando siempre
try {
    $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
    mysqli_set_charset($conexion, "utf8");
} catch (Exception $e) {
    die(pag_error("Práctica 8", "Práctica 8", "Imposible conectar. Error Nº " . mysqli_connect_errno() . " : " . mysqli_connect_error()));
}


/***************************  BORRAR - CONFIRMACIÓN   **************************/

if (isset($_POST["boton_confirmar_borrar"])) {

    $consulta = "DELETE FROM usuarios WHERE id_usuario = '" . $_POST["boton_confirmar_borrar"] . "'";

    try {

        $resultado = mysqli_query($conexion, $consulta);
        $mensaje_accion = "Usuario borrado con éxito";
        if ($_POST["nombre_foto"] != "no_imagen.jpg")
            unlink("Img/" . $_POST["nombre_foto"]);
    } catch (Exception $e) {

        $mensaje = "No ha sido posible borrar el usuario. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
        mysqli_close($conexion);
        die(pag_error("Práctica 8", "Borrar usuario", $mensaje));
    }
}


/***************************  BORRAR FOTO - CONFIRMACIÓN   **************************/

if (isset($_POST["boton_confirmar_borrar_foto"])) {
    try {
        $consulta = "update usuarios set foto='no_imagen.jpg' where id_usuario='" . $_POST["id_usuario"] . "'";
        mysqli_query($conexion, $consulta);
        if (is_file("Img/" . $_POST["nombre_foto"]))
            unlink("Img/" . $_POST["nombre_foto"]);
    } catch (Exception $e) {
        $mensaje = "Imposible realizar la consulta. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
        mysqli_close($conexion);
        die(pag_error("Práctica 8", "Práctica 8", $mensaje));
    }
}

/***************************  EDITAR - CONFIRMACIÓN   **************************/

if (isset($_POST["boton_confirmar_editar"])) {

    $error_nombre = $_POST["nombre"] == "";
    $error_usuario = $_POST["usuario"] == "";
    $error_dni = $_POST["dni"] == "" || !dni_formato($_POST["dni"]) || !dni_valido($_POST["dni"]);
    $error_sexo = !isset($_POST["sexo"]);
    $error_foto = $_FILES["foto"]["name"] != "" &&
        ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500000);

    //Si usuario y dni no dan los errores "normales" accedemos a la bd para ver si están repetidos
    if (!$error_usuario) {

        $error_usuario = repetido($conexion, "usuarios", "usuario", $_POST["usuario"], "id_usuario", $_POST["boton_confirmar_editar"]);

        if (is_string($error_usuario)) {

            mysqli_close($conexion);
            die(pag_error("Práctica 8", "Editar usuario", $error_usuario));
        }
    }

    if (!$error_dni) {

        $error_dni = repetido($conexion, "usuarios", "dni", $_POST["dni"], "id_usuario", $_POST["boton_confirmar_editar"]);

        if (is_string($error_dni)) {

            mysqli_close($conexion);
            die(pag_error("Práctica 8", "Editar usuario", $error_dni));
        }
    }

    $error_form = $error_nombre || $error_usuario || $error_dni || $error_sexo || $error_foto;

    if (!$error_form) {
    }
    if ($_POST["clave"] != "") {
        //Cambia clave
        $consulta = "UPDATE usuarios SET nombre = '" . $_POST["nombre"] . "', usuario = '" . $_POST["usuario"] . "', clave = '" . $_POST["clave"] . "', dni = '" . strtoupper($_POST["dni"]) . "', sexo = '" . $_POST["sexo"] . "' WHERE id_usuario = '" . $_POST["boton_confirmar_editar"] . "'";
    } else {
        //No cambia clave
        $consulta = "UPDATE usuarios SET nombre = '" . $_POST["nombre"] . "', usuario = '" . $_POST["usuario"] . "', dni = '" . strtoupper($_POST["dni"]) . "', sexo = '" . $_POST["sexo"] . "' WHERE id_usuario = '" . $_POST["boton_confirmar_editar"] . "'";
    }

    try {

        mysqli_query($conexion, $consulta);
        $mensaje_accion = "Usuario editado con éxito";

        //Ahora añadimos la foto si la hay
        if ($_FILES["foto"]["name"] != "") {
            //Extension
            $array_nombre = explode(".", $_FILES["foto"]["name"]);
            $extension = "";
            if (count($array_nombre) > 1)
                $extension = "." . strtolower(end($array_nombre));
            //Nombre
            $nombre_imagen = "img_" . $_POST["boton_confirmar_editar"] . $extension;
            //Mover
            @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "Img/" . $nombre_imagen);
            if ($var) {

                if ($nombre_imagen != $_POST["nombre_foto"]) { //Si la foto cambia

                    try { //Actualizamos
                        $consulta = "UPDATE usuarios SET foto = '" . $nombre_imagen . "' WHERE id_usuario = '" . $_POST["boton_confirmar_editar"] . "'";
                        mysqli_query($conexion, $consulta);

                        if ($_POST["nombre_foto"] != "no_imagen.jpg") { //Si ya tenoia foto
                            if (is_file("Img/" . $_POST["nombre_foto"])) {
                                unlink("Img/" . $_POST["nombre_foto"]);
                            }
                        }
                    } catch (Exception $e) {
                        $mensaje = "Imposible subir la imagen. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
                        mysqli_close($conexion);
                        die(pag_error("Práctica 8", "Añadir imagen", $mensaje));
                    }
                }
            } else { //Si no se puede mover la foto

                $mensaje_accion = "Usuario editado a falta de la imagen. No ha sido posible subir la imagen al servidor";
            }
        }
    } catch (Exception $e) {

        $mensaje = "No ha sido posible editar el usuario. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
        mysqli_close($conexion);
        die(pag_error("Práctica 8", "Editar usuario", $mensaje));
    }
}


/***********************  NUEVO USUARIO - CONFIRMACIÓN   **********************/
if (isset($_POST["boton_confirmar_nuevo"])) {

    $error_nombre = $_POST["nombre"] == "";
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_dni = $_POST["dni"] == "" || !dni_formato($_POST["dni"]) || !dni_valido($_POST["dni"]);
    $error_sexo = !isset($_POST["sexo"]);
    $error_foto = $_FILES["foto"]["name"] != "" &&
        ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500000);

    //Si usuario y dni no dan los errores "normales" accedemos a la bd para ver si están repetidos

    if (!$error_usuario) {

        $error_usuario = repetido($conexion, "usuarios", "usuario", $_POST["usuario"]);

        if (is_string($error_usuario)) {

            mysqli_close($conexion);
            die(pag_error("Práctica 8", "Nuevo usuario", $error_usuario));
        }
    }

    if (!$error_dni) {

        $error_dni = repetido($conexion, "usuarios", "dni", $_POST["dni"]);

        if (is_string($error_dni)) {

            mysqli_close($conexion);
            die(pag_error("Práctica 8", "Nuevo usuario", $error_dni));
        }
    }

    $error_form = $error_nombre || $error_usuario || $error_clave || $error_dni || $error_sexo || $error_foto;

    if (!$error_form) {

        //Hacemos el INSERT sin la foto
        $consulta = "INSERT INTO usuarios (nombre, usuario, clave, dni, sexo) 
                VALUES ('" . $_POST["nombre"] . "', '" . $_POST["usuario"] . "', '" . md5($_POST["clave"]) . "', '" . strtoupper($_POST["dni"]) . "', '" . $_POST["sexo"] . "')";

        try {
            mysqli_query($conexion, $consulta);
            $mensaje_accion = "Usuario añadido con éxito";

            //Ahora añadimos la foto si la hay
            if ($_FILES["foto"]["name"] != "") {
                //Extension
                $array_nombre = explode(".", $_FILES["foto"]["name"]);
                $extension = "";
                if (count($array_nombre) > 1)
                    $extension = "." . strtolower(end($array_nombre));
                //Nombre
                $ultimo_id = mysqli_insert_id($conexion); //Último id
                $nombre_imagen = "img_" . $ultimo_id . $extension;
                //Mover
                @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "Img/" . $nombre_imagen);
                if ($var) {

                    try {
                        $consulta = "UPDATE usuarios SET foto = '" . $nombre_imagen . "' WHERE id_usuario = '" . $ultimo_id . "'";
                        mysqli_query($conexion, $consulta);
                    } catch (Exception $e) {
                        $mensaje = "Imposible subir la imagen. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
                        mysqli_close($conexion);
                        die(pag_error("Práctica 8", "Añadir imagen", $mensaje));
                    }
                } else { //Si no se puede mover la foto

                    $mensaje_accion = "Usuario añadido con imagen por defecto. No ha sido posible subir la imagen al servidor";
                }
            }
        } catch (Exception $e) {
            $mensaje = "Imposible añadir al usuario. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
            mysqli_close($conexion);
            die(pag_error("Práctica 8", "Nuevo usuario", $mensaje));
        }
    }
}


/*****************************  PÁGINA PRINCIPAL   ****************************/

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
            height: 50px;
        }

        p img {
            height: 150px;
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

        .flexible {
            display: flex;
        }

        .flexible>* {
            width: 50%;
        }

        .columna {
            flex-flow: column;
        }

        .fila {
            flex-flow: row;
        }

        div#edicion {
            align-items: center;
        }

        div#editar_foto>img {
            height: 15rem;
            box-shadow: 0px 2px 10px 5px black;
        }
    </style>
</head>

<body>
    <h1 class="texto-centrado">Práctica 8</h1>

    <?php

    /***************************  BOTON LISTAR  **************************/
    if (isset($_POST["boton_listar"])) {
        require "vistas/listar.php";
    }

    /***************************   NUEVO USUARIO  **************************/

    if (isset($_POST["boton_nuevo"]) || (isset($_POST["boton_confirmar_nuevo"]) && $error_form)) {
        require "vistas/nuevo_usuario.php";
    }
    /*************************** BOTON BORRAR **************************/

    if (isset($_POST["boton_borrar"])) {
        require "vistas/borrar.php";
    }

    /***************************   EDITAR USUARIO  **************************/

    if (
        isset($_POST["boton_editar"]) || (isset($_POST["boton_confirmar_editar"]) && $error_form)
        || isset($_POST["boton_borrar_foto"]) || isset($_POST["boton_confirmar_borrar_foto"])
        || isset($_POST["boton_volver_borrar_foto"])
    ) {
        require "vistas/editar.php";
    }

    /************************** TABLA PRINCIPAL **************************/

    if (isset($mensaje_accion)) {
        echo "<p class='centrar'>" . $mensaje_accion . "</p>";
    }

    require "vistas/tabla_principal.php";

    mysqli_close($conexion);


    ?>
</body>

</html>