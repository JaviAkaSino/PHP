<?php

function pag_error($titulo, $cabecera, $mensaje)
{
    return "<!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <title>" . $titulo . "</title>
        </head>
        <body>
            <h1>" . $cabecera . "</h1>
            <p>" . $mensaje . "</p>
        </body>
        </html>";
}

function repetido($conexion, $tabla, $columna, $valor, $columna_clave = null, $valor_clave = null)
{
    if (isset($columna_clave))
        $consulta = "SELECT " . $columna . " FROM " . $tabla . " WHERE " . $columna . " = " . $valor . "' AND " . $columna_clave . " <> '" . $valor_clave . "'";
    else
        $consulta = "SELECT " . $columna . " FROM " . $tabla . " WHERE " . $columna . " = '" . $valor . "'";


    try {
        $resultado = mysqli_query($conexion, $columna);

        $respuesta = mysqli_num_rows($resultado) > 0;

        mysqli_free_result($resultado);
    } catch (Exception $e) {

        $respuesta = "No se ha podido verificar que los valores nos ean repetidos. Error Nº" . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
    }
}
