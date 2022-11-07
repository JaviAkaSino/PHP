<?php
/*Realizar una página php con nombre ejercicio1.php, que contenga un
formulario con un campo de texto y un botón. Este botón al pulsarse, nos
va a modificar la página respondiendo cuántos caracteres se han
introducido en el cuadro de texto.*/
function contar_letras($texto)
{
    $longitud = 0;

    while (isset($texto[$longitud])) {
        
        $longitud++;
    }

    return $longitud;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Contador de letras - Javier Parodi</title>
</head>

<body>
    <h1>Ejercicio 1</h1>
    <form action="ejercicio1.php" method="post">
        <p>
            <label for="entrada">Introduzca una frase: </label>
            <input type="text" id="entrada" name="entrada" 
                value="<?php if (isset($_POST["entrada"])) echo $_POST["entrada"]; ?>">
        </p>
        <p>
            <button type="submit" name="boton_submit">Contar</button>
        </p>

    </form>

    <?php
    if (isset($_POST["boton_submit"])) {

        echo "<h2>Respuesta: </h2>";

        $texto = "";
        $texto = $_POST["entrada"];

        $longitud = contar_letras($texto);

        echo "<p>La longitud del texto introducido es de: " . $longitud . "</p>";
    }

    ?>
</body>

</html>