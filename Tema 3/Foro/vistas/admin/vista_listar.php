<?php

try {

    $consulta = "SELECT * FROM usuarios WHERE id_usuario = '" . $_POST["boton_listar"] . "'";
    $resultado = mysqli_query($conexion, $consulta);

    echo "<div class='centrar'>";
    if (mysqli_num_rows($resultado) > 0) { //Si el usuario sigue existiendo

        $tupla = mysqli_fetch_assoc($resultado);

        echo "<h3>Datos del usuario " . $_POST["boton_listar"] . "</h3>";
        echo "<p><strong>Nombre: </strong>" . $tupla["nombre"] . "</p>";
        echo "<p><strong>Usuario: </strong>" . $tupla["usuario"] . "</p>";
        echo "<p><strong>E-mail: </strong>" . $tupla["email"] . "</p>";
        echo "<form action='index.php' method='post'><button type='submit'>Atrás</button></form>";
    } else { //Si el usuario se borra durante

        echo "<p class ='error'>Error de consistencia. El usuario seleccionado ya no existe</p>";
    }

    echo "</div>";

    mysqli_free_result($resultado);
} catch (Exception $e) {

    $mensaje = "Imposible realizar la consulta. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
    mysqli_close($conexion);
    session_destroy();
    die($mensaje);
}
