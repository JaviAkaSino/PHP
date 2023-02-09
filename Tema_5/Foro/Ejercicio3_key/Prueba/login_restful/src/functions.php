<?php

//$conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));


// OBTENER TODOS LOS USUARIOS

function obtener_usuarios()
{

    try {

        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {
            $consulta = "SELECT * FROM usuarios";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute();

            $respuesta["usuarios"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {

            $respuesta["error"] = "Imposible realizar la consulta. Error: " . $e->getMessage();
        }
    } catch (PDOException $e) {

        $respuesta["error"] = "Imposible conectar con la BD. Error: " . $e->getMessage();
    }

    return $respuesta;
}


//INSERTAR NUEVO USUARIO

function nuevo_usuario($datos)
{

    try {

        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {

            $consulta = "INSERT into usuarios (nombre, usuario, clave, email, tipo) VALUES (?, ?, ?, ?, ?)";

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            $respuesta["ult_id"] = $conexion->lastInsertId();
        } catch (PDOException $e) {

            $respuesta["error"] = "Imposible realizar la inserción. Error: " . $e->getMessage();
        }

        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {

        $respuesta["error"] = "Imposible conectar con la BD. Error: " . $e->getMessage();
    }


    return $respuesta;
}

// LOGIN

function login($datos, $first_time = true)
{

    try {

        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {
            $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            if ($sentencia->rowCount() > 0) {

                $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);

                if ($first_time) { //Para la primera vez
                    //SEGURIDAD PROTEGER SERVICIOS
                    session_name("api_login_segura");
                    session_start();
                    //Creamos sesión para usuario y clave
                    $_SESSION["usuario"] = $datos[0];
                    $_SESSION["clave"] = $datos[1];

                    $_SESSION["tipo"] = $respuesta["usuario"]["tipo"];
                    $respuesta["api_session"] = session_id();
                }
            } else {
                $respuesta["mensaje"] = "Usuario y/o constraseña no válido/s";
            }
        } catch (PDOException $e) {

            $respuesta["error"] = "Imposible realizar la consulta. Error: " . $e->getMessage();
        }

        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {

        $respuesta["error"] = "Imposible conectar con la BD. Error: " . $e->getMessage();
    }

    return $respuesta;
}




//EDITAR USUARIO 

function editar_usuario($datos)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {

            $consulta = "UPDATE usuarios SET nombre = ?, usuario = ?, clave = ?, email = ? 
                            WHERE id_usuario = ?";

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            $respuesta["mensaje"] = "El usuario " . end($datos) . " ha sido borrado con éxito";
        } catch (PDOException $e) {

            $respuesta["error"] = "Imposible realizar la consulta. Error: " . $e->getMessage();
        }

        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {

        $respuesta["error"] = "Imposible conectar con la BD. Error: " . $e->getMessage();
    }

    return $respuesta;
}


//BORRAR USUARIO

function borrar_usuario($id)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {

            $consulta = "DELETE FROM usuarios WHERE id_usuario = ?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute([$id]);

            $respuesta["mensaje"] = "El usuario " . $id . " ha sido borrado con éxito";
        } catch (PDOException $e) {

            $respuesta["error"] = "Imposible realizar la consulta. Error: " . $e->getMessage();
        }

        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {

        $respuesta["error"] = "Imposible conectar con la BD. Error: " . $e->getMessage();
    }

    return $respuesta;
}

























//REPETIDO INSERT
function repetido($tabla, $columna, $valor, $columna_clave = null, $valor_clave = null)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {

            $datos[] = $valor;

            if (isset($_POST[$columna_clave])) {
                $consulta = "SELECT * FROM " . $tabla . " WHERE " . $columna . "= ? AND " . $columna_clave . " <> ?";
                $datos[] = $valor_clave;
            } else {
                $consulta = "SELECT * FROM " . $tabla . " WHERE " . $columna . " = ?";
            }

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            $respuesta["repetido"] = $sentencia->rowCount() > 0;
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
