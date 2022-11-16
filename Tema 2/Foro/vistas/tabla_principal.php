<?php

$consulta = "SELECT * FROM usuarios";

$resultado = mysqli_query($conexion, $consulta);
        echo "<table class='texto-centrado centrar'>";
        echo "<tr><th>Nombre de Usuario</th><th>Borrar</th><th>Editar</th></tr>";

        while ($tupla = mysqli_fetch_assoc($resultado)) {

            echo "<tr>";
            echo "<td><form action='index.php' method='post'><button type= 'submit' name='boton_listar' 
                value='" . $tupla["id_usuario"] . "' class='enlace'>" . $tupla["nombre"] . "</button></form></td>";

            echo "<td><form action='index.php' method='post'>
                    <input type='hidden' name='nombre' value='" . $tupla["nombre"] . "'/>
                    <button type='submit' name='boton_borrar' value='" . $tupla["id_usuario"] . "' class='boton-accion'>
                        <img src='img/delete.png' alt='borrar' title='borrar'/>
                    </button></form></td>";
            echo "<td><form action='index.php' method='post'>
                    <button type='submit' name='boton_editar' value='" . $tupla["id_usuario"] . "' class='boton-accion'>
                        <img src='img/edit.png' alt='editar' title='editar'/>
                    </button></form></td></tr>";
        }
        echo "</table>";

        mysqli_free_result($resultado);
