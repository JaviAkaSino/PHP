<div class='centrar'>
    <h3>Nueva película</h3>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="titulo" class="negrita">Título</label><br />
            <input type="text" name="titulo" id="titulo" maxlength="15" placeholder="Título de la película" value="<?php if (isset($_POST["titulo"])) echo $_POST["titulo"]; ?>" />
            <?php if (isset($_POST["titulo"]) && $error_titulo)
                if ($_POST["titulo"] == "")
                    echo "<span class='error'>* Campo vacío</span>";
                else
                    echo "<span class='error'>* Película repetida, seleccione otro título o director</span>"; ?>

        </p>
        <p>
            <label for="director" class="negrita">Director</label><br />
            <input type="text" name="director" id="director" maxlength="20" placeholder="Nombre del director" value="<?php if (isset($_POST["director"])) echo $_POST["director"]; ?>" />
            <?php if (isset($_POST["director"]) && $error_director)
                if ($_POST["director"] == "")
                    echo "<span class='error'>* Campo vacío</span>";
                else
                    echo "<span class='error'>* Película repetida, seleccione otro título o director</span>"; ?>
        </p>
        <p>
            <label for="tematica" class="negrita">Temática</label><br />
            <input type="text" name="tematica" id="tematica" maxlength="15" placeholder="Temática de la película" value="<?php if (isset($_POST["tematica"])) echo $_POST["tematica"]; ?>" />
            <?php if (isset($_POST["tematica"]) && $error_tematica)
                echo "<span class='error'>* Campo vacío</span>"; ?>
        </p>
        <p>
            <label for="sinopsis" class="negrita">Sinopsis</label><br />
            <textarea name="sinopsis" id="sinopsis" cols="30" rows="10" placeholder="Sinopsis de la película"><?php
                                                                                                                if (isset($_POST["sinopsis"])) echo $_POST["sinopsis"];
                                                                                                                ?></textarea>
            <?php if (isset($_POST["sinopsis"]) && $error_sinopsis)
                echo "<span class='error'>* Campo vacío</span>"; ?>
        </p>
        <p>
            <label for="caratula" class="negrita">Incluir carátula de la película (opcional)</label>
            <input type="file" accept="image/*" name="caratula" id="caratula" />
            <?php if (isset($_POST["boton_confirmar_nueva"]) && $error_caratula) {

                if ($_FILES["caratula"]["error"])
                    echo "<span class='error'>* Error en la subida del archivo</span>";
                elseif (!getimagesize($_FILES["caratula"]["tmp_name"]))
                    echo "<span class='error'>* El archivo seleccionado no es una imagen</span>";
                else
                    echo "<span class='error'>* El tamaño no puede superar 1 MB</span>";
            }

            ?>
        </p>
        <p>
            <button type='sumbit'>Volver</button>
            <button type='submit' name='boton_confirmar_nueva'>Continuar</button>
        </p>
    </form>
</div>