<?php

if (isset($_POST["boton_submit"])) {
    $error_cadena = $_POST["cadena"] == "";
    $error_desplazamiento = $_POST["desplazamiento"] == "" || !is_numeric($_POST["desplazamiento"]);
    $error_formulario = $error_cadena || $error_desplazamiento;
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

function posicion_letra($texto, $letra)
{
    $pos = -1;
    for ($i = 0; $i < strlen($texto); $i++) {

        if ($texto[$i] == $letra) { //Si la letra está

            $pos = $i;
            break;
        }
    }

    return $pos;
}

function cifrado_cesar($texto, $desp)
{
    $abecedario = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $resultado = "";

    for ($i = 0; $i < strlen($texto); $i++) {

        if (contiene($abecedario, $texto[$i])) { //Si la letra está en el abc

            $pos = posicion_letra($abecedario, $texto[$i]);

            if ($pos + $desp < strlen($abecedario)) { //Si la nueva posicion esta dentro del abc, la pone

                $resultado .= $abecedario[$pos + $desp];
            } else { //Si se sale, da la vuelta

                $resultado .= $abecedario[$pos + $desp - strlen($abecedario)];
            }
        } else {
            $resultado .= $texto[$i];
        }
    }
    return $resultado;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ejercicio 2</title>
</head>

<body>
    <h1>Cifrado César</h1>
    <form action="ejercicio2.php" method="post">
        <p>
            <label for="cadena">Cadena: </label>
            <input type="text" id="cadena" name="cadena" value="<?php if (isset($_POST["cadena"])) echo $_POST["cadena"] ?>">
            <?php if (isset($_POST["boton_submit"]) && $error_cadena) echo "<span class='error'>*Campo vacío*</span>" ?>
        </p>
        <p>
            <label for="desplazamiento">Desplazamiento: </label>
            <input type="text" id="desplazamiento" name="desplazamiento" value="<?php if (isset($_POST["desplazamiento"])) echo $_POST["desplazamiento"] ?>">
            <?php if (isset($_POST["boton_submit"]) && $error_desplazamiento) {
                if ($_POST["desplazamiento"] == "")
                    echo "<span class='error'>*Campo vacío*</span>";
                else
                    echo "<span class='error'>*Inserte un valor numérico*</span>";
            } ?>
        </p>
        <p><button type="submit" name="boton_submit">Cifrar</button></p>
    </form>


    <?php
    if (isset($_POST["boton_submit"]) && !$error_formulario) {

        echo "<h3>Texto cifrado: </h3>";
        echo cifrado_cesar($_POST["cadena"], $_POST["desplazamiento"]);
    }
    ?>

</body>

</html>