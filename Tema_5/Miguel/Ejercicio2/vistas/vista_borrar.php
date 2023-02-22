<?php
echo "<div class='centro centrado'>";
echo "<p>Se dispone usted a borrar el producto: ".$_POST["btnBorrar"]."</p>";
echo "<form action='index.php' method='post'>";
echo "<p>¿Estás Seguro?</p>";
echo "<p><button>Cancelar</button><button name='btnContBorrar' value='".$_POST["btnBorrar"]."'>Continuar</button></p>";
echo "</form>"; 
echo "</div>";
?>