<?php

$error_form = true;

if (isset($_POST["boton_submit"])) {

    $error_titulo = $_POST["titulo"] == "";
    $error_actores = $_POST["actores"] == "";
    $error_director = $_POST["director"] == "";
    $error_guion = $_POST["guion"] == "";
    $error_produccion = $_POST["produccion"] == "";
    $error_anio = $_POST["anio"] == "" || strlen($_POST["anio"]) > 4 || !is_numeric($_POST["anio"]);
    $error_nacionalidad = $_POST["nacionalidad"] == "";
    $error_duracion = $_POST["duracion"] == "" || strlen($_POST["duracion"]) > 3 || !is_numeric($_POST["duracion"]);
    $error_sinopsis = $_POST["sinopsis"] == "";

    $error_caratula = $_FILES["caratula"]["name"] == "" || $_FILES["caratula"]["error"] ||
        $_FILES["caratula"]["type"] != "image/jpeg" || $_FILES["caratula"]["size"] > 1920 * 1200;

    $error_form = $error_titulo || $error_actores || $error_director || $error_guion || $error_produccion ||
        $error_anio || $error_nacionalidad || $error_duracion || $error_sinopsis || $error_caratula;
}

if (isset($_POST["boton_reset"]))
    $_POST = array();

if (isset($_POST["boton_submit"]) && !$error_form) {

    //RESPUESTAS

?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 9 Formularios - Javier Parodi Piñero</title>
    </head>

    <body>
        <h1>Formulario - Ejercicio 9</h1>
        <h2>La película introducida es:</h2>
        <p>
            <strong>Título: </strong> <?php echo $_POST["titulo"]; ?><br />
            <strong>Actores: </strong> <?php echo $_POST["actores"]; ?><br />
            <strong>Director: </strong> <?php echo $_POST["director"]; ?><br />
            <strong>Guión: </strong> <?php echo $_POST["guion"]; ?><br />
            <strong>Producción: </strong> <?php echo $_POST["produccion"]; ?><br />
            <strong>Año: </strong> <?php echo $_POST["anio"]; ?><br />
            <strong>Nacionalidad: </strong> <?php echo $_POST["nacionalidad"]; ?><br />
            <strong>Género: </strong> <?php echo $_POST["genero"]; ?><br />
            <strong>Duración: </strong> <?php echo $_POST["duracion"]; ?><br />
            <strong>Restricciones de edad: </strong> <?php echo $_POST["edad"]; ?><br />

            <strong>Carátula: </strong><br />
        <ul>
            <li><strong>Nombre: </strong><?php echo $_FILES["caratula"]["name"]; ?></li>
            <li><strong>Tamaño: </strong><?php echo $_FILES["caratula"]["size"]; ?> bytes</li>
            <li><strong>Fich. Temporal: </strong><?php echo $_FILES["caratula"]["tmp_name"]; ?></li>
            <li><strong>Tipo: </strong><?php echo $_FILES["caratula"]["type"]; ?></li>
            <li><strong>Error: </strong><?php echo $_FILES["caratula"]["error"]; ?></li>
        </ul>
        </p>

        <?php
        $array_nombre = explode(".", $_FILES["caratula"]["name"]);
        $extension = "";
        if (count($array_nombre) > 1)
            $extension = "." . strtolower(end($array_nombre));

        $nombre_unico = "img_" . md5(uniqid(uniqid(), true));

        $nombre_nuevo_archivo = $nombre_unico . $extension;

        //Poniendo un arroba avisas que quieres controlar un warning
        @$var = move_uploaded_file($_FILES["caratula"]["tmp_name"], "images/" . $nombre_nuevo_archivo);

        if (!$var) {

            echo "<p>La imagen no ha podido ser movida por falta de permisos</p>";
        } else {

            echo "<h2>El archivo se ha copiado a la carpeta de destino</h2>";
            echo "<hr/>";
            echo "<img height='200' src='images/" . $nombre_nuevo_archivo . "'/>";
        }
        ?>

        <hr />
        <strong>Sinopsis: </strong><br />
        <?php echo $_POST["sinopsis"]; ?>
    </body>

    </html>

<?php

} else {

?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 9 Formularios - Javier Parodi Piñero</title>
        <style>
            table {
                text-align: left
            }

            #botones {
                text-align: center
            }

            .error {
                font-weight: 100;
                font-size: smaller;
                color: red
            }
        </style>
    </head>

    <body>
        <h1>Formulario - Ejercicio 9</h1>
        <h2>Cinem@s</h2>

        <form action="formulario9.php" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <th>
                        <label for="titulo">Título </label>
                        <?php if (isset($_POST["boton_submit"]) && $error_titulo) echo "<span class='error'>*Campo vacío*</span>"; ?>

                    </th>
                    <th>
                        <label for="actores">Actores </label>
                        <?php if (isset($_POST["boton_submit"]) && $error_actores) echo "<span class='error'>*Campo vacío*</span>"; ?>
                    </th>
                </tr>
                <tr>
                    <td>
                        <input type="text" id="titulo" name="titulo" value="<?php if (isset($_POST["titulo"])) echo $_POST["titulo"]; ?>">
                    </td>
                    <td>
                        <input type="text" id="actores" name="actores" value="<?php if (isset($_POST["actores"])) echo $_POST["actores"]; ?>">
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="director">Director</label>
                        <?php if (isset($_POST["boton_submit"]) && $error_director) echo "<span class='error'>*Campo vacío*</span>"; ?>
                    </th>
                    <th>
                        <label for="guion">Guión</label>
                        <?php if (isset($_POST["boton_submit"]) && $error_guion) echo "<span class='error'>*Campo vacío*</span>"; ?>
                    </th>
                </tr>
                <tr>
                    <td>
                        <input type="text" id="director" name="director" value="<?php if (isset($_POST["director"])) echo $_POST["director"]; ?>">
                    </td>
                    <td>
                        <input type="text" id="guion" name="guion" value="<?php if (isset($_POST["guion"])) echo $_POST["guion"]; ?>">
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="produccion">Producción</label>
                        <?php if (isset($_POST["boton_submit"]) && $error_produccion) echo "<span class='error'>*Campo vacío*</span>"; ?>
                    </th>
                    <th>
                        <label for="anio">Año </label>
                        <?php if (isset($_POST["boton_submit"]) && $error_anio) echo "<span class='error'>*Valor no numérico*</span>"; ?>
                    </th>
                </tr>
                <tr>
                    <td>
                        <input type="text" id="produccion" name="produccion" value="<?php if (isset($_POST["produccion"])) echo $_POST["produccion"]; ?>">
                    </td>
                    <td>
                        <input type="text" id="anio" name="anio" size="4" maxlength="4" value="<?php if (isset($_POST["anio"])) echo $_POST["anio"]; ?>">
                    </td>
                </tr>

                <tr>
                    <th>
                        <label for="nacionalidad">Nacionalidad</label>
                        <?php if (isset($_POST["boton_submit"]) && $error_nacionalidad) echo "<span class='error'>*Campo vacío*</span>"; ?>
                    </th>
                    <th>
                        <label for="genero">Género</label>
                    </th>
                </tr>
                <tr>
                    <td>
                        <input type="text" id="nacionalidad" name="nacionalidad" value="<?php if (isset($_POST["nacionalidad"])) echo $_POST["nacionalidad"]; ?>">
                    </td>
                    <td>
                        <select name="genero" id="genero">
                            <option value="Comedia">Comedia</option>
                            <option value="Drama">Drama</option>
                            <option value="Acción">Acción</option>
                            <option value="Terror">Terror</option>
                            <option value="Otras">Otras</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th>
                        <label for="duracion">Duración</label>
                        <?php if (isset($_POST["boton_submit"]) && $error_duracion) echo "<span class='error'>*Valor no numérico*</span>"; ?>
                    </th>
                    <th>
                        <label>Restricciones de edad</label>
                    </th>
                </tr>
                <tr>
                    <td>
                        <input type="text" id="duracion" name="duracion" size="3" maxlength="3" value="<?php if (isset($_POST["duracion"])) echo $_POST["duracion"]; ?>">
                        (minutos)
                    </td>
                    <td>
                        <input type="radio" id="todos" value="todos" name="edad">
                        <label for="todos"> Todos los públicos</label>
                        <input type="radio" id="mayor7" value="mayor7" name="edad">
                        <label for="mayor7"> Mayores de 7 años</label>
                        <input type="radio" id="mayor18" value="mayor18" name="edad" checked>
                        <label for="mayor18"> Mayores de 18 años</label>
                    </td>
                </tr>

                <tr>
                    <th colspan="2">
                        <label for="sinopsis">Sinopsis</label>
                        <?php if (isset($_POST["boton_submit"]) && $error_sinopsis) echo "<span class='error'>*Campo vacío*</span>"; ?>
                    </th>
                </tr>
                <tr>
                    <td colspan="2">
                        <textarea id="sinopsis" name="sinopsis" rows="10" cols="60"><?php
                                                                                    if (isset($_POST["sinopsis"])) echo $_POST["sinopsis"]; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="caratula">Carátula</label>
                        <?php
                        if (isset($_POST["boton_submit"]) && $error_caratula) {

                            if ($_FILES["caratula"]["name"] == "")
                                echo "<span class='error'>*Archivo no seleccionado*</span>";
                            elseif ($_FILES["caratula"]["error"])
                                echo "<span class='error'>*Error subiendo el archivo al servidor*</span>";
                            elseif ($_FILES["caratula"]["type"] != "text/plain")
                                echo "<span class='error'>*No ha seleccionado un archivo .jpeg*</span>";
                            else
                                echo "<span class='error'>*El archivo es demasiado grande*</span>";
                        }

                        ?>
                    </th>
                    <td>
                        <input type="file" id="caratula" name="caratula" accept="image/jpeg">
                    </td>
                </tr>

                <tr id="botones">
                    <td>
                        <button type="submit" name="boton_submit">Enviar</button>
                    </td>
                    <td>
                        <button type="submit" name="boton_reset">Borrar</button>
                    </td>
                </tr>
            </table>
        </form>
    </body>

    </html>

<?php

}

?>