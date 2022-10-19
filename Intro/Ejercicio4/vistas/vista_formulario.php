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
			<input type="text" id="nombre" name="nombre" 
			value="<?php if(isset($_POST["nombre"])) //NO espacios
					echo $_POST["nombre"];?>"/> 
			<?php
			if(isset($_POST["nombre"]) && $error_nombre)
				echo "<span class='error'>* Campo vacio *</span>";
			?>
			
			<br/>
			<label for="apellidos">Apellidos</label>
			<br/>
			<input type="text" id="apellidos" name="apellidos" size="50"
			value="<?php if(isset($_POST["apellidos"]))
					echo $_POST["apellidos"];?>"/>
			<?php
			if(isset($_POST["apellidos"])&&$error_apellidos)
				echo "<span class='error'>* Campo vacío *</span>";
			?>
			<br/>
			
			<label for="contra">Contraseña</label>
			<br/>
			<input type="password" id="contra" name="contra"/>
			<?php
			if(isset($_POST["contra"])&&$error_contra)
				echo "<span class='error'>* Campo vacío *</span>"?>
			<br/>
			
			<label for="dni">DNI</label>
			<br/>
			<input type="text" id="dni" name="dni" size="10" maxlength="9"
			value="<?php if (isset($_POST["dni"])) echo $_POST["dni"];?>"/>
			<?php
			if (isset($_POST["dni"])&&$error_dni)
				echo "<span class='error'>* Campo vacio *</span>";
			?>
			<br/>
			<label>Sexo</label>
			<?php
			if(isset($_POST["botonGuardar"]) && $error_sexo)
				echo "<span class='error'>* Debe seleccionar una opción *</span>";
			?>
			<br/>
			<input type="radio" name="sexo" value="hombre" id="hombre"
			<?php
			if(isset($_POST["sexo"])&&$_POST["sexo"]=="hombre") echo "checked";
			?>/>
			<label for="hombre">Hombre</label>
			<br/>
			<input type="radio" name="sexo" value="mujer" id="mujer"
			<?php
			if(isset($_POST["sexo"])&&$_POST["sexo"]=="mujer") echo "checked";
			?>/>
			<label for="mujer">Mujer</label>
			<br/>
			<br/>
			<label for="foto">Incluir mi foto: </label> 
			<input type="file" id="foto" name="foto" accept="image/*"/>
			<br/>
			<br/>
			<label for="ciudad">Nacido en: </label>
			<select id="ciudad" name="ciudad">
				<option value="0"<?php if(isset($_POST["ciudad"])&&$_POST["ciudad"]==0) echo "selected"; ?>>Málaga</option>
				<option value="1" <?php if(isset($_POST["ciudad"])&&$_POST["ciudad"]==1) echo "selected";?>>Sevilla</option>
				<option value="2" <?php if(isset($_POST["ciudad"])&&$_POST["ciudad"]==2) echo "selected";?>>Granada</option>
			</select>
			<br/>
			<br/>
			<label for="coment">Comentarios: </label>
			<textarea id="coment" name="coment" rows="5" cols="30"><?php
				if(isset($_POST["coment"])) echo $_POST["coment"];
			?></textarea>
			<?php if(isset($_POST["coment"]) && $error_coment) echo "<span class='error'>* Campo vacio *</span>";
			?>
			<br/>
			<br/>
			<input type="checkbox" name="sub" id="sub" checked/>
			<label for="sub">Suscribirse al boletin de Novedades</label>
			<br/>
			<br/>
			
			<!--Ponerle un name al submit para ver si se ha pulsado (si se han intendado enviar datos)-->
			<button type="submit" name="botonGuardar">Guardar cambios</button>
			<button type="submit" name="botonReset">Borrar los datos introducidos</button>
		</form>
	</body>
</html>
