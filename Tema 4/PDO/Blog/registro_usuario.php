<?php
require "src/config_bd.php";
require "src/functions.php";

//Abrimos la sesión del login
session_name("Blog");
session_start();

if (isset($_POST["boton_registro"])) {

    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_nombre = $_POST["nombre"] == "";
    $error_email = $_POST["email"] == "";

    if (!$error_usuario || !$error_email) { //Si no tienen error, hay que comprobar repes



        try { //Conexión
            $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        } catch (PDOException $e) {
            $mensaje_error =  "Imposible realizar la conexión. Error: " . $e->getMessage();
            die(pag_error("Blog Personal", "Blog_Personal", $mensaje_error));
        }



        if (!$error_usuario) { //Si no hay error usuario
            $error_usuario = repetido($conexion, "usuarios", "usuario", $_POST["usuario"]);

            if (is_string($error_usuario)) { //Si ha saltado el catch en repetido()
                $conexion = null;
                die(error_page("Blog Personal", "Blog Personal", $error_usuario));
            }
        }

        if (!$error_email) {
            $error_email = repetido($conexion, "usuarios", "email", $_POST["email"]);

            if (is_string($error_email)) { //Si ha saltado el catch en repetido()
                $conexion = null;
                die(error_page("Blog Personal", "Blog Personal", $error_usuario));
            }
        }

        $error_form = $error_usuario || $error_clave || $error_nombre || $error_email;

        if (!$error_form) { //No hay errores ni repetidos

            //Se registra al usuario
            try {
                $consulta = "INSERT INTO usuarios (usuario, clave, nombre, email)
                                VALUES (?,?,?,?)";

                $sentencia = $conexion->prepare($consulta); //prepara la consulta
                $datos[] = $_POST["usuario"];
                $datos[] = md5($_POST["clave"]);
                $datos[] = $_POST["nombre"];
                $datos[] = $_POST["email"];

                $sentencia->execute($datos); //La ejecuta

                //Se le logea
                $_SESSION["usuario"] =  $datos[0];
                $_SESSION["clave"] =   $datos[1];
                $_SESSION["ultimo_acceso"] =  time();

                //Y página principal
                header("Location:index.php");
                exit;
            } catch (PDOException $e) {
                $conexion = null;
                $sentencia = null;
                unset($datos);
                die(pag_error("Blog Personal", "Blog Personal", "Imposible realizar la consulta, Error: " . $e->getMessage()));
            }
        }
    }
}


require "vistas/cabecera.php";


?>


<form action="registro_usuario.php" method="post">
    <p>
        <label for="usuario">Nombre de usuario: </label>
        <input type="text" id="usuario" name="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"] ?>">
        <?php
        if (isset($_POST["boton_registro"]) && $error_usuario) {
            if ($_POST["usuario"] == "")
                echo "<span class='error'> *Campo vacío</span>";
            else
                echo "<span class='error'> *Usuario ya registrado</span>";
        }

        ?>
    </p>

    <p><label for="clave">Clave: </label>
        <input type="password" id="clave" name="clave">
        <?php
        if (isset($_POST["boton_registro"]) && $error_clave)
            echo "<span class='error'> *Campo vacío</span>";
        ?>
    </p>

    <p>
        <label for="nombre">Nombre: </label>
        <input type="text" id="nombre" name="nombre" value="<?php if (isset($_POST["nombre"])) echo $_POST["nombre"] ?>">
        <?php
        if (isset($_POST["boton_registro"]) && $error_nombre)
            echo "<span class='error'> *Campo vacío</span>";
        ?>
    </p>

    <p>
        <label for="email">E-mail: </label>
        <input type="email" id="email" name="email" value="<?php if (isset($_POST["email"])) echo $_POST["email"] ?>">
        <?php
        if (isset($_POST["boton_registro"]) && $error_email) {
            if ($_POST["email"] == "")
                echo "<span class='error'> *Campo vacío</span>";
            else
                echo "<span class='error'> *E-mail ya en uso</span>";
        }

        ?>
    </p>

    <p>
        <button type="submit" formaction="index.php">Volver</button>
        <button type="submit" name="boton_registro">Registarse</button>
    </p>
    </body>

    </html>