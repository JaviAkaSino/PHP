<?php
require "src/config_bd.php";
require "src/functions.php";

//Abrimos la sesión del login
session_name("Blog");
session_start();

//En este caso, conectamos siempre 

try { //Conexión

    $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
} catch (PDOException $e) {

    $mensaje_error =  "Imposible realizar la conexión. Error: " . $e->getMessage();
    pag_error("Blog Personal", "Blog_Personal", $mensaje_error);
}



//Si la sesión está iniciada
if (isset($_SESSION["usuario"]) && isset($_SESSION["clave"]) && isset($_SESSION["ultimo_acceso"])) {

    //SEGURIDAD
    define("MINUTOS", 5); //Define el tiempo

    try { //Comprueba el usuario (ban)
        $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";
        $sentencia = $conexion->prepare($consulta); //Prepara la consulta
        $datos[] = $_SESSION["usuario"];
        $datos[] = $_SESSION["clave"];

        $sentencia->execute($datos); //La ejecuta

        if ($sentencia->rowCount() > 0) { //Lo encuentra

            $datos_usuario_log = $sentencia->fetch(PDO::FETCH_ASSOC); //Guarda los datos
            $sentencia = null; //Limpia sentencia
            unset($datos); //Limpia datos

        } else { //El usuario ha sido baneado

            session_unset(); //Borra los datos del login
            $_SESSION["seguridad"] =  "El usuario ha sido baneado";
            header("Location:index.php");
            exit;
        }
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        unset($datos);
        die(pag_error("Blog Personal", "Blog Personal", "No se ha podido realizar la consulta. Error: " . $e->getMessage()));
    }

    //Comprueba el tiempo
    if ((time() - $_SESSION["ultimo_acceso"]) > MINUTOS * 60) { //Si el tiempo excede
        session_unset();
        $_SESSION["seguridad"] = "Sesión suspendida por inactividad. Ha excedido los " . MINUTOS . " minutos";
        header("Location:index.php"); //Recarga la página
        exit;
    }

    //Si pasa todos los filtros
    $_SESSION["ultimo_acceso"] = time();


} else { //Si no está logueado, LOGIN

    require "vistas/login.php";
}
