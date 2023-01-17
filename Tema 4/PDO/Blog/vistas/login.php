<?php

//LOGIN

if (isset($_POST["boton_login"])) {

    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";

    $error_form = $error_usuario || $error_clave;

    if (!$error_form) { //Si no hay errores, comprobamos veracidad

        $error_login = true;
        //Conexión
        try {
            $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        } catch (PDOException $e) {
            $conexion = null;
            echo  "Imposible conectar. Error: " . $e->getMessage();
        }

        //Consulta veracidad
        try {
            $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";
            $sentencia = $conexion->prepare($consulta); //Prepara la consulta

            $datos[] = $_POST["usuario"];
            $datos[] = md5($_POST["clave"]);
            $sentencia->execute($datos); //La ejecuta

            if ($sentencia->rowCount() > 0) { //Si se encuentra el usuario con la contraseña
                $_SESSION["usuario"] = $_POST["usuario"];
                $_SESSION["clave"] = $_POST["clave"];
                $_SESSION["ultimo_acceso"] = time();

                $error_login = false;
            }
        } catch (PDOException $e) {
            $conexion = null;
            echo "<p>No ha sido posible conectar a la BD. Error " . $e->getMessage() . "</p></body></html>";
        }

    }
}

?>

<!-- LOGIN -->
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
    ?>

    <p>
        <button type="submit" name="boton_login">Entrar</button>
        <button type="submit" formaction="registro_usuario.php">Registarse</button>
    </p>
</form>