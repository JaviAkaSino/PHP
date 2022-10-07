

<?php
	if (isset($_POST["botonSubmit"])){
	
	$error_primera = strlen($_POST["primera"]) < 3;
	$error_segunda = strlen($_POST["segunda"]) < 3;
	$error_formulario = $error_primera || $error_segunda;
	}
	

?>




<!DOCTYPE html>
<html>
	<head>
		<title>Riman</title>
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
		<h2>Ripios - Formulario</h2>
		
		<p>Dime dos palabras y te dire si riman o no.</p>
		
		<form method="post" action="string1.php">
		
			<p><label for="primera">Primera palabra: </label>
			<input type="text" id="primera" name="primera" value="<?php if (isset($_POST["primera"])) echo $_POST["primera"];?>"/>
			
			<?php 
			if (isset($_POST["primera"])&&$error_primera) {
				
				if($_POST["primera"]=="")
					echo "<span class='error'> * Campo vacío</span>";
				else
					echo "<span class='error'> * Introduzca al menos 3 caracteres</span>";
			}?></p>
			
			
			<p><label for="segunda">Segunda palabra: </label>
			<input type="text" id="segunda" name="segunda" value="<?php if (isset($_POST["segunda"])) echo $_POST["segunda"];?>"/>
			<?php 
			if (isset($_POST["segunda"])&&$error_segunda) {
				
				if($_POST["segunda"]=="")
					echo "<span class='error'> * Campo vacío</span>";
				else
					echo "<span class='error'> * Introduzca al menos 3 caracteres</span>";
			}?></p>
			
			<button type="submit" name="botonSubmit">Comparar</button>
		
		</form>
		</div>
		
	<?php
	
		if(isset($_POST["botonSubmit"])&&!$error_formulario){
		
	?>
	
		<div id="div_res">
			<h2>Ripios - Resultado</h2>
			
			<p>Las palabras
			
			<?php echo $_POST["primera"]." y ".$_POST["segunda"];
			
			$primera = trim(strtolower($_POST["primera"]));
			$segunda = trim(strtolower($_POST["segunda"]));
			
			$ultpri = $primera[strlen($primera)-1];
			$penpri = $primera[strlen($primera)-2];
			$antpri=$primera[strlen($primera)-3];
			
			$ultseg = $segunda[strlen($segunda)-1];
			$penseg = $segunda[strlen($segunda)-2];
			$antseg=$segunda[strlen($segunda)-3];
			
			if ($ultpri == $ultseg && $penpri == $penseg){
			
				if ($antpri == $antseg)
					echo " riman";
				else 
					echo " riman un poco";
				
			} else {
			
			echo " no riman";
			}
			?>
			
			</p>
			
			
		</div>
	
	<?php
	
	}
	
	?>
		
		
	</body>
</html>
