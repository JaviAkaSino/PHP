<?php

//Salvo que entremos por confirmar, cogemos los datos existentes
if (isset($_POST["boton_editar"]) || isset($_POST["boton_confirmar_borrar_caratula"]) || isset($_POST["boton_volver_borrar_caratula"])) {

    if (isset($_POST["boton_editar"]))
        $idPelicula = $_POST["boton_editar"]; //Cuando se entra por editar se le da el valor
    else
        $idPelicula = $_POST["idPelicula"]; //El resto de veces ya irá por el hidden

    $consulta = "SELECT * FROM peliculas WHERE idPelicula = '" . $idPelicula . "'";

    try { //Guardamos los datos de la pelicula
        $resultado = mysqli_query($conexion, $consulta);
        if (mysqli_num_rows($resultado) > 0) { //Si la encuentra
            $tupla = mysqli_fetch_assoc($resultado);
            $titulo = $tupla["titulo"];
            $director = $tupla["director"];
            $tematica = $tupla["tematica"];
            $sinopsis = $tupla["sinopsis"];
            $caratula = $tupla["caratula"];
        } else { //Si no, erro de consistencia
            $error_consistencia = "La película con id: " . $idPelicula . " ya no se encuentra en la base de datos";
        }
    } catch (Exception $e) {
        $mensaje = "Imposible realizar la consulta. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
        mysqli_close($conexion);
        die($mensaje);
    }
} else { //Si viene de confirmar editar, cogemos los datos nuevos
    $idPelicula = $_POST["idPelicula"];
    $titulo = $_POST["titulo"];
    $director = $_POST["director"];
    $tematica = $_POST["tematica"];
    $sinopsis = $_POST["sinopsis"];
    $caratula = $_POST["caratula"];
}

if (isset($error_consistencia)) { //Si hay error de consistencia, lo muestra
    echo "<div class='centrar'>";
    echo "<p>" . $error_consistencia . "</p>";
    echo "<form method='post' action='index.php'>";
    echo "<p><button type='submit'>Volver</button></p>";
    echo "</form>";
    echo "</div>";
} else { //Si no, formulario de edición

?>
    <div class='centrar'>
        <h3>Editar película</h3>
        <form action="index.php" method="post" enctype="multipart/form-data">


            <table>
                <tr>
                    <td>
                        <p>
                            <label for="titulo" class="negrita">Título</label><br />
                            <input type="text" name="titulo" id="titulo" maxlength="15" placeholder="Título de la película" value="<?php echo $titulo; ?>" />
                            <?php
                            if (isset($_POST["boton_confirmar_editar"]) && $error_titulo)
                                if ($_POST["titulo"] == "")
                                    echo "<span class='error'>* Campo vacío</span>";
                                else
                                    echo "<span class='error'>* Película repetida, seleccione otro título o director</span>"; ?>
                        </p>
                    </td>
                    <td rowspan="3" class="texto-centrado">
                        <p id="borrar-foto">
                            <img src="Img/<?php echo $caratula; ?>" alt="Carátula" title="Carátula"><br /><br />
                            <?php if ($caratula != "no_imagen.jpg") echo "<button type='submit' name='boton_borrar_caratula'>Borrar carátula</button>" ?>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>
                            <label for="director" class="negrita">Director</label><br />
                            <input type="text" name="director" id="director" maxlength="20" placeholder="Nombre del director" value="<?php echo $director; ?>" />
                            <?php if (isset($_POST["boton_confirmar_editar"]) && $error_director)
                                if ($_POST["director"] == "")
                                    echo "<span class='error'>* Campo vacío</span>";
                                else
                                    echo "<span class='error'>* Película repetida, seleccione otro título o director</span>"; ?>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>
                            <label for="tematica" class="negrita">Temática</label><br />
                            <input type="text" name="tematica" id="tematica" maxlength="15" placeholder="Temática de la película" value="<?php echo $tematica; ?>" />
                            <?php if (isset($_POST["boton_confirmar_editar"]) && $error_tematica)
                                echo "<span class='error'>* Campo vacío</span>"; ?>
                        </p>
                    </td>
                </tr>
            </table>











            <p>
                <label for="sinopsis" class="negrita">Sinopsis</label><br />
                <textarea name="sinopsis" id="sinopsis" cols="30" rows="10" placeholder="Sinopsis de la película"><?php echo $sinopsis; ?></textarea>
                <?php if (isset($_POST["boton_confirmar_editar"]) && $error_sinopsis)
                    echo "<span class='error'>* Campo vacío</span>"; ?>
            </p>
            <p>
                <label for="caratula" class="negrita">Incluir carátula de la película (opcional)</label>
                <input type="file" accept="image/*" name="caratula" id="caratula" />
                <?php if (isset($_POST["boton_confirmar_editar"]) && $error_caratula) {

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
                <button type='submit' name='boton_confirmar_editar'>Continuar</button>
                <input type="hidden" name="idPelicula" value="<?php echo $idPelicula; ?>">
                <input type="hidden" name="caratula" value="<?php echo $caratula; ?>">
            </p>


        </form>
    </div>
<?php


}
