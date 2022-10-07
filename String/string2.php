

<?php
	if (isset($_POST["botonSubmit"])){
	
	$error = strlen($_POST["entrada"]) < 2;
	}
	

?>




<!DOCTYPE html>
<html>
	<head>
		<title>Palíndromos / capicúas</title>
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
		<h2>Palíndromos / capicúas - Formulario</h2>
		
		<p>Dime una palabra o un número y te diré si es un palíndromo o un número capicúa.</p>
		
		<form method="post" action="string2.php">
		
			<p><label for="primera">Palabra o número: </label>
			<input type="text" id="entrada" name="entrada" value="<?php if (isset($_POST["entrada"])) echo $_POST["entrada"];?>"/>
			
			<?php 
			if (isset($_POST["entrada"])&&$error) {
				
				if($_POST["entrada"]=="")
					echo "<span class='error'> * Campo vacío</span>";
				else
					echo "<span class='error'> * Introduzca al menos 2 caracteres</span>";
			}?></p>
			
			
			<button type="submit" name="botonSubmit">Comprobar</button>
		
		</form>
		</div>
		
	<?php
	
		if(isset($_POST["botonSubmit"])&&!$error){
		$entrada = $_POST["entrada"];
		
	?>
	
		<div id="div_res">
			<h2>Palíndromos / capicúas - Resultado</h2>
		
			<?php echo "<p>".$_POST["entrada"];
			$palindromo = true;
			
			for($i=0; $i<strlen($entrada)/2; $i++){
			
				if($entrada[$i]!=$entrada[strlen($entrada)-1-$i]){
				
				$palindromo = false;
				}
			}
			
			if(is_numeric($entrada)){
			
				if ($palindromo) echo " es un número capicúa";
			else echo " no es un número capicúa";
				
			}else{
			
				if ($palindromo) echo " es un palíndromo";
			else echo " no es un palíndromo";
			
			}		
			?>	

			</p>
		</div>
	
	<?php
	
	}
	
	?>
	
	</body>
</html>
