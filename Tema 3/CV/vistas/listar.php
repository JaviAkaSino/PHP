<?php



echo "<h2 class='centrar'>Listado del usuario " . $_POST["boton_listar"] . "</h2>";
$consulta = "SELECT * FROM usuarios WHERE id_usuario = '" . $_POST["boton_listar"] . "'";

try {

    $resultado = mysqli_query($conexion, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        $tupla = mysqli_fetch_assoc($resultado);

        echo "<div id='datos_listados' class='centrar'>";
        echo "<p><img src='Img/" . $tupla["foto"] . "' alt='Foto de perfil' title='Foto de perfil'/></p>";
        echo "<p><strong>Nombre: </strong>" . $tupla["nombre"] . "</p>";
        echo "<p><strong>Usuario: </strong>" . $tupla["usuario"] . "</p>";
        echo "<p><strong>DNI: </strong>" . $tupla["dni"] . "</p>";
        echo "<p><strong>Sexo: </strong>" . $tupla["sexo"] . "</p>";

        echo "<form><button type='submit'>Cerrar</button></form>";
    }
} catch (Exception $e) {

    die("<p class='centrar'>Imposible realizar consulta. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion) . "</p>");
}
