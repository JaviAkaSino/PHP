<?php

if (isset($_POST["boton_submit"])) {
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

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ejercicio 3</title>
</head>

<body>
    <h1>Decodificador</h1>
    <!--<form action="ejercicio3.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="codificado">Archivo codificado: </label>
            <input type="file" id="codificado" name="codificado">
        </p>
        
        <p><button type="submit" name="boton_submit">Decodificar</button></p>
    </form>-->


    <?php
    $linea_deco;




    @$deco = fopen("decodificado.txt", "w");

    if ($deco) {

        $is_felix = false;
        $desplazamiento = 0;

        while (!$is_felix) { //Hasta que salga FELIX
            @$codi = fopen("codificado.txt", "r");
            while ($linea = fgets($codi)) { //Recorremos las tres lineas

                if (contiene(descifrado_cesar($linea, $desplazamiento), "FELIX")) { //Si el deco contiene FELIX

                    $is_felix = true;
                    echo "<p>" . $desplazamiento . "</p>";
                    echo "<p>" . descifrado_cesar($linea, $desplazamiento) . "</p>";
                }
            }
            fclose($codi);
            $desplazamiento++;
        }

        fclose($deco);
    } else {
        echo "<h2>No se encuentra el archivo <em>decodificado.txt</em></h2>";
    }

    



    ?>

</body>

</html>