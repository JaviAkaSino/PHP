<?php
require "src/config_bd.php";
require "src/functions.php";

//Abre sesión (login)
session_name("Login_PDO");
session_start();

//Si se pulsa salir
if (isset($_POST["boton_salir"])) {
    session_destroy();
    header("Location:index.php");
    exit;
}

//Si ya está logeado
if (isset($_SESSION["usuario"]) && isset($_SESSION["clave"]) && isset($_SESSION["ultimo_acceso"])) {

    require "src/seguridad.php";


    if($datos_usuario_log["tipo"] == "admin"){ //Si es ADMIN

        require "vistas/admin.php";

    } else { //Si es usuario NORMAL

        require "vistas/normal.php";

    }

    $conexion = null;

} else { //Si NO está logeado, pantalla de login

    require "vistas/login.php";
}
