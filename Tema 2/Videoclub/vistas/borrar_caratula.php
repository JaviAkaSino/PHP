<div class='centrar'>
    <p>Se dispone usted a borrar la carátula de la película con ID = "<?php echo $_POST["idPelicula"]; ?>"</p>
    <p>
        Cambiará esta carátula:
        <img src='Img/<?php echo $_POST["caratula"]; ?>' alt='Carátula anterior' title='Carátula anterior' />
        por esta otra:
        <img src='Img/no_imagen.jpg' alt='Carátula anterior' title='Carátula anterior' />
    </p>
    <p>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <button type='submit' name='boton_volver_borrar_caratula'>Volver</button>
        <button type='submit' name='boton_confirmar_borrar_caratula' value="<?php echo $_POST["caratula"]; ?>">Borrar</button>
        <input type="hidden" name="idPelicula" value="<?php echo $_POST["idPelicula"]; ?>">
    </form>

    </p>
</div>