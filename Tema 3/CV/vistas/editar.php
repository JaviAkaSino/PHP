<?php

if (
    isset($_POST["boton_editar"]) || isset($_POST["boton_borrar_foto"]) ||
    isset($_POST["boton_confirmar_borrar_foto"]) || isset($_POST["boton_volver_borrar_foto"])
) {


    if (isset($_POST["boton_editar"]))
        $id_usuario = $_POST["boton_editar"];
    else
        $id_usuario = $_POST["id_usuario"];

    $consulta = "SELECT * FROM usuarios WHERE id_usuario = '" . $id_usuario . "'";

    try {

        $resultado = mysqli_query($conexion, $consulta);
        if (mysqli_num_rows($resultado) > 0) {

            $tupla = mysqli_fetch_assoc($resultado);
            $nombre = $tupla["nombre"];
            $usuario = $tupla["usuario"];
            $dni = $tupla["dni"];
            $sexo = $tupla["sexo"];
            $foto = $tupla["foto"];
        } else {
            $error_consistencia = "El usuario seleccionado ya no se encuentra en la base de datos";
        }

        mysqli_free_result($resultado);
    } catch (Exception $e) {
        $mensaje = "<p class='centrar'>Imposible realizar consulta. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion) . "</p>";
        mysqli_close($conexion);
        die($mensaje);
    }
} else {

    $id_usuario = $_POST["boton_confirmar_editar"];
    $nombre = $_POST["nombre"];
    $usuario = $_POST["usuario"];
    $dni = $_POST["dni"];
    $sexo = $_POST["sexo"];
    $foto = $_POST["foto"];
}

echo "<h2 class='centrar'>Editando al usuario con ID: " . $id_usuario . "</h2>";
if (isset($error_consistencia)) {
    echo "<div class='centrar'>";
    echo "<p>" . $error_consistencia . "</p>";
    echo "<form method='post' action='index.php'>";
    echo "<p><button type='submit'>Volver</button></p>";
    echo "</form>";
    echo "</div>";
} else {


?>
    <div id="edicion" class="flexible fila">


        <div>
            <form action="index.php" method="post" enctype="multipart/form-data" class="centrar">
                <p>
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" maxlength="30" value="<?php echo $nombre; ?>">
                    <?php if (isset($_POST["boton_confirmar_editar"]) && $error_nombre) echo "<span class='error'> Campo vacío </span>" ?>
                </p>
                <p>
                    <label for="usuario">Usuario:</label>
                    <input type="text" name="usuario" id="usuario" maxlength="20" value="<?php echo $usuario; ?>">
                    <?php if (isset($_POST["boton_confirmar_editar"]) && $error_usuario) {
                        if ($_POST["usuario"] == "")
                            echo "<span class='error'> Campo vacío </span>";
                        else
                            echo "<span class='error'> Usuario ya existente </span>";
                    }  ?>
                </p>
                <p>
                    <label for="clave">Contraseña:</label>
                    <input type="password" name="clave" id="clave" maxlength="20" placeholder="Editar contraseña">
                </p>

                <p>
                    <label for="dni">DNI:</label>
                    <input type="text" name="dni" id="dni" maxlength="10" value="<?php echo $dni; ?>" placeholder="DNI: 11223344Z">
                    <?php if (isset($_POST["boton_confirmar_editar"]) && $error_dni) {

                        if ($_POST["dni"] == "")
                            echo "<span class='error'> Campo vacío </span>";
                        elseif (!dni_formato($_POST["dni"])) {
                            echo "<span class='error'> Escriba un DNI con formato válido</span>";
                        } elseif (!dni_valido($_POST["dni"]))
                            echo "<span class='error'> DNI no válido</span>";
                        else
                            echo "<span class='error'>DNI ya en uso</span>";
                    } ?>
                <p>
                    <label>Sexo:</label><br />
                    <input type="radio" name="sexo" id="hombre" value="hombre" <?php if ($sexo == "hombre") echo "checked" ?>>
                    <label for="hombre"> Hombre</label><br />
                    <input type="radio" name="sexo" id="mujer" value="mujer" <?php if ($sexo == "mujer") echo "checked" ?>>
                    <label for="mujer"> Mujer</label>
                </p>

                <p>
                    <label for="foto">Incluir mi foto (max. 500KB) </label>
                    <input type="file" name="foto" id="foto" accept="image/*" />
                    <?php
                    if (isset($_POST["boton_confirmar_editar"]) && $error_foto) {

                        if ($_FILES["foto"]["error"]) {
                            echo "<span class='error'>Error en la subida del fichero</span>";
                        } elseif (!getimagesize($_FILES["foto"]["tmp_name"])) {
                            echo "<span class='error'>El archivo debe ser una imagen</span>";
                        } else {
                            echo "<span class='error'>La imagen no debe exceder los 500KB</span>";
                        }
                    }
                    ?>
                </p>

                <p>
                    <button type="submit" name="boton_volver">Volver</button>
                    <input type="hidden" name="nombre_foto" value="<?php echo $foto; ?>">
                    <input type="hidden" name="id_usuario" value="<?php echo $id_usuario; ?>">
                    <button type="submit" name="boton_confirmar_editar" value="<?php echo $id_usuario; ?>">Guardar cambios</button>
                </p>
        </div>
        <div class="flexible columna" id="editar_foto">
            <img src="Img/<?php echo $foto; ?>" alt="Foto de perfil" title="Foto de perfil" />
            <?php
            if (isset($_POST["boton_borrar_foto"])) {
                echo "<p class='texto-centrado'>¿Seguro que desea borrar la imagen?</p>";
                echo "<p class='texto-centrado'><button type='submit' name='boton_volver_borrar_foto'>Cancelar</button>";
                echo "<button type='submit' name='boton_confirmar_borrar_foto'>Borrar</button></p>";
            } elseif ($foto != "no_imagen.jpg")
                echo "<p class='texto-centrado'><button type='submit' name='boton_borrar_foto' >Borrar</button></p>";
            ?>
        </div>
        </form>
    </div>
<?php
}
