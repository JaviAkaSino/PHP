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
        $_FILES["caratula"]["type"] != "image/jpeg" || $_FILES["caratula"]["size"] > 500 * 1000;
        //¿¿¿TYPE O IMAGESIZE???
    $error_form = $error_titulo || $error_actores || $error_director || $error_guion || $error_produccion ||
        $error_anio || $error_nacionalidad || $error_duracion || $error_sinopsis || $error_caratula;
}

if (!$error_form) {

    //RESPEUSTAS

} else {

    //FORMU
}

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
        <strong>Título: </strong> <?php echo $_POST["titulo"]; ?>
        <strong>Actores: </strong> <?php echo $_POST["actores"]; ?>
        <strong>Director: </strong> <?php echo $_POST["director"]; ?>
        <strong>Guión: </strong> <?php echo $_POST["guion"]; ?>
        <strong>Producción: </strong> <?php echo $_POST["produccion"]; ?>
        <strong>Año: </strong> <?php echo $_POST["anio"]; ?>
        <strong>Nacionalidad: </strong> <?php echo $_POST["nacionalidad"]; ?>
        <strong>Género: </strong> <?php echo $_POST["genero"]; ?>
        <strong>Duración: </strong> <?php echo $_POST["duracion"]; ?>
        <strong>Restricciones de edad: </strong> <?php echo $_POST["restriccion"]; ?>

        <strong>Carátula: </strong> <!--¿¿¿DEJA PASAR CON ERROR O FORM???-->
            <ul>
                <li><strong>Nombre: </strong><?php echo $_FILES["caratula"]["name"]; ?></li>
                <li><strong>Tamaño: </strong><?php echo $_FILES["caratula"]["size"]; ?> bytes</li>
                <li><strong>Fich. Temporal: </strong><?php echo $_FILES["caratula"]["tmp_name"]; ?></li>
                <li><strong>Tipo: </strong><?php echo $_FILES["caratula"]["type"]; ?></li>
                <li><strong>Error: </strong><?php echo $_FILES["caratula"]["error"]; ?></li>
            </ul>
    </p>
    <h2>El archivo se ha copiado a la carpeta de destino</h2>
    <hr/>
    <?php echo "<img height='200' width='200' src='images/".$nombre_nuevo_archivo."'/>"; ?>
    <hr/>
    <strong>Sinopsis: </strong><br/> 
    <?php echo $_POST["sinopsis"]; ?>
</body>

</html>