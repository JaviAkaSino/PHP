<?php

echo "<div class='centrar'>";
echo "<h3>Borrado de usuario</h3>";
echo "<p>¿Seguro que desea borrar el usuario " . $_POST["boton_borrar"] . "?</p>";
echo "<form action='index.php' method='post'>
                <button type='submit'>Volver</button>
                <button name='boton_confirmar_borrar' type='submit' value='" . $_POST["boton_borrar"] . "'>Borrar</button>
                <input type='hidden' name = 'nombre_foto' value='" . $_POST["nombre_foto"] . "'/>
            </form>";
echo "</div>";
