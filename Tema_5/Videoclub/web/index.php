<?php

require "src/funciones.php"; //Cargo las funciones

session_name("videoclub_normal");//Inicio sesión
session_start();

define("MINUTOS", 5); //Defino el tiempo
define("DIR_SERV", "http://localhost/PHP/Tema_5/Videoclub/servicios_rest"); //Ubi REST

//SI PULSA SALIR


//SI ESTÁ LOGUEADO
if (isset($_SESSION["api_session"]) && isset($_SESSION["usuario"]) && isset($_SESSION["clave"]) && isset($_SESSION["ultimo_acceso"])){

    //SEGURIDAD

    require "src/seguridad.php";
    //SI ES ADMIN
    
    //SI ES NORMAL


} else { //SI NO, LOGIN

require "vistas/login.php";

}


