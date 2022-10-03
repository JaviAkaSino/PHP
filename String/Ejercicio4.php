

<?php
	const VALORES = array("M" => 1000, "D" =>500, "C"=>100,"L"=>50,"X"=>10,"V"=>5,"I"=>1);
	
	function letras_bien($texto){
		$bien = true;
		for ($i=0;$i<strlen($texto);$i++){
			if(!isset(VALORES[$texto[$i]]){
				$bien=false;
				break;
			}		
		}
		
		return $bien;
	}
	
	function orden_decreciente($texto){
	
		$bien = true;
		for ($i=0;$i<strlen($texto)-1;$i++){
			if(VALORES[$texto[$i]] < VALORES[$texto[$i+1]]){
				$bien=false;
				break;
			}
		
		}
		
		return $bien;
	}
	
	function repite_bien($texto){
	
		$limite["M"]=4;
		$limite["D"]=1;
		$limite["C"]=4;
		$limite["L"]=1;
		$limite["X"]=4;
		$limite["V"]=1;
		$limite["I"]=4;
		$bien = true;
		
		for ($i=0;$i<strlen($texto);$i++){
			
			$limite[$texto[$i]]--;
			
			if($limite[$texto[$i]]==-1){
		
			$bien = false;
			return $bien;
			}
		}	
	}
	
	
	
	function es_romano($texto){
		return letras_bien($texto) && orden_decreciente($texto) && repite_bien($texto)
	}
	
	if(isset($_POST["botonSubmit"])){
		$error = ($_POST["entrada"]="" || !es_romano(trim(strtoupper($_POST["entrada"])));
	}
?>




<!DOCTYPE html>
<html>
	<head>
		<title>Ejercicio 4 Strings</title>
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
		<h2>Romanos a árabes - Formulario</h2>
		
		<p>Dime un número romano y lo convertiré a cifras árabes</p>
		
		<form method="post" action="Ejercicio4.php">
		
			<p><label for="entrada">Número: </label>
			
			<input type="text" id="entrada" name="entrada" value="<?php if (isset($_POST["entrada"])) echo $_POST["entrada"];?>"/>
			
			<?php 
			if (isset($_POST["botonSubmit"]) && $error) {
				
				if($_POST["entrada"]=="")
					echo "<span class='error'> * Campo vacío</span>";
				else
					echo "<span class='error'> * Número romano no escrito correctamente</span>";
			}?></p>
			
			
			
			
			<button type="submit" name="botonSubmit">Convertir</button>
		
		</form>
		</div>
		
	<?php
	
		if(isset($_POST["botonSubmit"])&& !$error){
		$entrada = $_POST["entrada"];
		
	?>
	
		<div id="div_res">
			<h2>Romanos a árabes - Resultado</h2>
		
			<?php echo "<p>".$_POST["entrada"];
			
			
			
			
			?>
			
			</p>
			
			
		</div>
	
	<?php
	
	}
	
	?>
		
		
	</body>
</html>
