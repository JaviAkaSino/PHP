<?php

if (isset($_POST["boton_editar"])) {

    $id_usuario = $_POST["boton_editar"];

    //Cogemos los datos del usuario

    $url = DIR_SERV . "/usuario/" . $id_usuario;
    $respuesta = consumir_servicios_rest($url, "GET", $key);
    $obj = json_decode($respuesta);

    if (!$obj) {
        $url_salir = DIR_SERV . "/salir";
        consumir_servicios_rest($url_salir, "POST", $key);
        session_destroy();
        die("<p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta . "</body></html>");
    }

    if (isset($obj->error)) {
        $url_salir = DIR_SERV . "/salir";
        consumir_servicios_rest($url_salir, "POST", $key);
        session_destroy();
        die("<p>" . $obj->error . "</p></body></html>");
    }

    if (isset($obj->no_login)) {
        session_unset();
        $_SESSION["seguridad"] = "El tiempo de sesión de la API ha expirado.";
        header("Location:index.php");
        exit;
    }

    $user = $obj->usuario;

    $nombre = $user->nombre;
    $usuario = $user->usuario;
    $email = $user->email;
} else {

    $id_usuario = $_POST["boton_confirmar_editar"];
    $nombre = $_POST["nombre"];
    $usuario = $_POST["usuario"];
    $email = $_POST["email"];
}

echo "<h2 class='centrar'>Editar Usuario " . $id_usuario . "</h2>";

if (isset($error_consistencia)) {

    echo "<div class='centrar'>";
    echo "<p>" . $error_consistencia . "</p>";
    echo "<form action='index.php' method='post'>";
    echo "<button type='submit'>Volver</button>";
    echo "</form>";
} else {

?>

    <form action="index.php" method="post" class="centrar">
        <p>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" maxlength="30" value="<?php echo $nombre ?>" />
            <?php if (isset($_POST["nombre"]) && $error_nombre)
                echo "<span class='error'>* Campo vacío * </span>"; ?>
        </p>

        <p>
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" id="usuario" maxlength="20" value="<?php echo $usuario ?>" />
            <?php if (isset($_POST["usuario"]) && $error_usuario) {

                if ($_POST["usuario"] == "")
                    echo "<span class='error'>* Campo vacío * </span>";
                else
                    echo "<span class='error'>* Usuario ya existente * </span>";
            }
            ?>
        </p>

        <p>
            <label for="clave">Contraseña:</label>
            <input type="password" name="clave" id="clave" maxlength="20" placeholder="Nueva contraseña">
        </p>

        <p>
            <label for="email">E-mail:</label>
            <input type="text" name="email" id="email" maxlength="50" value="<?php echo $email ?>">
            <?php if (isset($_POST["email"]) && $error_email) {

                if ($_POST["email"] == "")
                    echo "<span class='error'>* Campo vacío * </span>";
                else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
                    echo "<span class='error'>* Formato de e-mail no válido * </span>";
                else
                    echo "<span class='error'>* E-mail ya existente * </span>";
            }
            ?>
        </p>

        <p>
            <button type="submit" name="boton_volver">Volver</button>
            <button type="submit" value="<?php echo $id_usuario; ?>" name="boton_confirmar_editar">Continuar</button>
        </p>
    </form>

<?php


}
