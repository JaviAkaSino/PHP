<?php
require "src/config_bd.php";
require "src/functions.php";

//Abrimos la sesión del login
session_name("Blog");
session_start();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Personal</title>
</head>

<body>
    <h1>Blog Personal</h1>

    <?php 
    //Si la sesión está iniciada
        if (isset($_SESSION["usuario"]) && isset($_SESSION["clave"]) && isset($_SESSION["ultimo acceso"])){

            //Comprueba la seguridad
            define("MINUTOS", 5); //Define el tiempo

            try { //Conexión

                $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            } catch (PDOException $e) {
        
                $mensaje_error = "<p>Imposible realizar la conexión. Error: " . $e->getMessage() . "</p></body></html>";
                die($mensaje_error);
            }

            
            try {
                $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";
                $sentencia = $conexion->prepare($consulta); //Prepara la consulta
                $datos[] = $_SESSION["usuario"];
                $datos[] = $_SESSION["clave"];
            } catch (PDOException $e) {
                $sentencia = null;
                $conexion = null;
                echo "<p>No se ha podido realizar la consulta. Error: ".$e->getMessage()."</p>"; 
            }



        } else { //Si no está logueado, LOGIN

            require "vistas/login.php";
        }

    //NOTICIAS

    //CONEXION

    try {

        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {

        $mensaje_error = "<p>Imposible realizar la conexión. Error: " . $e->getMessage() . "</p></body></html>";
        die($mensaje_error);
    }

    //CONSULTA

    try {

        if (isset($_POST["boton_ver"])) { //Si se ha pulsado alguna noticia

            $consulta = "SELECT * FROM noticias 
                JOIN usuarios ON noticias.idUsuario = usuarios.idUsuario
                JOIN categorias ON noticias.idCategoria = categorias.idCategoria
                WHERE noticias.idNoticia = ?";

            $sentencia = $conexion->prepare($consulta); //Prepara la consulta

            $datos[] = $_POST["boton_ver"];
            $sentencia->execute($datos); //La ejecuta

            if ($sentencia->rowCount() > 0) { //Controla que siga existiendo
                $tupla = $sentencia->fetch(PDO::FETCH_ASSOC);
                echo "<h3>" . $tupla["titulo"] . "</h3>";
                echo "<p>Publicado por <strong>" . $tupla["usuario"] . "</strong> en <em>" . strtoupper($tupla["valor"]) . "</em></p>";
                echo "<p>" . $tupla["cuerpo"] . "</p>";

                $sentencia = null; //Libera la consulta ????????
                $tupla = null;

                echo "<h3>Comentarios</h3>";

                try {
                    $consulta = "SELECT * FROM comentarios
                        JOIN usuarios ON comentarios.idUsuario=usuarios.idUsuario
                        WHERE idNoticia = ? AND estado = ?";

                    $sentencia = $conexion->prepare($consulta); //Prepara la consulta
                    $datos[] = "apto"; //El idNoticia ya está en datos
                    $sentencia->execute($datos); //Ejecuta

                    if ($sentencia->rowCount() > 0) { //Si hay comentarios

                        $respuesta = $sentencia->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($respuesta as $tupla) {

                            echo "<p><strong>" . $tupla["usuario"] . "</strong> dijo:<br/>" . $tupla["comentario"] . "</p>";
                        }

                        $sentencia = null;  //?????????????????
                        $respuesta = null;
                    } else { //Si no hay comentarios

                        echo "<p>No hay comentarios para esta noticia. ¡Sé tu el primero!</p>";
                    }
                } catch (PDOException $e) {
                    $conexion = null;
                    $sentencia = null;
                    echo "<p>No han podido cargarse los comentarios Error: " . $e->getMessage() . "</p>";
                }
            } else {
                echo "<p>La noticia ya no está en la BD</p>";
            }
        } else { //Si no se ha pulsado ninguna, lista las noticias

            $consulta = "SELECT idNoticia, titulo, copete FROM noticias";
            $sentencia = $conexion->prepare($consulta); //Prepara la consulta
            $sentencia->execute(); //La ejecuta

            if ($sentencia->rowCount() > 0) { //Si hay noticias

                echo "<h2>Noticias</h2>";

                $respuesta = $sentencia->fetchAll(PDO::FETCH_ASSOC);

                foreach ($respuesta as $tupla) {

                    echo "<form action='index.php' method='post'>
                        <button type='submit' name='boton_ver' value='" . $tupla["idNoticia"] . "'>" . $tupla["titulo"] . "</button>
                    </form>";
                    echo "<p>" . $tupla["copete"] . "</p>";
                }
            }
        }
    } catch (PDOException $e) {
        $mensaje_error = "<p>Imposible realizar la consulta. Error: " . $e->getMessage() . "</p></body></html>";
        die($mensaje_error);
    }


    ?>


</body>

</html>