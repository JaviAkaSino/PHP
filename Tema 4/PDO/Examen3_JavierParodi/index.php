<?php
require "src/bd_config.php";
require "src/functions.php";

session_name("examen3_22_23");
session_start();

// SERVIDOR_BD,USUARIO_BD,CLAVE_BD y NOMBRE_BD son CTES

//Conexión con PDO
$conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
//Algunas funciones y metodos según conexion PDO ó mysqli
$ultim_id = $conexion->lastInsertId();

if (isset($_POST["boton_salir"])) {
    session_unset();
    header("Location:index.php");
    exit;
}

if (isset($_POST["boton_registro"])){

    
    
}

if (isset($_POST["boton_borrar_foto"])) {

    //$_POST["boton_borrar_foto"]
    //$_POST["foto_borrar"]


    try {

        $consulta = "UPDATE clientes SET foto = 'no_imagen.jpg' WHERE id_cliente = ?";

        $sentencia = $conexion->prepare($consulta);
        $datos_borrar_foto[] = $_POST["boton_borrar_foto"];

        $sentencia->execute($datos_borrar_foto);

        //si se ha ejecutado borramos archivo

        if (is_file("Images/" . $_POST["foto_borrar"])) //si existe la foto
            unlink("Images/" . $_POST["foto_borrar"]);
    } catch (PDOException $e) {

        $conexion = null;
        $sentencia = null;
        die(pag_error("Imposible realizar consulta. Error: " . $e->getMessage()));
    }
}

if (isset($_POST["boton_editar_foto"])) {


    //$_POST["boton_editar_foto"]
    //$_POST["foto_borrar"]

    $error_foto = $_FILES["foto"]["name"] == "" || $_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500000;


    if (!$error_foto) {

        //Nombre foto nueva

        //extension 
        $extension = "";

        $array_nombre = explode(".", $_FILES["foto"]["name"]);
        if (count($array_nombre) > 1)
            $extension = "." . end($array_nombre);

        //img + id + ext
        $foto_nueva = "img" . $_POST["boton_editar_foto"] . $extension;


        //prueba mover

        @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "Images/" . $foto_nueva);

        if ($var) {

            try {

                $consulta = "UPDATE clientes SET foto = ? WHERE id_cliente = ?";

                $sentencia = $conexion->prepare($consulta);
                $datos_editar_foto[] = $foto_nueva;
                $datos_editar_foto[] = $_POST["boton_editar_foto"];

                $sentencia->execute($datos_editar_foto);
            } catch (PDOException $e) {
                //si NO se ha ejecutado borramos archivo

                if (is_file("Images/" . $_POST["foto_borrar"])) //si existe la foto
                    unlink("Images/" . $_POST["foto_borrar"]);
                $conexion = null;
                $sentencia = null;
                die(pag_error("Imposible realizar consulta. Error: " . $e->getMessage()));
            }
        } else {

            $error_foto = "No se ha podido mover la imagen por falta de permisos";
        }
    }
}




if (isset($_SESSION["usuario"]) && isset($_SESSION["clave"]) && isset($_SESSION["ultimo_acceso"])) {

    $salto = "index.php";
    require "src/seguridad.php";


    if ($datos_usuario_log["tipo"] == "admin") {

        header("Location:admin/gest_clientes.php");
        exit;
    } else {


?>

        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Videoclub</title>
        </head>

        <body>
            <h1>Videoclub</h1>

    <?php

        echo "<p>
            Bienvenido <strong>" . $datos_usuario_log["usuario"] . "</strong> - 
            <form action='index.php' method='post'>
                <button type='submit' name= 'boton_salir'>Salir</button>
            </form>
        </p>";


        echo "<p>
                <strong>Foto de perfil</strong>
                <img width= 150px src='Images/" . $datos_usuario_log["foto"] . "' alt='" . $datos_usuario_log["foto"] . "'/>
            </p>";

        echo "<form action='index.php' method='post' enctype='multipart/form-data'>
                <p>
                    <button type='submit' name= 'boton_borrar_foto' value='" . $datos_usuario_log["id_cliente"] . "'>Eliminar foto</button>
                    <input type='hidden' name='foto_borrar' value='" . $datos_usuario_log["foto"] . "'/>
                </p>

                <p>
                    <label for='foto'>Seleccione foto de perfil:</label>
                    <input type='file' name='foto' id='foto' accept='image/*'>";

        if (isset($_POST["boton_editar_foto"]) && $error_foto) {

            if(is_string($error_foto))
                echo "<span class='error'>".$error_foto."</<span>";

            if ($_FILES["foto"]["name"] != "") {

                if ($_FILES["foto"]["error"])
                    echo "<span class='error'>Error en la subida de la imagen</span>";
                else if (!getimagesize($_FILES["foto"]["tmp_name"]))
                    echo "<span class='error'>El archivo seleccionado NO es una imagen</span>";
                else
                    echo "<span class='error'>Debe seleccionar una imagen inferior a 500KB</span>";
            }
        }

        echo "       <br/>
                    <button type='submit' name= 'boton_editar_foto' value='" . $datos_usuario_log["id_cliente"] . "'>Cambiar foto</button>
                </p>
                
            </form>";
    }
} else {

    require "vistas/login.php";
}
