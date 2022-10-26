<?php

if (isset($_POST["boton_submit"])) {
    $error_continente = $_POST["continente"] == "";
    $error_contenido = $_POST["contenido"] == "";
    $error_longitudes = !$error_continente && !$error_contenido && strlen($_POST["continente"]) < strlen($_POST["contenido"]);
    $error_formulario = $error_continente || $error_contenido || $error_longitudes;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ejercicio 1</title>
</head>

<body>
    <h1>Texto contenido</h1>
    <form action="ejercicio1.php" method="post">
        <p>
            <label for="continente">Continente: </label>
            <input type="text" id="continente" name="continente" value="<?php if (isset($_POST["continente"])) echo $_POST["continente"] ?>">
        </p>
        <p>
            <label for="contenido">Contenido: </label>
            <input type="text" id="contenido" name="contenido" value="<?php if (isset($_POST["contenido"])) echo $_POST["contenido"] ?>">
        </p>
        <p><button type="submit" name="boton_submit">Comprobar</button></p>
    </form>

    


</body>

</html>