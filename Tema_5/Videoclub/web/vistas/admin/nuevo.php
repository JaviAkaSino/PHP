<h3>Añadir cliente</h3>
<form action="index.php" method="post" enctype="multipart/form-data">
    <p>
        <label for="user">Usuario:</label>
        <input type="text" name="user" id="user" value="<?php if (isset($_POST["user"])) echo $_POST["user"] ?>">
        <?php if (isset($_POST["boton_confirmar_nuevo"]) && $error_user) {
            if ($_POST["user"] == "")
                echo "<span class='error'>* Campo vacío</span>";
            else
                echo "<span class='error'>* Usuario repetido</span>";
        }
        ?>
    </p>

    <p>
        <label for="clave">Contraseña:</label>
        <input type="password" name="clave" id="clave">
        <?php if (isset($_POST["boton_confirmar_nuevo"]) && $error_clave) {
            echo "<span class='error'>* Campo vacío</span>";
        }
        ?>

    <p>
        <label for="foto">Foto:</label>
        <input type="file" name="foto" id="foto" accept="image/*">
        <?php if (isset($_POST["boton_confirmar_nuevo"]) && $error_foto) {
            if ($_FILES["foto"]["error"])
                echo "Error en la subida";
            else if (!getimagesize($_FILES["foto"]["tmp_name"]))
                echo "Debe subir una imagen";
            else
                echo "No debe superar 500 KB";
        }
        ?>
    </p>
    </p>



    <p>
        <button>Atrás</button>
        <button type="submit" name="boton_confirmar_nuevo">Añadir</button>
    </p>
</form>