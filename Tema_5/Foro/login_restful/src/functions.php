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

            $consulta = "INSERT into usuarios (nombre, usuario, clave, email) VALUES (?, ?, ?, ?)";

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

function login($datos)
{

    try {

        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {
            $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            if ($sentencia->rowCount() > 0)
                $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
            else
                $respuesta["mensaje"] = "Usuario y/o constraseña no válido/s";
        } catch (PDOException $e) {

            $respuesta["error"] = "Imposible realizar la consulta. Error: " . $e->getMessage();
        }
    } catch (PDOException $e) {

        $respuesta["error"] = "Imposible conectar con la BD. Error: " . $e->getMessage();
    }

    return $respuesta;
}

























//LISTA TODOS LOS PRODUCTOS
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


//BUSCA UN PRODUCTO
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

//INSERTAR UN PRODUCTO
function insertar_producto($datos)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {

            $consulta = "INSERT INTO producto (cod,nombre,nombre_corto,descripcion,PVP,familia) VALUES (?,?,?,?,?,?)";

            $sentencia = $conexion->prepare($consulta);

            $sentencia->execute($datos);

            $respuesta["mensaje"] = $datos[0]; //Devuelve el código, avisando de OK

        } catch (PDOException $e) {

            $respuesta["mensaje_error"] = "Imposible realizar la inserción. Error: " . $e->getMessage();
        }

        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "Imposible conectar. Error: " . $e->getMessage();
    }

    return $respuesta;
}

//EDITAR UN PRODUCTO
function editar_producto($datos)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {

            $consulta = "UPDATE producto SET nombre =?,nombre_corto=?,descripcion=?,PVP=?,familia=?
                            WHERE cod = ?";

            $sentencia = $conexion->prepare($consulta);

            $sentencia->execute($datos);

            $respuesta["mensaje"] = $datos[5]; //Devuelve el código, avisando de OK

        } catch (PDOException $e) {

            $respuesta["mensaje_error"] = "Imposible editar el producto. Error: " . $e->getMessage();
        }

        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "Imposible conectar. Error: " . $e->getMessage();
    }

    return $respuesta;
}

//BORRAR UN PRODUCTO
function borrar_producto($datos)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {

            $consulta = "DELETE FROM producto
                            WHERE cod = ?";

            $sentencia = $conexion->prepare($consulta);

            $sentencia->execute([$datos]);

            $respuesta["mensaje"] = $datos; //Devuelve el código, avisando de OK

        } catch (PDOException $e) {

            $respuesta["mensaje_error"] = "Imposible borrar el producto. Error: " . $e->getMessage();
        }

        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "Imposible conectar. Error: " . $e->getMessage();
    }

    return $respuesta;
}


//LISTAR FAMILIAS

function obtener_familias()
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {

            $consulta = "SELECT * FROM familia";

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute();

            $respuesta["familias"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {

            $respuesta["mensaje_error"] = "Imposible borrar el producto. Error: " . $e->getMessage();
        }
    } catch (PDOException $e) {

        $respuesta["mensaje_error"] = "Imposible conectar. Error: " . $e->getMessage();
    }

    return $respuesta;
}


//OBTENER FAMILIA
function obtener_familia($cod)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {

            $consulta = "SELECT * FROM familia WHERE cod = ?";

            $sentencia = $conexion->prepare($consulta);

            $datos[] = $cod;

            $sentencia->execute($datos);

            $respuesta["familia"] = $sentencia->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {

            $respuesta["mensaje_error"] = "Imposible relizar la consulta. Error: " . $e->getMessage();
        }
    } catch (PDOException $e) {

        $respuesta["mensaje_error"] = "Imposible conectar. Error: " . $e->getMessage();
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
