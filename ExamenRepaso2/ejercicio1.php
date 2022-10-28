<?php

if (isset($_POST["boton_submit"])) {
    $error_continente = $_POST["continente"] == "";
    $error_contenido = $_POST["contenido"] == "";
    $error_longitudes = !$error_continente && !$error_contenido && strlen($_POST["continente"]) < strlen($_POST["contenido"]);
    $error_formulario = $error_continente || $error_contenido || $error_longitudes;
}

function contiene($texto, $parte)
{
    $cont = false;
    for ($i = 0; $i < strlen($texto); $i++) {

        if ($texto[$i] == $parte[0]) { //Si la primera letra de la parte está
            $cont = true;
            for ($j = 1; $j < strlen($parte); $j++) { //Mira si estan las demas

                if ($parte[$j] != $texto[$i + $j]) //Si no coincide una
                    $cont = false;
                break;  //Pone a false y para bucle
            }
        }
    }

    return $cont;
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
            <?php if (isset($_POST["boton_submit"]) && $error_continente) echo "<span class='error'>*Campo vacío*</span>" ?>
        </p>
        <p>
            <label for="contenido">Contenido: </label>
            <input type="text" id="contenido" name="contenido" value="<?php if (isset($_POST["contenido"])) echo $_POST["contenido"] ?>">
            <?php if (isset($_POST["boton_submit"]) && $error_contenido) echo "<span class='error'>*Campo vacío*</span>" ?>
            <?php if (isset($_POST["boton_submit"]) && $error_longitudes) echo "<span class='error'>*El segundo no puede ser más largo que el primero*</span>" ?>
        </p>
        <p><button type="submit" name="boton_submit">Comprobar</button></p>
    </form>


    <?php
    if (isset($_POST["boton_submit"]) && !$error_formulario) {

        if (contiene($_POST["continente"], $_POST["contenido"]))
            echo "<h3>El texto <em>".$_POST["contenido"]."</em> está contenido en el texto <em>".$_POST["continente"]."</em></h3>";
        else
        echo "<h3>El texto <em>".$_POST["contenido"]."</em> NO está contenido en el texto <em>".$_POST["continente"]."</em></h3>";
        

    }
    ?>

</body>

</html>