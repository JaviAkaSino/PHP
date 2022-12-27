<?php
function pag_error($title, $encabezado, $mensaje)
{

    return "<!DOCTYPE html>
    <html lang='es''>
    <head>
        <meta charset='UTF-8'>
        <title>" . $title . "</title>
    </head>
    <body>
        <h1>" . $encabezado . "</h1><p>" . $mensaje . "</p>
    </body>
    </html>";
}

function repetido($conexion, $tabla, $columna, $valor, $columna_clave = null, $valor_clave = null)
{

    if (isset($columna_clave))
        $consulta = "select " . $columna . " from " . $tabla . " where " . $columna . " = '" . $valor . "' AND " . $columna_clave . " <> '" . $valor_clave . "'";
    else
        $consulta = "select " . $columna . " from " . $tabla . " where " . $columna . " = '" . $valor . "'";
    try {

        $resultado = mysqli_query($conexion, $consulta);

        $respuesta = mysqli_num_rows($resultado) > 0;

        mysqli_free_result($resultado);
    } catch (Exception $e) {
        $respuesta = "Imposible realizar la consulta. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
    }

    return $respuesta;
}

function letra_dni($dni)
{

    return substr("TRWAGMYFPDXBNJZSQVHLCKEO", $dni % 23, 1);
}

function dni_formato($dni)
{
    // Longitud de 9, primero 8 son números, y el 9º es letra
    return strlen($dni) == 9 && is_numeric(substr($dni, 0, 8)) && strtoupper(substr($dni, 8, 1)) >= 'A' && strtoupper(substr($dni, 8, 1)) <= 'Z';
}

function dni_valido($dni)
{
    return dni_formato($dni) && letra_dni(substr($dni, 0, 8)) == strtoupper(substr($dni, 8, 1));
}
