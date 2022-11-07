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
			$error_numeros = !is_numeric($dia) || !is_numeric($mes) || !is_numeric($anio);
			
			$error_fecha = $error_separadores || $error_numeros || !checkdate($mes,$dia,$anio);
			
		}
		return $error_fecha;
	}
	
	//Cuando se pulsa submit, se comprueban los input
	if (isset($_POST["boton_submit"])){

		$error_fecha1 = fecha_erronea(trim($_POST["fecha1"]));
		$error_fecha2 = fecha_erronea(trim($_POST["fecha2"]));
		$error_form = $error_fecha1 || $error_fecha2;
	}

	
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8"/>
        <title>Fechas 1 - Javier Parodi Piñero</title>
        <style>
        	div{border:2px solid black}
        	#entrada{background:lightblue}
        	#resultado{background:lightgreen}
        	h1{text-align:center}
			.error{font-weight:bold}
        </style>
    </head>

    <body>
		<div id="entrada">
			<h1>Fechas - Formulario</h1>
			
			<form method="post" action="fecha1.php">
				<p>
				<label for="fecha1">Introduzca una fecha: (DD/MM/YYYY)</label>
				<input type="text" name="fecha1" id="fecha1" 
				value="<?php if(isset($_POST["fecha1"])) echo $_POST["fecha1"];?>"/>

				<?php 
					if (isset($_POST["boton_submit"]) && $error_fecha1) {
					
						if ($_POST["fecha1"] == "")
							echo "<span class = 'error'>* Campo vacío</span>";
						else	
							echo "<span class = 'error'>* La fecha introducida no es válida</span>";

					}
				?>
				
				<br/>
				
				<label for="fecha2">Introduzca una fecha: (DD/MM/YYYY)</label>
				<input type="text" name="fecha2" id="fecha2" 
				value="<?php if(isset($_POST["fecha2"])) echo $_POST["fecha2"]?>">
				
				<?php 
					if (isset($_POST["boton_submit"]) && $error_fecha2) {
					
						if ($_POST["fecha2"] == "")
							echo "<span class = 'error'>* Campo vacío</span>";
						else	
							echo "<span class = 'error'>* La fecha introducida no es válida</span>";

					}
				?>
			
				</p>
				<p>
				<button type="submit" name="boton_submit">Calcular</button>
				</p>
			</form>
		
		</div>
		<br/>

<?php

	if(isset($_POST["boton_submit"]) && !$error_form){

			$fecha1 = explode("/", trim($_POST["fecha1"]));
			$fecha2 = explode("/", trim($_POST["fecha2"]));

			$resultado_seg = mktime(0,0,0,$fecha1[1], $fecha1[0], $fecha1[2]) - mktime(0,0,0,$fecha2[1], $fecha2[0], $fecha2[2]);
			$resultado_dias = floor(abs($resultado_seg / (60*60*24)));
			echo "<div id='resultado'><h1>Fechas - Respuesta</h1>";
			echo "<p>La diferencia en días entre las dos fechas introducidas es de ".$resultado_dias."</p></div>";

	}
?>
	
    </body>
</html>
