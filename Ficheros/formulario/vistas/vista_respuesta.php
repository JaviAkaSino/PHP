<!DOCTYPE html>
	<html lang="es">
		<head>
			<title>Recepción de datos</title>
			<meta charset="UTF-8"/>
		</head>
		<body>
			<h1>DATOS ENVIADOS</h1>
			
			<?php
				echo "<p><strong>Nombre: </strong>".$_POST["nombre"]."</p>";
				echo "<p><strong>Usuario: </strong>".$_POST["usuario"]."</p>";
				echo "<p><strong>Contraseña: </strong>".$_POST["contra"]."</p>";
				echo "<p><strong>DNI: </strong>".$_POST["dni"]."</p>";
				//Si se marca el sexo, que salga
				if(isset($_POST["sexo"]))
					echo "<p><strong>Sexo: </strong>".$_POST["sexo"]."</p>";
				if(isset($_POST["sub"]))
					echo "<p><strong>Suscripción: </strong>Aceptada</p>";
				else
					echo "<p><strong>Suscripción: </strong>No aceptada</p>";
			
        if(isset($_POST["boton_submit"])){

			if (!$_FILES["foto"]|| $_FILES["foto"]["name"]==""){

				echo "<p><strong>Foto: </strong>Foto no seleccionada.</p>";
			} else {

				echo "<h3>Información de la imagen seleccionada</h3>";
				echo "<p><strong>Error: </strong>".$_FILES["foto"]["error"]."</p>";
            	echo "<p><strong>Nombre: </strong>".$_FILES["foto"]["name"]."</p>";
				echo "<p><strong>Ruta en Servidor: </strong>".$_FILES["foto"]["tmp_name"]."</p>";
				echo "<p><strong>Tipo archivo: </strong>".$_FILES["foto"]["type"]."</p>";
				echo "<p><strong>Tamaño archivo: </strong>".$_FILES["foto"]["size"]." bytes</p>";
            

				$array_nombre = explode(".", $_FILES["foto"]["name"]);
				$extension = "";
				if(count($array_nombre)>1)
					$extension = ".".strtolower(end($array_nombre));
				
				$nombre_unico = "img_".md5(uniqid(uniqid(),true));

				$nombre_nuevo_archivo = $nombre_unico.$extension;

				//Poniendo un arroba avisas que quieres controlar un warning
				@$var=move_uploaded_file($_FILES["foto"]["tmp_name"], "images/".$nombre_nuevo_archivo);

				if(!$var){

					echo "<p>La imagen no ha podido ser movida por falta de permisos</p>";

				} else {

					echo "<h3>La imagen ha sido subida con éxito</h3>";
					echo "<img height='200' src='images/".$nombre_nuevo_archivo."'/>";

					//sudo chmod 777 -R '/opt/lampp/htdocs/PHP

				}
			}

            
		} 
			?>
		</body>
	</html>
