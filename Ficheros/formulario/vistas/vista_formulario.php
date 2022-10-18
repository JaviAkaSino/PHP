<!DOCTYPE html/>
<html lang="es">
	<head>
		<title>Ejemplo de Formulario</title>
		<meta charset="UTF-8"/>
	</head>
	<body>
		<h1>Rellena tu CV</h1>
		<form method="post" action="index.php" enctype="multipart/form-data">
			
			<label for="nombre">Nombre:</label>
			<br/>
			<input type="text" id="nombre" name="nombre" 
			value="<?php if(isset($_POST["nombre"])) //NO espacios
					echo $_POST["nombre"];?>"/> 
			<?php
			if(isset($_POST["nombre"]) && $error_nombre)
				echo "<span class='error'>* Campo vacio *</span>";
			?>
			
			<br/>
			<label for="usuario">Usuario:</label>
			<br/>
			<input type="text" id="usuario" name="usuario"
			value="<?php if(isset($_POST["usuario"]))
					echo $_POST["usuario"];?>"/>
			<?php
			if(isset($_POST["usuario"])&&$error_usuario)
				echo "<span class='error'>* Campo vacío *</span>";
			?>
			<br/>
			
			<label for="contra">Contraseña:</label>
			<br/>
			<input type="password" id="contra" name="contra"/>
			<?php
			if(isset($_POST["contra"])&&$error_contra)
				echo "<span class='error'>* Campo vacío *</span>"?>
			<br/>
			
			<label for="dni">DNI:</label>
			<br/>
			<input type="text" id="dni" name="dni" size="10" maxlength="9"
			value="<?php if (isset($_POST["dni"])) echo $_POST["dni"];?>"/>
			<?php
			if (isset($_POST["dni"])&&$error_dni)

				if($_POST["dni"]==""){
					echo "<span class='error'>* Campo vacio *</span>";
				} else if (!formato_dni($_POST["dni"])){
					
					echo "<span class='error'>* Debes rellenar el DNI con 8 dígitos seguidos de una letra *</span>";
				}else {
					echo "<span class='error'>* DNI no válido *</span>";
					
				}
				
			?>
			<br/>
			<label>Sexo:</label>
			<?php
			if(isset($_POST["boton_submit"]) && $error_sexo)
				echo "<span class='error'>* Debe seleccionar una opción *</span>";
			?>
			<br/>
			<input type="radio" name="sexo" value="Hombre" id="hombre"
			<?php
			if(isset($_POST["sexo"])&&$_POST["sexo"]=="Hombre") echo "checked";
			?>/>
			<label for="hombre">Hombre</label>
			<br/>
			<input type="radio" name="sexo" value="Mujer" id="mujer"
			<?php
			if(isset($_POST["sexo"])&&$_POST["sexo"]=="Mujer") echo "checked";
			?>/>
			<label for="mujer">Mujer</label>
			<br/>
			<br/>

			<label for="foto">Incluir mi foto (Archivo tipo imagen Max. 500KB): </label> 
			<input type="file" id="foto" name="foto" accept="image/*"/>
			
			<br/>
			<br/>
			
			<input type="checkbox" name="sub" id="sub" checked/>
			<label for="sub">Suscribirse al boletin de Novedades:</label>
			<br/>
			<br/>
			
			<!--Ponerle un name al submit para ver si se ha pulsado (si se han intendado enviar datos)-->
			<button type="submit" name="boton_submit">Guardar cambios</button>
			<button type="submit" name="botonReset">Borrar los datos introducidos</button>
		</form>
	</body>
</html>
