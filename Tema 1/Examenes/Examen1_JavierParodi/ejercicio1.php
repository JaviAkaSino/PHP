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
		for ($j = 0; $j < 5; $j++) {

			if ($primera_letra + $j == ord("J"))
				$primera_letra++;
			$linea[] = chr($primera_letra + $j);
		}

		$primera_letra += 5;

		$matriz[] = $linea;
	}
	return $matriz;
}


function matrix_to_file($matriz, $archivo, $separador)
{


	@$file = fopen($archivo, "w");

	if (!$file) {

		echo "<span class='error'>Falta de permisos</span>";
	} else {

		for ($i = 0; $i < count($matriz); $i++) {

			for ($j = 0; $j < count($matriz[0]); $j++) {

				fputs($file, $matriz[$i][$j] . $separador);
			}

			fputs($file, PHP_EOL);
		}

		fclose($file);
	}
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
		<p><button type="submit" name="boton_submit">Generar</button></p>
	</form>

	<?php

	if (isset($_POST["boton_submit"])) {

		matrix_to_file(matriz_polybios(), "claves_polybios.txt", ";");

		echo "<textarea>" . file_get_contents("claves_polybios.txt") . "</textarea>";
		echo "<p>Fichero generado con éxito</p>";
	}


	?>


</body>

</html>