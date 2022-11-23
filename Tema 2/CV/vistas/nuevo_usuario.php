<h2 class="centrar">Nuevo usuario</h2>
<form action="index.php" method="post" enctype="multipart/form-data" class="centrar">
    <p>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" maxlength="30" value="<?php if (isset($_POST["nombre"])) echo $_POST["nombre"] ?>" placeholder="Nombre...">
        <?php if (isset($_POST["nombre"]) && $error_nombre) echo "<span class='error'> Campo vacío </span>" ?>
    </p>
    <p>
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" id="usuario" maxlength="20" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"] ?>" placeholder="Usuario...">
        <?php if (isset($_POST["usuario"]) && $error_usuario) {
            if ($_POST["usuario"] == "")
                echo "<span class='error'> Campo vacío </span>";
            else
                echo "<span class='error'> Usuario ya existente </span>";
        }  ?>
    </p>
    <p>
        <label for="clave">Contraseña:</label>
        <input type="password" name="clave" id="clave" maxlength="20" placeholder="Contraseña...">
        <?php if (isset($_POST["clave"]) && $error_clave) echo "<span class='error'> Campo vacío </span>" ?>
    </p>

    <p>
        <label for="dni">DNI:</label>
        <input type="text" name="dni" id="dni" maxlength="10" value="<?php if (isset($_POST["dni"])) echo $_POST["dni"] ?>" placeholder="DNI: 11223344Z">
        <?php if (isset($_POST["dni"]) && $error_dni) {
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
        <label>Sexo:</label>
        <?php if (isset($_POST["boton_confirmar_nuevo"]) && $error_sexo) echo "<span class='error'> Debe seleccionar un sexo </span>" ?>
        <br />
        <input type="radio" name="sexo" id="hombre" value="hombre" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "hombre") echo "checked" ?>>
        <label for="hombre"> Hombre</label><br />
        <input type="radio" name="sexo" id="mujer" value="mujer" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "mujer") echo "checked" ?>>
        <label for="mujer"> Mujer</label>
    </p>

    <p>
        <label for="foto">Incluir mi foto (max. 500KB) </label>
        <input type="file" name="foto" id="foto" accept="image/*" />
        <?php
        if (isset($_POST["boton_confirmar_nuevo"]) && $error_foto) {

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
        <button type="submit" name="boton_confirmar_nuevo">Guardar cambios</button>
    </p>
</form>