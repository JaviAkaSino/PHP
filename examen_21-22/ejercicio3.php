<?php
$error_form = true;
if (isset($_POST["boton_submit"])) {

    $error_form = $_POST["entrada"] == "";
}

function texto_array($separador, $texto)
{

    $lista = [];
    $i = 0;
    $palabra = "";

    while (isset($texto[$i])) {

        if ($texto[$i] != $separador) {

            $palabra .= $texto[$i];
        } else {
            if ($palabra != "") {

                $lista[] = $palabra;
                $palabra = "";
            }
        }

        $i++;
    }
    
    if ($palabra != "")
        $lista[] = $palabra; //Ultima palabra

    return $lista;
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Contador de palabras - Javier Parodi</title>
</head>

<body>
    <h1>Número de palabras según separador</h1>
    <form action="ejercicio3.php" method="post">
        <p>
            <label for="entrada">Introduce un texto: </label>
            <input type="text" id="entrada" name="entrada" value="<?php if (isset($_POST["entrada"])) echo $_POST["entrada"]; ?>">
            <?php if (isset($_POST["boton_submit"]) && $error_form) echo " <span class='error'>*Campo vacío*</span>" ?>
        </p>
        <p>
            <label for="separador">Elige un separador</label>
            <select name="separador" id="separador">
                <option value="," <?php if (isset($_POST["separador"]) && $_POST["separador"] == ",") echo "selected";; ?>>"," (coma)</option>
                <option value=";" <?php if (isset($_POST["separador"]) && $_POST["separador"] == ";") echo "selected";; ?>>";" (punto y coma)</option>
                <option value=" " <?php if (isset($_POST["separador"]) && $_POST["separador"] == " ") echo "selected";; ?>>" " (espacio)</option>
                <option value=":" <?php if (isset($_POST["separador"]) && $_POST["separador"] == ":") echo "selected";; ?>>":" (dos puntos)</option>
            </select>
        </p>
        <p>
            <button type="submit" name="boton_submit">Contar</button>
        </p>
    </form>

    <?php

    if (isset($_POST["boton_submit"]) && !$error_form) {

        $numero = count(texto_array($_POST["separador"], $_POST["entrada"]));

        echo "El número de palabras es: " . $numero;
    }
    ?>


</body>

</html>