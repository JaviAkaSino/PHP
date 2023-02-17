<?php

require "src/funciones.php";

define("DIR_SERV", "http://localhost/PHP/Tema_5/Examen_SW_22_23/servicios_rest");
define("MINUTOS", 2);

session_name("Exam_sw_22_23");
session_start();

if (isset($_POST["boton_salir"])) {

    session_destroy();
    header("Location:index.php");
    exit;
}


if (isset($_SESSION["api_session"]) && isset($_SESSION["ultimo_acceso"]) && isset($_SESSION["usuario"]) && isset($_SESSION["clave"])) {

    //seguridad

    require "src/seguridad.php";

    //admin

    if ($datos_usuario_log->tipo == "admin") {

        header("Location:admin/index.php");
        exit;

    } else {

        require "vistas/normal.php";
    }
} else {

    //login

    require "vistas/login.php";
}

