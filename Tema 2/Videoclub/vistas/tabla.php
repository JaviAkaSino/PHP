<?php
try {

$consulta = "SELECT * FROM peliculas";
$resultado = mysqli_query($conexion, $consulta);


echo "<h3 class='centrar'>Listado de películas</h3>";
echo "<table class='centrar'>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Carátula</th>
            <th><form action='index.php' method='post'><label>Películas </label><button name='boton_nueva'>[+]</button></form></th>
        </tr>";


while ($tupla = mysqli_fetch_assoc($resultado)) {

    echo "<tr>
            <td>" . $tupla["idPelicula"] . "</td>
            <td><form method='post' action='index.php'><button name='boton_listar' value='" . $tupla["idPelicula"] . "'>" . $tupla["titulo"] . "</button></form></td>
            <td><form method='post' action='index.php'><button name='boton_listar' value='" . $tupla["idPelicula"] . "'><img src='Img/" . $tupla["caratula"] . "'/></button></form></td>
            <td>
                <form action='index.php' method='post'>
                    <button type='submit' name'boton_borrar' value'" . $tupla["idPelicula"] . "'>Borrar</button>
                     - 
                    <button type='submit' name'boton_editar' value'" . $tupla["idPelicula"] . "'>Editar</button>
            </td>
        </tr>";
}

echo "</table>";

mysqli_free_result($resultado);
} catch (Exception $e) {

$mensaje = "No ha sido posible realizar la consulta. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
mysqli_close($conexion);
die($mensaje);
}