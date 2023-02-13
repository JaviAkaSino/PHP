<?php
require "config_bd.php";

function conexion_pdo()
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
        $respuesta["mensaje"]="Conexi&oacute;n a la BD realizada con &eacute;xito";
        
        $conexion=null;
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}


function conexion_mysqli()
{
    @$conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
    if(!$conexion)
        $respuesta["error"]="Imposible conectar:".mysqli_connect_errno(). " : ".mysqli_connect_error();
    else
    {
        mysqli_set_charset($conexion,"utf8");
        $respuesta["mensaje"]="Conexi&oacute;n a la BD realizada con &eacute;xito";
        mysqli_close($conexion);
    }
    return $respuesta;
}

function login($datos)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));        
    
        try{

            $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            if( $sentencia->rowCount()>0){

                $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
            } else {

                $respuesta["mensaje"] = "Usuario o contraseña incorrectos";
            }

        } catch (PDOException $e){

            $respuesta["error"]="Imposible realziar la consulta:".$e->getMessage();
        }
    }
    catch(PDOException $e){

        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}
?>
