<?php

define("MINUTOS", 3);

//Conexión abierta de login
/*try {
    $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
} catch (PDOException $e) {
    die(pag_error("Imposible conectar. Error: " . $e->getMessage()));
}*/

try {
    $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
} catch (PDOException $e) {
    die(pag_error("Imposible conectar. Error: " . $e->getMessage()));
}

try {

    $consulta = "SELECT * FROM clientes WHERE usuario = ? AND clave = ?";

    $sentencia = $conexion->prepare($consulta);
    $datos_seguridad[] = $_SESSION["usuario"];
    $datos_seguridad[] = $_SESSION["clave"];

    $sentencia->execute($datos_seguridad);

    if ($sentencia->rowCount() < 1) { //Si no está

        session_unset(); //borra datos
        $_SESSION["seguridad"] = "El usuario ha sido baneado";

        $sentencia = null;

        header("Location:".$salto); 

        exit;
    } else { //Si está guardamos datos

        $datos_usuario_log = $sentencia->fetch(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {

    $conexion = null;
    $sentencia = null;
    die(pag_error("Imposible realizar consulta. Error: " . $e->getMessage()));
}

//comprueba tiempo


if (time() - $_SESSION["ultimo_acceso"] > MINUTOS * 60) {

    session_unset(); //borra datos
    $_SESSION["seguridad"] = "Se ha cerrado sesión por inactividad. Tiempo excedido";
    //recarga ???????
    header("Location:".$salto); 
    exit;
}


//pasa los filtros

$_SESSION["ultimo_acceso"] = time();
