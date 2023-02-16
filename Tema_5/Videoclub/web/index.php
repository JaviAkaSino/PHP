<?php

require "src/funciones.php"; //Cargo las funciones

session_name("videoclub_normal"); //Inicio sesión
session_start();

define("MINUTOS", 5); //Defino el tiempo
define("DIR_SERV", "http://localhost/PHP/Tema_5/Videoclub/servicios_rest"); //Ubi REST

//SI PULSA SALIR
if (isset($_POST["boton_salir"])) {

    //Destruye sesión API
    $url = DIR_SERV . "/salir";
    consumir_servicios_rest($url, "POST", $_SESSION["api_session"]);
    //Destruye la sesión
    session_destroy();
    header("Location:index.php");
    exit;
}

//SI ESTÁ LOGUEADO
if (isset($_SESSION["api_session"]) && isset($_SESSION["usuario"]) && isset($_SESSION["clave"]) && isset($_SESSION["ultimo_acceso"])) {

    //SEGURIDAD

    require "src/seguridad.php";

    //SI ES ADMIN
    if ($datos_usuario_log->tipo == "admin") {

        require "vistas/admin.php";
    } else { //SI ES NORMAL

        require "vistas/normal.php";
    }
} else { //SI NO, LOGIN

    require "vistas/login.php";
}
