<!DOCTYPE html/>
<html lang="es">
	<head>
		<title>Ejemplo de Formulario</title>
		<meta charset="UTF-8"/>
	</head>
	<body>
		<h1>Rellena tu CV</h1>
		<form method="post" action="index.php" enctype="multipart/form-data">
			<label for="nombre">Nombre</label>
			<br/>
			<input type="text" id="nombre" name="nombre"/>
			<br/>
			<label for="apellidos">Apellidos</label>
			<br/>
			<input type="text" id="apellidos" name="apellidos" size="50">
			<br/>
			<label for="contra">Contraseña</label>
			<br/>
			<input type="password" id="contra" name="contra"/>
			<br/>
			<label for="dni">DNI</label>
			<br/>
			<input type="text" id="dni" name="dni" size="10" maxlength="9"/>
			<br/>
			<label>Sexo</label>
			<br/>
			<input type="radio" name="sexo" value="hombre" id="hombre"/>
			<label for="hombre">Hombre</label>
			<br/>
			<input type="radio" name="sexo" value="mujer" id="mujer"/>
			<label for="mujer">Mujer</label>
			<br/>
			<br/>
			<label for="foto">Incluir mi foto: </label> 
			<input type="file" id="foto" name="foto" accept="image/*"/>
			<br/>
			<br/>
			<label for="ciudad">Nacido en: </label>
			<select id="ciudad" name="ciudad">
				<option value="0" selected>Málaga</option>
				<option value="1">Sevilla</option>
				<option value="2">Granada</option>
			</select>
			<br/>
			<br/>
			<label for="coment">Comentarios: </label>
			<textarea id="coment" name="coment" rows="5" cols="30"></textarea>
			<br/>
			<br/>
			<input type="checkbox" name="sub" id="sub" checked/>
			<label for="sub">Suscribirse al boletin de Novedades</label>
			<br/>
			<br/>
			
			<!--Ponerle un name al submit para ver si se ha pulsado (si se han intendado enviar datos)-->
			<button type="submit" name="botonGuardar">Guardar cambios</button>
			<button type="reset">Borrar los datos introducidos</button>
		</form>
	</body>
	
	
</html>
