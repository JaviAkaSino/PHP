<!DOCTYPE html>
	<html lang="es">
		<head>
			<title>Recepción de datos</title>
			<meta charset="UTF-8"/>
		</head>
		<body>
			<h1>Recibiendo los datos del formulario</h1>
			
			<?php
			//Array de las opciones del select
				$provincia[0]="Málaga";
				$provincia[1]="Sevilla";
				$provincia[2]="Granada";
			//$_POST u $POST son variables que se crean si se hace un submit. 
			//Es un array asociativo, es decir, en vez de índice, el nombre
				echo "<p><strong>Nombre: </strong>".$_POST["nombre"]."</p>";
				echo "<p><strong>Apellidos: </strong>".$_POST["apellidos"]."</p>";
				echo "<p><strong>Contraseña: </strong>".$_POST["contra"]."</p>";
				echo "<p><strong>DNI: </strong>".$_POST["dni"]."</p>";
				//Si se marca el sexo, que salga
				if(isset($_POST["sexo"]))
					echo "<p><strong>Sexo: </strong>".$_POST["sexo"]."</p>";
				//Si hay una sola sentencia, se pueden omitir las llaves
				//Cogemos la posición del array provincias
				echo "<p><strong>Nacido en: </strong>".$provincia[$_POST["ciudad"]]."</p>";
				
				
				echo"<p><strong>Comentarios: </strong>".$_POST["coment"]."</p>";
				//Si se marca la casilla, sí; sino, no
				if(isset($_POST["sub"]))
					echo "<p><strong>Suscripción: </strong>Sí</p>";
				else
					echo "<p><strong>Suscripción: </strong>No</p>";
			?>
			
		</body>
	</html>
