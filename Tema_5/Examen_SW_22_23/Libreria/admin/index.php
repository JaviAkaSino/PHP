<?php

require "../src/funciones.php";

define("DIR_SERV", "http://localhost/Proyectos/Examen_SW_22_23/servicios_rest");
define("MINUTOS", 2);

session_name("Exam_sw_22_23");
session_start();

require "seguridad_admin.php";

if ($datos_usuario_log->tipo != "admin"){
    session_unset();
    $_SESSION["seguridad"] = "Zona restringida para admin";
    header("Location:../index.php");
    exit;

}

if (isset($_POST["boton_salir"])) {

    session_destroy();
    header("Location:../index.php");
    exit;
}

if (isset($_POST["boton_borrar"])) {

    $_SESSION["mensaje_accion"] = "El libro con referencia " . $_POST["boton_borrar"] . " ha sido borrado con éxito";
    header("Location:index.php");
    exit;
}

if (isset($_POST["boton_editar"])) {

    $_SESSION["mensaje_accion"] = "El libro con referencia " . $_POST["boton_editar"] . " ha sido editado con éxito";
    header("Location:index.php");
    exit;
}

if (isset($_POST["boton_agregar"])){

    $error_referencia = $_POST["referencia"] =="" || !is_numeric($_POST["referencia"]) || $_POST["referencia"]<0;
    $error_titulo = $_POST["titulo"] =="";
    $error_autor = $_POST["autor"] =="";
    $error_descripcion = $_POST["descripcion"] =="";
    $error_precio = $_POST["precio"] =="" || !is_numeric($_POST["precio"]) || $_POST["precio"]<0;
    $error_portada = $_FILES["portada"]["name"] =!"" && ($_FILES["portada"]["error"]||!getimagesize($_FILES["portada"]["tmp_name"])||$_FILES["portada"]["size"]>500000);

    $error_form = $error_autor || $error_descripcion || $error_portada || $error_precio || $error_referencia || $error_titulo;

}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicio</title>
    <style>
        table,
        td,
        th {
            border-collapse: collapse;
            border: 1px solid black;
            text-align: center;
        }

        th {
            background-color: lightgrey;
        }

        table {
            width: 80%;
        }

        #contenido {
            display: flex;
            flex-flow: row wrap;
        }

        .info-libro {
            width: 33%;
            display: flex;
            flex-flow: row wrap;
            justify-content: center;
        }

        .foto-libro {
            width: 80%;
        }

        .linea {
            display: inline
        }

        .enlace {
            background: none;
            border: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }
        img{width:200px}
    </style>
</head>

