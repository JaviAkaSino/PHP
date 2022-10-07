<?php
    const LETRAS = array("M", "D", "C", "L", "X", "V", "I");
	const VALORES = array(1000, 500, 100, 50, 10, 5, 1);

	
	if(isset($_POST["boton_submit"])){

		$error = $_POST["entrada"] == "" || $_POST["entrada"] >= 5000  || !is_numeric($_POST["entrada"]);
	}
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<title>Ejercicio 5 Strings</title>
		<meta charset="UTF-8"/>
		<style>
			div{border:2px solid black;padding:10px;margin:10px}
			#div_form{background-color:lightblue}
			#div_res{background-color:lightgreen}
			h2{text-align:center}
		</style>
	</head>
	<body>
		<div id="div_form">
		<h2>Árabes a romanos - Formulario</h2>
		
		<p>Dime un número y lo convertiré a números romanos</p>
		
		<form method="post" action="string5.php">
		
			<p><label for="entrada">Número: </label>
			
			<input type="text" id="entrada" name="entrada" value="<?php if (isset($_POST["entrada"])) echo $_POST["entrada"];?>"/>
			
			<?php 
			if (isset($_POST["boton_submit"]) && $error) {
				
				if($_POST["entrada"]=="")
					echo "<span class='error'> * Campo vacío</span>";
                elseif (!is_numeric($_POST["entrada"]))
                    echo "<span class='error'> * Introduce un número válido</span>"; 
				else
					echo "<span class='error'> * Introduce un número inferior a 5000</span>";
					
			}
			?>
			</p>
			
			<button type="submit" name="boton_submit">Convertir</button>
		
		</form>
		</div>
		
	<?php
	
		if(isset($_POST["boton_submit"]) && !$error){
	
			echo "<div id='div_res'>";
			echo "<h2>Árabes a romanos  - Resultado</h2>";
		
			$entrada = trim($_POST["entrada"]);
            $resto = $entrada;
			$romanos = "";


            for ($i=0; $i < count(VALORES); $i++){

                if ($resto >= VALORES[$i]){

                    for ($j=0; $j < intdiv($resto, VALORES[$i]); $j++){

                    $romanos = $romanos.LETRAS[$i]; 
     
                    }

                    $resto = $resto % VALORES[$i]; 

                } 
            }  

			
			echo "<p>El número ".$entrada ." se escribe con números romanos ".$romanos;
	?>

			</p>		
		</div>

		<?php } ?>
	</body>
</html>
