<?php
require "config_bd.php";

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


function conexion_mysqli()
{
    @$conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
    if (!$conexion)
        $respuesta["error"] = "Imposible conectar:" . mysqli_connect_errno() . " : " . mysqli_connect_error();
    else {
        mysqli_set_charset($conexion, "utf8");
        $respuesta["mensaje"] = "Conexi&oacute;n a la BD realizada con &eacute;xito";
        mysqli_close($conexion);
    }
    return $respuesta;
}


// LOGIN


function login($datos, $in_log = true) //Primera vez
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {

            $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            if ($sentencia->rowCount() > 0) {

                $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);

                if ($in_log) {
                    //Creo sesión
                    session_name("Exam_API");
                    session_start();
                    //Usuario, clave y tipo
                    $_SESSION["usuario"] = $datos[0];
                    $_SESSION["clave"] = $datos[1];
                    $_SESSION["tipo"] = $respuesta["usuario"]["tipo"];

                    //Creo objeto con los datos de la sesión

                    $respuesta["api_session"] = session_id();

                }

                $respuesta["api_session"] = session_id();
            } else {

                $respuesta["mensaje"] = "Usuario o contraseña incorrectos";
            }
        } catch (PDOException $e) {

            $respuesta["error"] = "Imposible realziar la consulta:" . $e->getMessage();
        }
    } catch (PDOException $e) {

        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}

//HORARIO

function horario($id)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {

            $consulta = "SELECT horario_lectivo.dia, horario_lectivo.hora, grupos.nombre AS grupo
                            FROM horario_lectivo 
                            JOIN grupos ON horario_lectivo.grupo = grupos.id_grupo
                            WHERE horario_lectivo.usuario = ?";

            $sentencia = $conexion->prepare($consulta);
            $datos_horario[] = $id;
            $sentencia->execute($datos_horario);

            $respuesta["horario"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {

            $respuesta["error"] = "Error al realizar consulta: " . $e->getMessage();
        }
    } catch (PDOException $e) {
        $respuesta["error"] = "Error al conectar: " . $e->getMessage();
    }

    return $respuesta;
}


function usuarios()
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {
            $consulta = "SELECT * FROM usuarios WHERE tipo = 'normal'";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute();

            $respuesta["usuarios"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {

            $respuesta["error"] = "Error al realizar consulta: " . $e->getMessage();
        }
    } catch (PDOException $e) {

        $respuesta["error"] = "Error al conectar a la BD: " . $e->getMessage();
    }

    return $respuesta;
}


function tieneGrupo($datos)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {
            $consulta = "SELECT * FROM horario_lectivo
                            WHERE usuario = ? AND dia = ? AND hora = ? AND grupo = ?";


            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            $respuesta["tiene_grupo"] = $sentencia->rowCount() > 0;
        } catch (PDOException $e) {

            $respuesta["error"] = "Error al realizar consulta: " . $e->getMessage();
        }
    } catch (PDOException $e) {

        $respuesta["error"] = "Error al conectar a la BD: " . $e->getMessage();
    }

    return $respuesta;
}



function grupos($datos)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {
            $consulta = "SELECT grupos.id_grupo, grupos.nombre  
                            FROM grupos
                            JOIN horario_lectivo ON horario_lectivo.grupo = grupos.id_grupo
                            WHERE usuario = ? AND dia = ? AND hora = ?";


            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            $respuesta["grupos"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {

            $respuesta["error"] = "Error al realizar consulta: " . $e->getMessage();
        }
    } catch (PDOException $e) {

        $respuesta["error"] = "Error al conectar a la BD: " . $e->getMessage();
    }

    return $respuesta;
}


function gruposLibres($datos)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {
            $consulta = "SELECT id_grupo, nombre
                            FROM grupos
                            WHERE id_grupo
                            NOT IN (
                                SELECT grupos.id_grupo
                                FROM grupos
                                JOIN horario_lectivo ON horario_lectivo.grupo = grupos.id_grupo
                                WHERE usuario = ? AND dia = ? AND hora = ?)";


            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            $respuesta["grupos_libres"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {

            $respuesta["error"] = "Error al realizar consulta: " . $e->getMessage();
        }
    } catch (PDOException $e) {

        $respuesta["error"] = "Error al conectar a la BD: " . $e->getMessage();
    }

    return $respuesta;
}


function borrarGrupo($datos){

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {
            $consulta = "DELETE FROM horario_lectivo
                            WHERE usuario = ? AND dia = ? AND hora = ? AND grupo = ?";


            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            $respuesta["mensaje"] = "Grupo borrado con éxito";
        } catch (PDOException $e) {

            $respuesta["error"] = "Error al realizar consulta: " . $e->getMessage();
        }
    } catch (PDOException $e) {

        $respuesta["error"] = "Error al conectar a la BD: " . $e->getMessage();
    }

    return $respuesta;

}

function insertarGrupo($datos){

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {
            $consulta = "INSERT INTO horario_lectivo (usuario, dia, hora, grupo, aula) VALUES (?,?,?,?,'DEFAULT')";


            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            $respuesta["mensaje"] = "Grupo insertado con éxito";
        } catch (PDOException $e) {

            $respuesta["error"] = "Error al realizar consulta: " . $e->getMessage();
        }
    } catch (PDOException $e) {

        $respuesta["error"] = "Error al conectar a la BD: " . $e->getMessage();
    }

    return $respuesta;

}