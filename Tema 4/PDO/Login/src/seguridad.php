<?php
define("MINUTOS", 5);

//CONEXION
try {
    $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
} catch (Exception $e) {

    die(error_page("Login con PDO", "Login con PDO", "Imposible conectar. Error: " . $e->getMessage()));
}

//CONSULTA
try {
    $consulta = "SELECT * FROM usuarios WHERE usuario=? and clave =?";
    $sentencia = $conexion->prepare($consulta);
    $datos[] = $_SESSION["usuario"];
    $datos[] = $_SESSION["clave"];
    $sentencia->execute($datos);

    if ($sentencia->rowCount() > 0) {

        $datos_usuario_log = $sentencia->fetch(PDO::FETCH_ASSOC);
        $sentencia = null;
    } else { //Si está baneado

        session_unset(); //Borra los valores de session de login
        $_SESSION["seguridad"] = "El usuario ya no se encuentra registrado en la BD"; //Crea seguridad (baneo)
        header("Location:index.php"); //Recarga
        exit;
    }
} catch (PDOException $e) {

    $sentencia = null; //Libera sentencia
    $conexion = null; //Cierra conexión
    die(error_page("Login con PDO", "Login con PDO", "Imposible realizar la consulta. Error: " . $e->getMessage()));
}


if ((time() - $_SESSION["ultimo_acceso"]) > 60 * MINUTOS) { //Si se excede el tiempo de sesión

    session_unset(); //Borra los valores de session de login
    $_SESSION["seguridad"] = "El tiempo de sesión ha sido excedido"; //Sesión expirada
    header("Location:index.php"); //Recarga
    exit;
}

$_SESSION["ultimo_acceso"] = time();
