<?php

function pag_error($title, $encabezado, $mensaje)
{

    return
        '<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . $title . '</title>
    </head>
    <body>
        <h1>' . $encabezado . '</h1>
        <p>' . $mensaje . '</p>
    </body>
    </html>';
}


function repetido($conexion, $tabla, $columna, $valor, $columna_clave = null, $valor_clave = null)
{


    if (isset($columna_clave)) {

        $consulta = "SELECT * FROM " . $tabla . " WHERE " . $columna . " = ? AND " . $columna_clave . "<> ?";
        $datos[] = $valor;
        $datos[] = $valor_clave;
    } else {

        $consulta = "SELECT * FROM " . $tabla . " WHERE " . $columna . " = ?";
        $datos[] = $valor;
    }

    try{
$sentencia = $conexion->prepare($consulta); //Prepara la consulta
    $sentencia->execute($datos); //La ejecuta


    $repetido = $sentencia->rowCount() > 0; //Si existe, está repetido
    $sentencia = null;

    } catch (PDOException $e){

        $repetido = "No se ha podido comprobar la BD. Error: ".$e->getMessage();
    }

    return $repetido;
}
