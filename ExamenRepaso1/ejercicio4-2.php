<?php
	if(isset($_POST["boton_submit"])){
	
		$error_form = $_FILES["archivo"]["name"]=="" || $_FILES["archivo"]["x"]
	}
?>


<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Examen 1 - Ejercicio 4.2</title>
</head>
<body>
	<h1>Ejercicio 4</h1>
	
	
	<h3>No se encuentra el archivo <em>Horario/horarios2.txt</em></h3>
	
	<form method="post" action="ejercicio4-b.php" enctype="multipart/form-data">
	<p>
		<label for="archivo">Seleccione un archivo txt no superior a 1 MB</label>
		<input type="file" id="archivo" name="archivo" accept=".txt"/>
	</p>
	<p>
		<button type="submit" name="boton_submit">Subir</button>
	</p>		
	</form>
</body>
</html>
