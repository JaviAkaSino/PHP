<?php

function obtener_productos()
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {

            $consulta = "SELECT * FROM producto";

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute();
            $respuesta["productos"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {

            $respuesta["mensaje_error"] = "Imposible realizar la consulta. Error: " . $e->getMessage();
        }

        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "Imposible conectar. Error: " . $e->getMessage();
    }




    return $respuesta;
}


function obtener_producto($cod)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {

            $consulta = "SELECT * FROM producto WHERE cod=?";

            $sentencia = $conexion->prepare($consulta);
            $datos[] = $cod;

            $sentencia->execute($datos);
            $respuesta["producto"] = $sentencia->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {

            $respuesta["mensaje_error"] = "Imposible realizar la consulta. Error: " . $e->getMessage();
        }

        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "Imposible conectar. Error: " . $e->getMessage();
    }




    return $respuesta;
}
