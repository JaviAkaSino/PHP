<?php
require "src/bd_config.php";

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practica 8</title>
    <style>
        table, th, td{
            border-collapse: collapse;
            border: 1px solid black;
        }
        img{
            width: 100px;;
        }
    </style>
</head>

<body>
    <h1>Practica 8</h1>
    <?php

/**************CONEXION*************/
    try {
        $conexion = mysqli_connect(SERVER_BD, USER_BD, PASS_BD, NAME_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die("<p>Ha sido imposible conectar con la base de datos. Error Nº " . mysqli_connect_errno() . ": " . mysqli_connect_error() . "</p>");
    }


    /************CONSULTA***********/
    

    try{
        $consulta = "SELECT * FROM usuarios";
        $resultado = mysqli_query($conexion, $consulta);
        echo " <h2>Listado de usuarios</h2>";
        echo "<table>
                <tr>
                    <th>#</th>
                    <th>Foto</th>
                    <th>Nombre</th>
                    <th>
                        <form action='index.php' method='post'>
                            <label>Usuario</label>
                            <button type='submit'>[ + ]</button>
                        </form>
                    </th>
                </tr>";

        while ($tupla = mysqli_fetch_assoc($resultado)){

            echo "<tr>
                    <th>".$tupla["id_usuario"]."</th>
                    <td><img src='Img/".$tupla["foto"]."'/></td>
                    <td>".$tupla["nombre"]."</td>
                    <td><form action='index.php' method='post'>
                    <button type='submit' name = 'boton_borrar' value='".$tupla["id_usuario"]."'>Borrar</button>
                     - 
                    <button type='submit' name = 'boton_editar' value='".$tupla["id_usuario"]."'>Editar</button>
                    </form></td>
                    </tr>";
        }

        echo "</table>";
        mysqli_free_result($resultado);
    } catch (Exception $e){
        $mensaje="No ha sido posible realizar la consulta";
        mysqli_close($conexion);
        die($mensaje);
    }

    mysqli_close($conexion);
    ?>
</body>

</html>