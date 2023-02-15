<?php

require "bd_config.php";


function conexion_pdo()
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        $respuesta["mensaje"] = "Conexi&oacute;n a la BD realizada con &eacute;xito";

        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}


function login($datos, $first_time = true){

    try{
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try{
    
            $consulta = "SELECT * FROM clientes WHERE usuario = ? AND clave = ?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            $respuesta["user"] = $datos;
            if ($sentencia->rowCount()>0){ //Info correcta


                $respuesta["usuario"]= $sentencia->fetch(PDO::FETCH_ASSOC);

                if ($first_time){ //En el login
                    //Crea sesión api
                    session_name("videoclub_api");
                    session_start();
                    //Guarda datos
                    $_SESSION["usuario"] = $datos[0];
                    $_SESSION["clave"] = $datos[1];
                    $_SESSION["tipo"] = $respuesta["usuario"]["tipo"];
                    //Guarda objeto con los datos de la sesión
                    $respuesta["api_session"] = session_id();
                }
                
            } else {

                $respuesta["mensaje"] = "Usuario o contraseña no válidos";
            }

        } catch(PDOException $e){
    
            $respuesta["error"]= "Error de consulta: " . $e->getMessage();
        }

    } catch(PDOException $e){

        $respuesta["error"]= "Error conectando a BD: " . $e->getMessage();
    }

    return $respuesta;
}
