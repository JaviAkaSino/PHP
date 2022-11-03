<?php

function lista_palabras($str, $sep)
{

	$palabra = "";
	$lista = [];

	for ($i = 0; $i < strlen($str); $i++) {

		if ($str[$i] != $sep) {

			$palabra .= $str[$i];
		} else {

			if ($palabra != "") {

				$lista[] = $palabra;
				$palabra = "";
			}
		}
	}

	if ($palabra != "")
		$lista[] = $palabra;

	return $lista;
}

function long_palabras($arr)
{

	if (count($arr) == 0)
		echo "<p>No hay palabras que contar</p>";

	else {

		for ($i = 0; $i < count($arr); $i++) {

			echo "<p> " . ($i + 1) . ". " . $arr[$i] . " ( " . strlen($arr[$i]) . " ) </p>";
		}
	}
}

if (isset($_POST["boton_submit"])) {

	$error_form = $_POST["texto"] == "";
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
	<title>Ejercicio 2 - Javier Parodi</title>
	<meta charset="UTF-8">
</head>

<body>
	<h1>Ejercicio 2. Longitud de las palabras extraídas</h1>

	<form action="ejercicio2.php" method="post" enctype="multipart/form-data">
		<p>
			<label for="texto">Introduzca un texto: </label>
			<input type="text" name="texto" id="texto" />
			<?php if (isset($_POST["boton_submit"]) && $error_form)
				echo "<span class='error'>Campo vacío</span>"; ?>
		</p>
		<p>
			<label for="separador">Elija el Separador</label>
			<select id="separador" name="separador">
				<option value=",">, (coma)</option>
				<option value=";">; (punto y coma)</option>
				<option value=" "> (espacio)</option>
				<option value=":">: (dos puntos)</option>
			</select>
		</p>
		<button type="submit" name="boton_submit">Contar</button>
	</form>


	<?php
	if (isset($_POST["boton_submit"]) && !$error_form) {

		echo "<h1>Respuesta</h1>";

		long_palabras(lista_palabras($_POST["texto"], $_POST["separador"]));
	}
	?>

</body>

</html>