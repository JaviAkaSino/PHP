<!DOCTYPE html>
<html lang="es">
	<head>
		<title>Prueba 1</title>
		<meta charset="UTF-8"/>
	</head>
	<body>
		<?php
			//Comentario linea
			/*Comentario párrafo*/
			echo "<h1>Esta es mi primera web DWESE</h1>";
			$a = 8;
			$b = 7;
			echo "<p>El resultado de sumar 7 y 8 es ".($a+$b)."</p>";
			echo "<p>El resultado de restar 7 y 8 es ".($a-$b)."</p>";
		?>
		<h2>Y ahora, más código</h2>
		<?php
			echo "<p>El resultado de multiplicar 7 y 8 es ".($a*$b)."</p>";
			echo "<p>Concateno dos variables numéricas: ".$a.$b."</p>";
		?>
	</body>
</html>
