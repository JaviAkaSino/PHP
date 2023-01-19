<?php
require "src/config_bd.php";
require "src/functions.php";

//Abrimos la sesión del login
session_name("Blog");
session_start();

//Si se ha pulsado salir

if (isset($_POST["boton_salir"])){
    session_unset();
}


//En este caso, conectamos siempre 

try { //Conexión
    $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

} catch (PDOException $e) {
    $mensaje_error =  "Imposible realizar la conexión. Error: " . $e->getMessage();
    pag_error("Blog Personal", "Blog_Personal", $mensaje_error);
}


//Si la sesión está iniciada
if (isset($_SESSION["usuario"]) && isset($_SESSION["clave"]) && isset($_SESSION["ultimo_acceso"])) {

    //SEGURIDAD
    require "src/seguridad.php";

    if($datos_usuario_log["tipo"] == "admin"){


    } else {

        require "vistas/normal.php";
    }


} else { //Si no está logueado, LOGIN

    require "vistas/login.php";
}
