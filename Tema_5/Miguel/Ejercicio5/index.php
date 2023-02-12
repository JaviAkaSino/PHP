<?php
require "src/funciones.php";
define("DIR_SERV","http://localhost/Proyectos/Curso22_23/Servicios_Web/Ejercicio3_key/login_restful");

session_name("Login_SW_22_23");
session_start();

if(isset($_POST["btnSalir"]))
{
    $datos_salir["api_session"]=$_SESSION["api_session"];
    $url=DIR_SERV."/salir";
    consumir_servicios_REST($url,"POST",$datos_salir);
    session_destroy();
    header("Location:index.php");
    exit;
}


if(isset($_SESSION["usuario"]) && isset($_SESSION["clave"])&& isset($_SESSION["ultimo_acceso"])&& isset($_SESSION["api_session"]))
{

    require "src/seguridad.php";

    if($datos_usuario_log->tipo=="admin")
        require "vistas/vista_admin.php";
    else
        require "vistas/vista_normal.php";



}
else
{

    require "vistas/vista_login.php";
}
