<?php


try {
    $consulta = "SELECT * FROM usuarios";
    $resultado = mysqli_query($conexion, $consulta);

    echo "<h3 class='centrar'>Listado de los usuarios</h3>";

    if (isset($mensaje_accion)) {
        echo "<p class='centrar'>" . $mensaje_accion . "</p>";
    }

    echo "<table class='centrar texto-centrado'>";
    echo "<tr>
            <th>#</th>
            <th>Foto</th>
            <th>Nombre</th>
            <th>
                <form action='index.php' method='post'>
                    <button type='submit' name='boton_nuevo' class='enlace'>
                        Usuario +</button>
                </form>
            </th>
        </tr>";

    while ($tupla = mysqli_fetch_assoc($resultado)) {

        echo "<tr>";
        echo "<td>" . $tupla["id_usuario"] . "</td>";
        echo "<td><img src='Img/" . $tupla["foto"] . "' alt='Foto de perfil' title='Foto de perfil' /></td>";
        echo "<td>
                <form method='post' action='index.php'>
                    <button class='enlace' name='boton_listar' value='" . $tupla["id_usuario"] . "' type='submit'>" . $tupla["nombre"] . "</button>
                </form>
            </td>";
        echo "<td>
                <form method='post' action='index.php'>
                    <input type='hidden' name= 'nombre_foto' value='" . $tupla["foto"] . "'/>
                    <button name='boton_borrar' value='" . $tupla["id_usuario"] . "' class='enlace' type='submit'>Borrar</button>
                    -
                    <button name='boton_editar' value='" . $tupla["id_usuario"] . "' class='enlace' type='submit'>Editar</button>
                </form>
            </td>";
    }

    echo "</table>";
    mysqli_free_result($resultado);
} catch (Exception $e) {

    $mensaje = "<p>Imposible realizar la conexión. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion) . "</p>";
    mysqli_close($conexion);
    die($mensaje);
}
