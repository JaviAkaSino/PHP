<?php

$abecedario = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

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

function descifrado_cesar($texto, $desp)
{
    $abecedario = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $resultado = "";

    for ($i = 0; $i < strlen($texto); $i++) {

        if (contiene($abecedario, $texto[$i])) { //Si la letra está en el abc

            $pos = posicion_letra($abecedario, $texto[$i]);

            if ($pos - $desp >= 0) { //Si la nueva posicion esta dentro del abc, la pone

                $resultado .= $abecedario[$pos - $desp];
            } else { //Si se sale, da la vuelta
                $resultado .= $abecedario[strlen($abecedario) + ($pos - $desp)];
            }
        } else {

            $resultado .= $texto[$i];
        }
    }

    return $resultado;
}

if (isset($_POST["boton_submit"])) {
    $error_form = $_FILES["codificado"]["name"] == "" || $_FILES["codificado"]["error"] || $_FILES["codificado"]["type"] != "text/plain" || $_FILES["codificado"]["size"] > 500;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ejercicio 4</title>
</head>

<body>
    <h1>Decodificador</h1>
    <form action="ejercicio4.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="codificado">Archivo de texto codificado inferior a 500 kB: </label>
            <input type="file" id="codificado" name="codificado" accept=".txt">

            <?php
            if (isset($_POST["boton_submit"]) && $error_form) {

                if ($_FILES["codificado"]["name"] != "") {

                    if ($_FILES["codificado"]["error"])
                        echo "<span class = 'error'>Error al subir el archivo al servidor</span>";
                    elseif ($_FILES["codificado"]["type"] != "text/plain")
                        echo "<span class = 'error'>Seleccione un archivo .txt</span>";
                    else
                        echo "<span class = 'error'>Tamaño de archivo excedido</span>";
                }
            }
            ?>

        </p>

        <p><button type="submit" name="boton_submit">Decodificar</button></p>
    </form>


    <?php

    if (isset($_POST["boton_submit"]) && !$error_form) {

        @$deco = fopen("deco.txt", "w");
        if (!$deco)
            die("<p>No se ha podido abrir el fichero <em>decodificado.txt</em></p>");

        @$codi = fopen($_FILES["codificado"]["tmp_name"], "r");
        if (!$codi)
            die("<p>No se ha podido abrir el fichero <em>codificado.txt</em></p>");


        $is_felix = false;
        $intentos = strlen($abecedario);
        $desplazamiento = 0;

        while (!$is_felix && $intentos >= 0) { //Hasta que salga FELIX

            while ($linea = fgets($codi)) { //Recorremos las tres lineas

                if (contiene(descifrado_cesar($linea, $desplazamiento), "FELIX")) { //Si el deco contiene FELIX

                    $is_felix = true;

                    fseek($codi, 0); //Empezar de 0

                    while ($linea = fgets($codi)) { //Las escribe decodificadas

                        fputs($deco, descifrado_cesar($linea, $desplazamiento));
                    }

                    break;
                }
            }

            fseek($codi, 0);
            $desplazamiento++;
            $intentos--;
        }


        fwrite($deco, "\nEste fichero fue decodificado el " . date("l") . " dia " . date("d") . " de " . date("M") . " de " . date("Y") . " a las " . date("h:m") . " horas.");
        //fwrite($deco,  "\n".strftime("Este fichero fue decodificado el %A, día %d de %B de %Y a las %H:%M horas."));

        fclose($deco);
        fclose($codi);
        if ($intentos < 0)
            echo "<p>No se ha podido decodificar el archivo</p>";
        else
            echo "<p>Archivo decodificado: <a href='deco.txt'>deco.txt</a></p>";
    }

    ?>

</body>

</html>