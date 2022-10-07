<!DOCTYPE html>
<html>
	<head>
		<title>Quitar acentos</title>
		<meta charset="UTF-8"/>
		<style>
			div{border:2px solid black;padding:10px;margin:10px}
			#div_form{background-color:lightblue}
			#div_res{background-color:lightgreen}
			h2{text-align:center}
            form>p{display: flex; align-items: center;}
		</style>
	</head>
	<body>
		<div id="div_form">
		<h2>Quita acentos - Formulario</h2>
		
		<p>Escribe un texto y le quitaré los acentos.</p>
		
		<form method="post" action="string6.php">
		
			<p><label for="entrada">Texto: </label>
			<textarea id="entrada" name="entrada" rows="5"><?php if (isset($_POST["entrada"])) echo $_POST["entrada"];?></textarea>
			
			<?php 
			if (isset($_POST["entrada"]) && $_POST["entrada"]=="")
                echo "<span class='error'> * Campo vacío</span>";
			?>
            </p>
		
			<button type="submit" name="boton_submit">Quitar acentos</button>
		
		</form>
		</div>
		
	<?php
		if(isset($_POST["boton_submit"])&&!$_POST["entrada"]==""){

		$original = $_POST["entrada"];
        $sin_acentos = str_replace(array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä',
             'é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë', 'í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î',
             'ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô', 'ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
             array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A', 'e', 'e', 'e', 'e', 'E', 'E', 'E', 'E',
             'i', 'i', 'i', 'i', 'I', 'I', 'I', 'I', 'o', 'o', 'o', 'o', 'O', 'O', 'O', 'O',
             'u', 'u', 'u', 'u', 'U', 'U', 'U', 'U') , $_POST["entrada"]);
		
	?>
	
		<div id="div_res">
			<h2>Quita acentos - Resultado</h2>

            <p>
                
            <dl>
                <dt>Texto original:</dt>
                <dd><?php echo $original ?></dd>
                

                <dt>Texto sin acentos:</dt>
                <dd><?php echo $sin_acentos ?></dd>
                

            </dl>
            </p>
		
		</div>
	
	<?php
	
	}
	
	?>
	
	</body>
</html>
