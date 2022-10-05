<?php
	function fecha_erronea($texto){
	
		$error_fecha = strlen($texto)!=10;
		
		if (!$error_fecha){
		
			$dia = substr($texto, 0, 2);
			$sep1 = substr($texto, 2, 1);
			$mes = substr($texto, 3, 2);
			$sep2 = substr($texto, 5, 1);
			$anio = substr($texto, 6, 2);
			
			$error_separadores = $sep1 != "/" || $sep2 != "/";
			$error_formato = checkdate($mes,$dia,$anio);
			
			$error_fecha = $error_separadores || $error_formato;
			
		}
		return $error_fecha;
	}
	
	if (isset($_POST["boton_submit"])){
	
		
	}

	
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8"/>
        <title>Fechas 1 - Javier Parodi Piñero</title>
        <style>
        	div{border:2px solid black}
        	#entrada{background:lightblue;}
        	#resultado{background:lightgreen;}
        	h1{text-align:center}
        </style>
    </head>

    <body>
		<div id="entrada">
			<h1>Fechas - Formulario</h1>
			
			<form method="post" action="fecha1.php">
				<p>
				<label for="fecha1">Introduzca una fecha: (DD/MM/YYYY)</label>
				<input type="text" name="fecha1" id="fecha1" 
				value="<?php if(isset($_POST["fecha1"])) echo $_POST["fecha1"]?>"/>
				<?php?>
				
				<br/>
				
				<label for="fecha2">Introduzca una fecha: (DD/MM/YYYY)</label>
				<input type="text" name="fecha2" id="fecha2" value="<?php if(isset($_POST["fecha2"])) echo $_POST["fecha2"]?>">
				</p>
				<p>
				<button type="submit" name="boton_submit">Calcular</button>
				</p>
			</form>
		
		</div>
		
<?php
	if(isset($_POST["boton_submit"]) && !$error_fecha){

			$resultado = 0;

			echo "<div id='resultado'><h1>Fechas - Respuesta</h1>";
			echo "<p>La diferencia en días entre las dos fechas introducidas es de ".$resultado."</p></div>";
		

	}
?>
		
		
    </body>
</html>
