<?php
if (isset($_POST["boton_submit"])) {

	$error_form = $_FILES["archivo"]["name"] == "" || $_FILES["archivo"]["error"] ||
		$_FILES["archivo"]["type"] != "text/plain" || $_FILES["archivo"]["size"] > 1000000;
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<title>Examen 1 - Ejercicio 4.2</title>
	<style>
		table,
		td,
		th {
			border: 1px solid black;
			border-collapse: collapse;
			text-align: center;
		}

		th {
			background-color: #777
		}
	</style>
</head>

<body>
	<h1>Ejercicio 4</h1>
	<?php
	@$file = fopen("Horario/horarios2.txt", "r");

	if (!$file) {
	?>

		<h3>No se encuentra el archivo <em>Horario/horarios2.txt</em></h3>

		<form method="post" action="ejercicio4-2.php" enctype="multipart/form-data">
			<p>
				<label for="archivo">Seleccione un archivo txt no superior a 1 MB</label>
				<input type="file" id="archivo" name="archivo" accept=".txt" />

				<?php
				if (isset($_POST["boton_submit"]) && $error_form) {

					if ($_FILES["archivo"]["name"] != "") {
						if ($_FILES["archivo"]["error"])
							echo "<span class='error'>Error de subida al servidor</span>";
						elseif ($_FILES["archivo"]["type"] != "text/plain")
							echo "<span class='error'>El archivo subido no es un archivo de texto</span>";
						else
							echo "<span class='error'>El archivo subido excede el tamaño máximo</span>";
					}
				}
				?>
			</p>
			<p>
				<button type="submit" name="boton_submit">Subir</button>
			</p>
		</form>

		<?php
		if (isset($_POST["boton_submit"]) && !$error_form) {
			@$var = move_uploaded_file($_FILES["archivo"]["tmp_name"], "Horario/horarios2.txt");

			if (!$var)
				echo "<span class='error'>EL archivo no ha podido ser guardado por falta de permisos</span>";
			else {
				echo "El archivo se ha copiado a la carpeta de destino";
			}
		}
		?>

	<?php
	} else {
	?>

		<h2>Horario de los grupos</h2>
		<form action="ejercicio4-2.php" method="post" enctype="multipart/form-data">
			<label for="grupo">Horario del grupo: </label>
			<select id="grupo" name="grupo">
				<?php
				while (!feof($file)) {
					$linea = fgets($file);
					$datos_linea = explode("\t", $linea);
					if (isset($_POST["grupo"]) && $_POST["grupo"] == $datos_linea[0]) {
						echo "<option value='" . $datos_linea[0] . "' selected>" . $datos_linea[0] . "</option>";
						$grupo = $datos_linea[0];
					} else {
						echo "<option value='" . $datos_linea[0] . "'>" . $datos_linea[0] . "</option>";
					}

					for ($i = 1; $i < count($datos_linea); $i += 3) {

						if (isset($horario[$datos_linea[0]][$datos_linea[$i]][$datos_linea[$i + 1]]))
							echo $horario[$datos_linea[0]][$datos_linea[$i]][$datos_linea[$i + 1]] .= " / " . $datos_linea[$i + 2];
						else
							echo $horario[$datos_linea[0]][$datos_linea[$i]][$datos_linea[$i + 1]] = $datos_linea[$i + 2];
					}
				}

				?>
			</select>
			<button type="submit" name="boton_grupo">Ver Horario</button>
		</form>

	<?php

		if (isset($_POST["boton_grupo"])) {

			$horas[1] = "8:15 - 9:15";
			$horas[] = "9:15 - 10:15";
			$horas[] = "10:15 - 11:15";
			$horas[] = "11:15 - 11:45";
			$horas[] = "11:45 - 12:45";
			$horas[] = "12:45 - 13:45";
			$horas[] = "13:45 - 14:45";

			echo "<h3>Horario del Grupo: " . $grupo . "</h3>";

			echo "<table>";
			echo "<tr>
						<th></th>
						<th>Lunes</th>
						<th>Martes</th>
						<th>Miercoles</th>
						<th>Jueves</th>
						<th>Viernes</th>
					</tr>";

			for ($h = 1; $h <= 7; $h++) {

				echo "<tr><th>" . $horas[$h] . "</th>";

				if ($h == 4)
					echo "<td colspan='5'>RECREO</td></tr>";

				else {
					for ($d = 1; $d <= 5; $d++) {

						if (isset($horario[$grupo][$d][$h]))
							echo "<td>" . $horario[$grupo][$d][$h] . "</td>";
						else
							echo "<td></td>";
					}
				}
				echo "</tr>";
			}

			echo "</table>";
		}
	}

	fclose($file);
	?>



</body>

</html>