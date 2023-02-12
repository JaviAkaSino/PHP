<?php
require "src/bd_config.php";

function obtener_usuarios()
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try
        {
            $consulta="select * from usuarios";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute();
            $respuesta["usuarios"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
            
        }
        catch(PDOException $e)
        {
        
            $respuesta["error"]="Imposible realizar la consulta. Error:".$e->getMessage();
        }

        $sentencia=null;
        $conexion=null; 
    }
    catch(PDOException $e)
    {
        $respuesta["error"]="Imposible conectar. Error:".$e->getMessage();
    }

    
    return $respuesta;
}



function login($datos,$first_time=true)
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try
        {
            $consulta="select * from usuarios where usuario=? and clave=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute($datos);
            if($sentencia->rowCount()>0)
            {
                $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
                if($first_time)
                {
                    session_name("api_login_22_23");
                    session_start();
                    $_SESSION["usuario"]=$datos[0];
                    $_SESSION["clave"]=$datos[1];
                    $_SESSION["tipo"]=$respuesta["usuario"]["tipo"];
                    $respuesta["api_session"]=session_id();
                }
            }
            else
                $respuesta["mensaje"]="El usuario no se encuentra registrado en la BD";
            
        }
        catch(PDOException $e)
        {
        
            $respuesta["error"]="Imposible realizar la consulta. Error:".$e->getMessage();
        }

        $sentencia=null;
        $conexion=null; 
    }
    catch(PDOException $e)
    {
        $respuesta["error"]="Imposible conectar. Error:".$e->getMessage();
    }

    
    return $respuesta;
}


function insertar_usuario($datos)
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try
        {
            $consulta="insert into usuarios (nombre,usuario,clave,email) values (?,?,?,?)";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute($datos);
            $respuesta["ult_id"]=$conexion->lastInsertId();
            
        }
        catch(PDOException $e)
        {
        
            $respuesta["error"]="Imposible realizar la consulta. Error:".$e->getMessage();
        }

        $sentencia=null;
        $conexion=null; 
    }
    catch(PDOException $e)
    {
        $respuesta["error"]="Imposible conectar. Error:".$e->getMessage();
    }

    
    return $respuesta;
}

function actualizar_usuario($datos)
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try
        {
            $consulta="update usuario set nombre=?,usuario=?,clave=?,email=? where id_usuario=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute($datos);
            $respuesta["mensaje"]="El usuario ".$datos[4]." ha sido actualizado con éxito";
            
        }
        catch(PDOException $e)
        {
        
            $respuesta["error"]="Imposible realizar la consulta. Error:".$e->getMessage();
        }

        $sentencia=null;
        $conexion=null; 
    }
    catch(PDOException $e)
    {
        $respuesta["error"]="Imposible conectar. Error:".$e->getMessage();
    }

    
    return $respuesta;
}

function borrar_usuario($id_usuario)
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try
        {
            $consulta="delete from usuarios where id_usuario=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute([$id_usuario]);
            $respuesta["mensaje"]="El usuario ".$id_usuario." ha sido borrado con éxito";
        }
        catch(PDOException $e)
        {
        
            $respuesta["error"]="Imposible realizar la consulta. Error:".$e->getMessage();
        }

        $sentencia=null;
        $conexion=null; 
    }
    catch(PDOException $e)
    {
        $respuesta["error"]="Imposible conectar. Error:".$e->getMessage();
    }

    
    return $respuesta;
}

function repetido($tabla,$columna,$valor,$columna_clave=null,$valor_clave=null)
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try
        {
            if(isset($columna_clave))
            {
                $consulta="select ".$columna." from ".$tabla." where ".$columna."=? and ".$columna_clave."<>?";
                $datos[]=$valor;
                $datos[]=$valor_clave;
            }
            else
            {
                $consulta="select ".$columna." from ".$tabla." where ".$columna."=?";
                $datos[]=$valor;
            }

            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute($datos);
            $respuesta["repetido"]=$sentencia->rowCount()>0;
        }
        catch(PDOException $e)
        {
        
            $respuesta["mensaje_error"]="Imposible realizar la consulta. Error:".$e->getMessage();
        }

        $sentencia=null;
        $conexion=null; 
    }
    catch(PDOException $e)
    {
        $respuesta["mensaje_error"]="Imposible conectar. Error:".$e->getMessage();
    }

    
    return $respuesta;
}
?>