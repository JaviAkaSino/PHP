<?php
require "src/funciones.php";

session_name("login_foro");
session_start();

define("DIR_SERV", "http://localhost/PHP/Tema_5/Foro/login_restful");
define("MINUTOS", 3);

if (isset($_POST["boton_salir"])){
    session_destroy();
    header("Location:index.php");
    exit;
}

if (isset($_SESSION["usuario"]) && isset($_SESSION["clave"]) && isset($_SESSION["ultimo_acceso"])) {

//SEGURIDAD
    require "vistas/seguridad.php";
    
    if($datos_usuario_log->tipo == "admin"){


    } else {

        require "vistas/normal.php";
    }
    
} else {

    require "vistas/login.php";
}
