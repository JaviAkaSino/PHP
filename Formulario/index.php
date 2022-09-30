
<?php 

	function estaEnArray($valor, $array){
	
	$encontrado = false;
	
	for($i=0;$i<count($array);$i++){
	
		if($array[$i]==$valor){
		
			return true;
		}
	}
	
	return $encontrado;
	}
	$error_formulario = true;
	if(isset($_POST["botonGuardar"])){

	$error_nombre = $_POST["nombre"]=="";
	$error_sexo = !isset($_POST["sexo"]);

	$error_formulario = $error_nombre || $error_sexo;
	}
	
	if(!$error_formulario){
	
?>

	<!--RESPUESTAS-->
<!DOCTYPE html/>
<html>
<head>
	<title>Recogida</title>
	<meta charset="UTF-8"/>
</head>
<body>
	<h2>Estos son los datos enviados:</h2>
	
	<?php
	
		/*$ciudades[0]="Málaga";
		$ciudades[1]="Estepona";
		$ciudades[2]="Marbella";*/
		
		//2==>"Marbella"
		
		$ciudades = array("Málaga","Estepona","Marbella");
	
		echo "<p><strong>El nombre enviado ha sido: </strong>".$_POST["nombre"]."</p>";
		echo "<p><strong>Ha nacido en: </strong>".$ciudades[$_POST["ciudad"]]."</p>";
		echo "<p><strong>El sexo es: </strong>".$_POST["sexo"]."</p>";
		
		//Aficiones
		if (isset($_POST["aficiones"])){
		
			$n_aficiones = count($_POST["aficiones"]);
			if($n_aficiones>1){
				echo "<p><strong>Las aficiones seleccionadas han sido: </strong></p>";
			} else {
			
			echo "<p><strong>La afición seleccionada ha sido: </strong></p>";
			
			}
			
			echo "<ol>";
			
				for($i=0; $i<$n_aficiones; $i++){
				
				echo "<li>".$_POST["aficiones"][$i]."</li>";
				
				}
				echo "</ol>";
		
		} else {
		
		echo "<p><strong>No has seleccionado ninguna afición</strong></p>";
		
		}
		
		if(isset($_POST["coment"]))	echo "<p><strong>El comentario enviado ha sido: </strong>".$_POST["coment"]."</p>";
		else echo "<p><strong>No has hecho ningún comentario</strong></p>"
		
		
	?>
</body>
</html>
	

<?php
	
	} else {
	
?>



<!DOCTYPE html/>
<html>
	<head>
		<title>Mi primera página PHP</title>
		<meta charset="UTF-8"/>
	</head>
	
	<body>
		<h2>Esta es mi super página</h2>
		<form method="post" action="index.php">
			<p>
			<label for="nombre">Nombre: </label>
			<input type="text" id="nombre" name="nombre"
			value="<?php if (isset($_POST["nombre"])) echo $_POST["nombre"];?>"/>
			<?php if (isset($_POST["nombre"]) && $error_nombre) echo "<span class='error'>**Campo obligatorio**</span>"?>
			</p>
			<p>
			<label for="ciudad">Nacido en: </label>
			<select id="ciudad" name="ciudad">
				<option value="0">Málaga</option>
				<option value="1">Estepona</option>
				<option value="2">Marbella</option>
			</select>
			</p>
			<p>
			<label>Sexo: </label>
			<label for="hombre">Hombre </label>
			<input type="radio" name="sexo" id="hombre" value="Hombre"
			<?php if (isset($_POST["sexo"]) && $_POST["sexo"]=="Hombre") echo "checked";?>/>
			<label for="mujer">Mujer </label>
			<input type="radio" name="sexo" id="mujer" value="Mujer"
			<?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "Mujer") echo "checked";?>/>
			<?php if(isset($_POST["botonGuardar"]) && $error_sexo) echo "<span class='error'>**Campo obligatorio**</span>"?>
			</p>
			<p>
			<label>Aficiones: </label>
			<label for="deportes">Deportes</label>
			<input type="checkbox" name= "aficiones[]" id="deportes" value="Deportes" <?php if(isset($_POST["aficiones"])&& estaEnArray("Deportes", $_POST["aficiones"])) echo "checked"?>/>
			<label for="lectura">Lectura</label>
			<input type="checkbox" name= "aficiones[]" id="lectura" value="Lectura" <?php if(isset($_POST["aficiones"])&& estaEnArray("Lectura", $_POST["aficiones"])) echo "checked"?>/>
			<label for="otros">Otros</label>
			<input type="checkbox" name= "aficiones[]" id="otros" value="Otros" <?php if(isset($_POST["aficiones"])&& estaEnArray("Otros", $_POST["aficiones"])) echo "checked"?>/>
			
			</p>
			<p>
			<label for="coment">Comentarios: </label>
			<textarea id="coment" name="coment"><?php if(isset($_POST["coment"])) echo $_POST["coment"];
			?></textarea>
			</p>
			<p>
			<button type="submit" name="botonGuardar">Enviar</button>
			</p>
		</form>
	</body>
</html>

<?php

	}
	
?>
