<?php
require "src/funciones.php";

session_name("login_foro");
session_start();

define("DIR_SERV", "http://localhost/PHP/Tema_5/Foro/Ejercicio3_key/login_restful");
define("MINUTOS", 3);

if (isset($_POST["boton_salir"])){
    $datos_salir["api_session"] = $_SESSION["api_session"];
    $url = DIR_SERV . "/salir"; //SALIR - Borrar la api_session
    $respuesta = consumir_servicios_rest($url, "POST", $datos_salir);
    session_destroy(); //Cierra la sesión de la aplicación
    
    header("Location:index.php");
    exit;
}

if (isset($_SESSION["api_session"]) && isset($_SESSION["usuario"]) && isset($_SESSION["clave"]) && isset($_SESSION["ultimo_acceso"])) {

//SEGURIDAD
    require "vistas/seguridad.php";
    
    if($datos_usuario_log->tipo == "admin"){

        require "vistas/admin.php";
    } else {

        require "vistas/normal.php";
    }
    
} else {

    require "vistas/login.php";
}
