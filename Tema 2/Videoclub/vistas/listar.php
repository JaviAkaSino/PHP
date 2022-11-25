<?php
try {

    $consulta = "SELECT * FROM peliculas WHERE idPelicula='" . $_POST["boton_listar"] . "'";
    $resultado = mysqli_query($conexion, $consulta);

    if (mysqli_num_rows($resultado) > 0)
        $tupla = mysqli_fetch_assoc($resultado);
    echo "<div class='centrar'>";
    echo "<h3>Datos de la película con ID - " . $tupla["idPelicula"] . "</h3>";

    echo "<p><span class='negrita'>Título: </span>" . $tupla["titulo"] . "</p>";
    echo "<p><span class='negrita'>Director: </span>" . $tupla["director"] . "</p>";
    echo "<p><span class='negrita'>Temática: </span>" . $tupla["tematica"] . "</p>";
    echo "<p><span class='negrita'>Sinopsis: </span>" . $tupla["sinopsis"] . "</p>";
    echo "<p><span class='negrita'>Carátula: </span><br/><br/><img src='Img/" . $tupla["caratula"] . "'/></p>";
    echo "</div>";
} catch (Exception $e) {

    $mensaje = "No se ha podido listar los datos de la película. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
    mysqli_close($conexion);
    die($mensaje);
}
