<?php
echo "<p class='centrar'>Se dispone a eliminar al usuario " . $_POST["nombre"] . "</p>";
echo "<form action='index.php' method='post' class='centrar'>";
echo "<button type='submit' name='boton_volver'>Volver</button>";
echo "<button type='submit' name='boton_confirma_borrar' value='" . $_POST["boton_borrar"] . "'>Continuar</button>";
echo "</form>";
