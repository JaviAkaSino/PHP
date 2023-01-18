<?php

//LOGIN

if (isset($_POST["boton_login"])) {

    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";

    $error_form = $error_usuario || $error_clave;

    if (!$error_form) { //Si no hay errores, comprobamos veracidad

        $error_login = true;

        //Consulta veracidad
        try {
            $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";
            $sentencia = $conexion->prepare($consulta); //Prepara la consulta

            $datos[] = $_POST["usuario"];
            $datos[] = md5($_POST["clave"]);
            $sentencia->execute($datos); //La ejecuta

            if ($sentencia->rowCount() > 0) { //Si se encuentra el usuario con la contraseña
                $_SESSION["usuario"] = $datos[0];
                $_SESSION["clave"] = $datos[1];
                $_SESSION["ultimo_acceso"] = time();
                
                header("Location:index.php");
                exit;

            }
        } catch (PDOException $e) {
            $conexion = null;
            error_page("Blog Personal", "Blog Personal", "<p>No ha sido posible conectar a la BD. Error " . $e->getMessage() . "</p></body></html>");
        }
    }
}

?>

<!-- LOGIN -->

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

    <form action="index.php" method="post">
        <p>
            <label for="usuario">Nombre de usuario: </label>
            <input type="text" id="usuario" name="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"] ?>">
            <?php
            if (isset($_POST["boton_login"]) && $error_usuario)
                echo "<span class='error'> *Campo vacío</span>";
            ?>
        </p>

        <p><label for="clave">Clave: </label>
            <input type="password" id="clave" name="clave">
            <?php
            if (isset($_POST["boton_login"]) && $error_clave)
                echo "<span class='error'> *Campo vacío</span>";
            ?>
        </p>

        <?php
        if (isset($error_login) && $error_login) {
            echo "<span class='error'>Usuario o contraseña incorrectos</span>";
        }

        if (isset($_SESSION["seguridad"])){
            echo "<p>".$_SESSION["seguridad"]."</p>";
            unset($_SESSION["seguridad"]);
        }
        ?>

        <p>
            <button type="submit" name="boton_login">Entrar</button>
            <button type="submit" formaction="registro_usuario.php">Registarse</button>
        </p>
    </form>

    <?php
    try {

        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {

        $mensaje_error = "<p>Imposible realizar la conexión. Error: " . $e->getMessage() . "</p></body></html>";
        die($mensaje_error);
    }

    //NOTICIAS

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