<?php
echo "<div class='texto-centrado'>
<p>Se dispone usted a borrar el producto " . $_POST["boton_borrar"] . "</p>
<form action='index.php' method='post'>
    <button>Cancelar</button>
    <button name='boton_confirmar_borrar' value='" . $_POST["boton_borrar"] . "'>Confirmar</button>
</form>
</div>";
