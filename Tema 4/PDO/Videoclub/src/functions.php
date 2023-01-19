<?php


function pag_error($titulo, $encabezado, $mensaje)
{

    return '<!DOCTYPE html>
   <html lang="es">
   <head>
       <meta charset="UTF-8">
       <meta http-equiv="X-UA-Compatible" content="IE=edge">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <title>' . $titulo . '</title>
   </head>
   <body>
       <h1>' . $titulo . '</h1>
       <p>' . $mensaje . '</p>
   </body>
   </html>';
}

function repetido($conexion, $tabla, $columna, $valor, $columna_clave = null, $valor_clave = null)
{


    if (isset($columna_clave)) {

        $consulta = "SELECT * FROM " . $tabla . " WHERE " . $columna . " = ? AND " . $columna_clave . " <> ?";
        $datos_repe[] = $valor;
        $datos_repe[] = $valor_clave;
    } else {

        $consulta = "SELECT * FROM " . $tabla . " WHERE " . $columna . " = ?";
        $datos_repe[] = $valor;
    }

    try {

        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos_repe);

        $respuesta = $sentencia->rowCount() > 0;
    } catch (PDOException $e) {

        $conexion = null;
        $sentencia = null;

        $respuesta = "No se ha podido verificar que el usuario no esté repetido. Error: " . $e->getMessage();
    }

    return $respuesta;
}
