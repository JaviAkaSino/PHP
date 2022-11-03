<?php

function matriz_polybios()
{

	$primera_fila[] = "i/j";
	for ($i = 1; $i <= 5; $i++)
		$primera_fila[] = $i;

	$matriz[] = $primera_fila;
	$primera_letra = ord("A");

	
	for ($i = 1; $i <= 5; $i++) {
		$linea = [];
		$linea[] = $i;
		for ($j = 0; $j < 5; $j++){

			$linea[] = chr( $primera_letra + $j);
			
		}

			$primera_letra+=5;

		$matriz[] = $linea;
	}
	return $matriz;
}

?>


<!DOCTYPE html>
<html lang="es">

<head>
	<title>Ejercicio 1 - Javier Parodi</title>
	<meta charset="UTF-8">
</head>

<body>
	<h1>Ejercicio 1. Generador de "claves_polybios.txt"</h1>

	<form action="ejercicio1.php" method="post" enctype="multipart/form-data">
		<button type="submit" name="boton_submit">Generar</button>
	</form>

	<?php

	$matriz = matriz_polybios();
	print_r($matriz);

	$file = fopen("claves_polybios.txt", "w");

	if (!$file){

		echo "<span class='error'>Falta de permisos</span>";
	}
		

	else{

		for ($i = 0; $i < count($matriz); $i++) {
	
			for ($j = 0; $j < count($matriz[0]); $j++){
	
				fputs("claves_polybios.txt", $matriz[$i][$j].";");
				
			}

		}

	}


	?>


</body>

</html>