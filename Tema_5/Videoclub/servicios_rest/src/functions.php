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


function login($datos, $first_time = true)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {

            $consulta = "SELECT * FROM clientes WHERE usuario = ? AND clave = ?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            if ($sentencia->rowCount() > 0) { //Info correcta

                $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);

                if ($first_time) { //En el login
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
        } catch (PDOException $e) {

            $respuesta["error"] = "Error de consulta: " . $e->getMessage();
        }

        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {

        $respuesta["error"] = "Error conectando a BD: " . $e->getMessage();
    }

    return $respuesta;
}


function clientes()
{


    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {

            $consulta = "SELECT * FROM clientes WHERE tipo = 'normal'";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute();

            $respuesta["clientes"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {

            $respuesta["error"] = "Error de consulta: " . $e->getMessage();
        }

        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {

        $respuesta["error"] = "Error conectando a BD: " . $e->getMessage();
    }

    return $respuesta;
}


function info_cliente($id)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {

            $consulta = "SELECT * FROM clientes WHERE id_cliente = ?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute([$id]);

            $respuesta["cliente"] = $sentencia->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {

            $respuesta["error"] = "Error de consulta: " . $e->getMessage();
        }

        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {

        $respuesta["error"] = "Error conectando a BD: " . $e->getMessage();
    }

    return $respuesta;
}


function nuevo_cliente($datos)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {
            //INSERTAMOS SIN FOTO
            $datos_insert[] = $datos[0];
            $datos_insert[] = $datos[1];

            $consulta = "INSERT INTO clientes (usuario, clave) VALUES (?, ?)";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos_insert);

            $id_insertado = $conexion->lastInsertId();

            $respuesta["mensaje"] = "El usuario " . $id_insertado . " ha sido añadido con éxito";


            //AHORA FOTO SI LA HAY
            $foto = $datos[2];

            if ($foto["name"] != "") {

                //Creamos nombre
                $array_nombre = explode(".", $foto["name"]);
                $ext = "";
                if (count($array_nombre) > 1)
                    $ext = "." . end($array_nombre);

                $nuevo_nombre = "img_" . $id_insertado . $ext;

                //MOVEMOS LA IMAGEN

                @$var = move_uploaded_file($foto["tmp_name"], "/img/" . $nuevo_nombre);

                if ($var) {

                    $datos_img[] = $nuevo_nombre;
                    $datos_img[] = $id_insertado;
                    try {

                        $consulta = "UPDATE clientes SET foto = ? WHERE id_cliente = ?";
                        $sentencia = $conexion->prepare($consulta);
                        $sentencia->execute($datos_img);

                    } catch (PDOException $e) {
                        if (is_file("img/" . $nuevo_nombre)) {
                            unlink("img/" . $nuevo_nombre);
                        }
                        $respuesta["error"] = "Error en la subida del archivo a la BD: " . $e->getMessage();
                    }
                } else {

                    $respuesta["mensaje"] = "El usuario " . $id_insertado . " ha sido añadido con la imagen por defecto";
                }
            }
        } catch (PDOException $e) {

            $respuesta["error"] = "Error de consulta: " . $e->getMessage();
        }

        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {

        $respuesta["error"] = "Error conectando a BD: " . $e->getMessage();
    }

    return $respuesta;
}

function repetido($tabla, $columna, $valor, $columna_clave = null, $valor_clave = null)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {

            $datos[] = $valor;

            if (isset($columna_clave)) {
                $datos[] = $valor_clave;
                $consulta = "SELECT * FROM " . $tabla . " WHERE " . $columna . " = ? AND " . $columna_clave . " <> ?";
            } else {
                $consulta = "SELECT * FROM " . $tabla . " WHERE " . $columna . " = ?";
            }

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            $respuesta["repetido"] = $sentencia->fetch(PDO::FETCH_ASSOC) > 0;
        } catch (PDOException $e) {

            $respuesta["error"] = "Error de consulta: " . $e->getMessage();
        }

        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {

        $respuesta["error"] = "Error conectando a BD: " . $e->getMessage();
    }

    return $respuesta;
}
