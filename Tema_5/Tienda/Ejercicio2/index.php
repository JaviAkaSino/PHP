<?php

session_name("Ejercicio2_SW");
session_start();

function consumir_servicios_rest($url, $metodo, $datos = null)
{
    $llamada = curl_init(); //Prepara para hacer la llamada
    curl_setopt($llamada, CURLOPT_URL, $url);
    curl_setopt($llamada, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($llamada, CURLOPT_CUSTOMREQUEST, $metodo);

    if (isset($datos))
        curl_setopt($llamada, CURLOPT_POSTFIELDS, http_build_query($datos));

    $respuesta = curl_exec($llamada); //Ejecuta la llamada
    curl_close($llamada); //Cierra 

    return $respuesta;
}

function pag_error($title, $encabezado, $mensaje)
{

    return "<!DOCTYPE html>
    <html lang='es''>
    <head>
        <meta charset='UTF-8'>
        <title>" . $title . "</title>
    </head>
    <body>
        <h1>" . $encabezado . "</h1><p>" . $mensaje . "</p>
    </body>
    </html>";
}

define("DIR_SERV", "http://localhost/PHP/Tema_5/Ejercicio1/servicios_rest");


/********************************** NUEVO - CONFIRMAR ************************************/

if (isset($_POST["boton_confirmar_nuevo"])) {

    $error_codigo = $_POST["codigo"] == "";

    if (!$error_codigo) {

        $url = DIR_SERV . "/repet_insert/producto/cod/" . urlencode($_POST["codigo"]);
        $respuesta = consumir_servicios_rest($url, "GET");
        $obj = json_decode($respuesta);

        if (isset($obj->mensaje_error))
            die(pag_error("CRUD - Servicios WEB", "Listado de productos", $obj->mensaje_error));
        if (!$obj)
            die(pag_error("CRUD - Servicios WEB", "Listado de productos", "Error consumiendo el servicio REST: " . $url . "</p>" . $respuesta));

        $error_codigo = $obj->repetido;
    }
    $error_nombre_corto = $_POST["nombre_corto"] == "";
    $error_descripcion = $_POST["descripcion"] == "";
    $error_precio = $_POST["precio"] == "" || $_POST["precio"] < 0;

    $error_form = $error_codigo || $error_nombre_corto || $error_descripcion || $error_precio;

    if (!$error_form) {

        $datos_insert["cod"] = $_POST["codigo"];
        $datos_insert["nombre"] = $_POST["nombre"];
        $datos_insert["nombre_corto"] = $_POST["nombre_corto"];
        $datos_insert["descripcion"] = $_POST["descripcion"];
        $datos_insert["PVP"] = $_POST["precio"];
        $datos_insert["familia"] = $_POST["familia"];

        $url = DIR_SERV . "/producto/insertar";
        $respuesta = consumir_servicios_rest($url, "POST", $datos_insert);
        $obj = json_decode($respuesta);

        if (isset($obj->mensaje_error))
            die(pag_error("CRUD - Servicios WEB", "Listado de productos", $obj->mensaje_error));
        if (!$obj)
            die(pag_error("CRUD - Servicios WEB", "Listado de productos", "Error consumiendo el servicio REST: " . $url . "</p>" . $respuesta));
        else {
            $_SESSION["mensaje_accion"] = "miaaaaau";

            header("Location:index.php");
            exit;
        }
    }
}

/********************************** EDITAR - CONFIRMAR ************************************/

if (isset($_POST["boton_confirmar_editar"])) {

    $error_nombre_corto = $_POST["nombre_corto"] == "";
    $error_descripcion = $_POST["descripcion"] == "";
    $error_precio = $_POST["precio"] == "" || $_POST["precio"] < 0;

    $error_form = $error_codigo || $error_nombre_corto || $error_descripcion || $error_precio;

    if (!$error_form) {

        $datos_edit["nombre"] = $_POST["nombre"];
        $datos_edit["nombre_corto"] = $_POST["nombre_corto"];
        $datos_edit["descripcion"] = $_POST["descripcion"];
        $datos_edit["PVP"] = $_POST["precio"];
        $datos_edit["familia"] = $_POST["familia"];

        $url = DIR_SERV . "/producto/actualizar/" . $_POST["boton_confirmar_editar"];
        $respuesta = consumir_servicios_rest($url, "PUT", $datos_edit);
        $obj = json_decode($respuesta);

        if (isset($obj->mensaje_error))
            die(pag_error("CRUD - Servicios WEB", "Editar productos", $obj->mensaje_error));
        if (!$obj)
            die(pag_error("CRUD - Servicios WEB", "Editar productos", "Error consumiendo el servicio REST: " . $url . "</p>" . $respuesta));
        else {
            $_SESSION["mensaje_accion"] = "Producto editado con éxito";

            header("Location:index.php");
            exit;
        }
    }
}

/********************************** BORRAR - CONFIRMAR ************************************/

if (isset($_POST["boton_confirmar_borrar"])) {

    $url = DIR_SERV . "/producto/borrar/" . urlencode($_POST["boton_confirmar_borrar"]);
    $respuesta = consumir_servicios_rest($url, "DELETE");
    $obj = json_decode($respuesta);

    if (isset($obj->mensaje_error))
        die(pag_error("CRUD - Servicios WEB", "CRUD - Servicios WEB", "Error consumiendo el servicio REST: " . $url . "</>" . $respuesta));

    if (!$obj)
        die(pag_error("CRUD - Servicios WEB", "CRUD - Servicios WEB",  "<p>El producto ya no se encuentra en la BD</p>"));


    $_SESSION["mensaje_accion"] = "El producto se ha borrado con éxito";
    header("Location:index.php");
    exit;
}



?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD - Servicios WEB</title>
    <style>
        table,
        td,
        th {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;
        }

        th {
            background-color: #FF600A;
        }

        .centro {
            width: 80%;
            margin: auto;
        }

        .texto-centrado {
            text-align: center;
        }

        .enlace {
            border: none;
            background: none;
            text-decoration: underline;
            color: #FF600A;
            cursor: pointer;
            font-weight: bold;
        }

        #boton_nuevo {
            border: none;
            background: none;
            font-weight: bold;
            cursor: pointer;
            color: white;
        }
    </style>
</head>

<body>
    <h1 class="texto-centrado">Listado de productos</h1>
    <div class="centro">

        <?php
        /*********************************** INFO DEL PRODUCTO ***********************************/
        if (isset($_POST["boton_producto"])) {

            require "vistas/info_prod.php";
        }

        /*********************************** NUEVO PRODUCTO ***********************************/

        if (isset($_POST["boton_nuevo"]) || isset($_POST["boton_confirmar_nuevo"]) && $error_form) {

            require "vistas/nuevo_prod.php";

            }


            /*********************************** EDITAR PRODUCTO ***********************************/

            if (isset($_POST["boton_editar"]) || isset($_POST["boton_confirmar_editar"]) && $error_form) {

                require "vistas/editar_prod.php";
            }

            /*********************************** BORRAR PRODUCTO ***********************************/

            if (isset($_POST["boton_borrar"])) {

                require "vistas/borrar_prod.php";
            }


            /****************************** TABLA DE PRODUCTOS *****************************/
            require "vistas/tabla.php";

            if (isset($_SESSION["mensaje_accion"])) {

                echo "<br/><h3 class='centro texto-centrado'>" . $_SESSION["mensaje_accion"] . "</h3>";
                unset($_SESSION["mensaje_accion"]);
            }

            ?>
    </div>
</body>

</html>