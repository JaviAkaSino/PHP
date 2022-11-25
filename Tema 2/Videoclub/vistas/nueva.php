<div class='centrar'>
    <h3>Nueva película</h3>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="titulo" class="negrita">Título</label><br />
            <input type="text" name="titulo" id="titulo" maxlength="15" placeholder="Título de la película" 
                value="<?php if(isset($_POST["titulo"])) echo $_POST["titulo"]; ?>"/>
        </p>
        <p>
            <label for="director" class="negrita">Director</label><br />
            <input type="text" name="director" id="director" maxlength="20" placeholder="Nombre del director" 
            value="<?php if(isset($_POST["director"])) echo $_POST["director"]; ?>"/>
        </p>
        <p>
            <label for="tematica" class="negrita">Temática</label><br />
            <input type="text" name="tematica" id="tematica" maxlength="15" placeholder="Temática de la película"
            value="<?php if(isset($_POST["tematica"])) echo $_POST["tematica"]; ?>"/>
        </p>
        <p>
            <label for="sinopsis" class="negrita">Sinopsis</label><br />
            <textarea name="sinopsis" id="sinopsis" cols="30" rows="10" placeholder="Sinopsis de la película"><?php 
                if(isset($_POST["sinopsis"])) echo $_POST["sinopsis"]; 
            ?></textarea>
        </p>
        <p>
            <label for="caratula" class="negrita">Incluir carátula de la película (opcional)</label>
            <input type="file" accept="image/*" name="caratula" id="caratula" />
        </p>
        <p>
            <button type='sumbit'>Volver</button>
            <button type='submit' name='boton_confirmar_nueva'>Continuar</button>
        </p>
    </form>
</div>