<body>
    <h1>Librería</h1>

    <?php

    echo " <div>
                    Bienvenido/a <strong>" . $datos_usuario_log->lector . "</strong>
                    <form action='index.php' method='post' class='linea'>
                        <button class='enlace' name='boton_salir'>Salir</button>
                    </form>
            </div>";

    //MENSAJE ACCION 


    if (isset($_SESSION["mensaje_accion"])) {
        echo "<p>" . $_SESSION["mensaje_accion"] . "</p>";
        unset($_SESSION["mensaje_accion"]);
    }
    //TABLA

    echo "<h2>Listado de los Libros</h2>";



    $url = DIR_SERV . "/obtenerLibros";
    $respuesta = consumir_servicios_REST($url, "GET");
    $obj = json_decode($respuesta);

    if (!$obj) {

        die(error_page("Página de Inicio", "Librería", "Error consumiendo servicios REST: " . $url . "<br/>" . $respuesta));
    }

    if (isset($obj->error)) {

        die(error_page("Página de Inicio", "Librería", $obj->error));
    }

    echo "<table>";
    echo "<tr><th>Ref</th><th>Título</th><th>Acción</th></tr>";
    foreach ($obj->libros as $tupla) {

        echo "<tr>

                <td>" . $tupla->referencia . "</td>
                <td>
                    <form action='index.php' method='post'>
                        <button class='enlace' name='boton_info' value='" . $tupla->referencia . "'>" . $tupla->titulo . "</button>
                        <input type='hidden' name='titulo' value='".$tupla->titulo."'/>
                        <input type='hidden' name='autor' value='".$tupla->autor."'/>
                        <input type='hidden' name='descripcion' value='".$tupla->descripcion."'/>
                        <input type='hidden' name='precio' value='".$tupla->precio."'/>
                        <input type='hidden' name='portada' value='".$tupla->portada."'/>
                    </form>
                </td>
                <td>
                    <form action='index.php' method='post' class='linea'>
                        <button class='enlace' name='boton_borrar' value='" . $tupla->referencia . "'>Borrar</button>
                         - 
                        <button class='enlace' name='boton_editar' value='" . $tupla->referencia . "'>Editar</button>
                    </form>
                </td>
               
            </tr>";
    }
    echo "</table>";


    if (isset($_POST["boton_info"])){ //INFO LIBRO




        echo "<h3>Información del libro con referencia ".$_POST["boton_info"]."</h3>";

        echo "<p>Título: ".$_POST["titulo"]."</p>";
        echo "<p>Autor: ".$_POST["autor"]."</p>";
        echo "<p>Descripción: ".$_POST["descripcion"]."</p>";
        echo "<p>Precio: ".$_POST["precio"]." €</p>";
        echo "<p>Portada: <img src='../images/".$_POST["portada"]."'/></p>";
        

        echo "<form action='index.php' method='post'>
                <button >Volver</button>
            </form>";

    } else { //FORMU NUEVO


 ?>

    <h3>Agregar un nuevo libro</h3>

    <form action="index.php" method="post" enctype="multipart/form-data">

        <p>
            <label for="referencia">Referencia: </label>
            <input type="text" name="referencia" id="referencia" value="<?php if (isset($_POST["referencia"])) echo $_POST["referencia"] ?>" />
            <?php
            if (isset($_POST["boton_agregar"]) && $error_referencia) {
                if ($_POST["referencia"] == "")
                    echo "* Campo vacío";
                else if (!is_numeric($_POST["referencia"]) || $_POST["referencia"]< 0 )
                    echo "* Referencia incorrecta, debe ser numero positivo";
                else
                echo "* Referencia repetida";
            } ?>
        </p>

        <p>
            <label for="titulo">Título: </label>
            <input type="text" name="titulo" id="titulo" value="<?php if (isset($_POST["titulo"])) echo $_POST["titulo"] ?>" />
            <?php
            if (isset($_POST["boton_agregar"]) && $error_titulo) {
                    echo "* Campo vacío";
            } ?>
        </p>
        <p>
            <label for="autor">Autor: </label>
            <input type="text" name="autor" id="autor" value="<?php if (isset($_POST["autor"])) echo $_POST["autor"] ?>" />
            <?php
            if (isset($_POST["boton_agregar"]) && $error_autor) {
                    echo "* Campo vacío";
            } ?>
        </p>

        <p>
            <label for="descripcion">Descripcion: </label>
            <textarea name="descripcion" id="descripcion" value="" ><?php if (isset($_POST["descripcion"])) echo $_POST["descripcion"] ?></textarea>
            <?php
            if (isset($_POST["boton_agregar"]) && $error_descripcion) {
                    echo "* Campo vacío";
            } ?>
        </p>

        <p>
            <label for="precio">Precio: </label>
            <input type="text" name="precio" id="precio" value="<?php if (isset($_POST["precio"])) echo $_POST["precio"] ?>" />
            <?php
            if (isset($_POST["boton_agregar"]) && $error_precio) {
                    echo "* Campo vacío";
            } ?>
        </p>

        <p>
            <label for="portada">Portada: </label>
            <input type="file" name="portada" id="portada" accept="image/*"/>
            <?php
            if (isset($_POST["boton_agregar"]) && $error_portada) {
                if ($_FILES["portada"]["error"])
                    echo "* Error en la subida del archivo";
                elseif (!getimagesize($_FILES["portada"]["tmp_name"]))
                    echo "Ela rchivo seleccionado no es una imagen";
                else 
                echo "El archvo no puede ser superior a 500kB";
                
            } ?>
        </p>
        <p>
            <button type="submit" name="boton_agregar">Agregar</button>
        </p>
    </form>

    <?php


    }

 
   
