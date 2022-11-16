<?php

if (isset($_POST["boton_editar"])) {

    $id_usuario = $_POST["boton_editar"];
    $consulta = "SELECT * FROM usuarios WHERE id_usuario = '" . $id_usuario . "'";

    try {

        $resultado = mysqli_query($conexion, $consulta);

        if (mysqli_num_rows($resultado) > 0) {

            $tupla = mysqli_fetch_assoc($resultado);
            $nombre = $tupla["nombre"];
            $usuario = $tupla["usuario"];
            $email = $tupla["email"];
        } else {

            $error_consistencia = "EL usuario seleccionado ya no se encuentra en la base de datos";
        }
    } catch (Exception $e) {
        $mensaje = "<p>Imposible realizar la consulta. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion) . "</p>";
        mysqli_close($conexion);
        die($mensaje);
    }
} else {

    $id_usuario = $_POST["boton_confirma_editar"];
    $nombre = $_POST["nombre"];
    $usuario = $_POST["usuario"];
    $email = $_POST["email"];
}

echo "<h2 class='centrar'>Editar Usuario " . $id_usuario . "</h2>";

if ($error_consistencia) {
} else {

?>

    <form action="index.php" method="post" class="centrar">
        <p>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" maxlength="30" value="<?php echo $nombre ?>" />
        </p>

        <p>
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" id="usuario" maxlength="20" value="<?php echo $usuario ?>" />
        </p>

        <p>
            <label for="clave">Contraseña:</label>
            <input type="password" name="clave" id="clave" maxlength="20" placeholder="Nueva contraseña">
        </p>

        <p>
            <label for="email">E-mail:</label>
            <input type="text" name="email" id="email" maxlength="50" value="<?php echo $tupla["email"] ?>">
        </p>

        <p>
            <button type="submit" name="boton_volver">Volver</button>
            <button type="submit" value="<?php echo $id_usuario; ?>" name="boton_confirma_editar">Continuar</button>
        </p>
    </form>

<?php


}
