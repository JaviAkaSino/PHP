<?php

    function solo_numeros($texto){

        $solo_num = true;
        //Eliminamos las comas para que no las detecte como no-numérico
        $texto = str_replace(",", "", trim($texto));

        $array_numeros = explode(" ", $texto); // Pasamos a array

        for ($i=0; $i < count($array_numeros); $i++){
            
            if (!is_numeric($array_numeros[$i])){

                $solo_num = false;
                break;
            }              

        }

        return $solo_num;

    }

    if (isset($_POST["boton_submit"])){


        $error = $_POST["entrada"] == "" || !solo_numeros(trim($_POST["entrada"]));


    }

?>


<!DOCTYPE html>
<html>
	<head>
		<title>Unifica separador decimal</title>
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
		<h2>Unifica separador decimal - Formulario</h2>
		
		<p>Escribe varios números separados por espacios y unificaré el separador de decimal a puntos</p>
		
		<form method="post" action="string7.php">
		
			<p><label for="entrada">Números: </label>
			<input type="text" id="entrada" name="entrada" value="<?php if (isset($_POST["entrada"])) echo $_POST["entrada"];?>"/>
			
			<?php 
			if (isset($_POST["entrada"]) && $error){

                if ($_POST["entrada"]=="")
                    echo "<span class='error'> * Campo vacío</span>";
                else   
                    echo "<span class='error'> * Introduce sólo valores numéricos</span>";
			
            }
            
            ?>
            </p>
		
			<button type="submit" name="boton_submit">Convertir</button>
		
		</form>
		</div>
		
	<?php
		if(isset($_POST["boton_submit"]) && !$error){

		$original = $_POST["entrada"];
        $corregido = str_replace(",", ".", $_POST["entrada"]);
		
	?>
	
		<div id="div_res">
			<h2>Unifica separador decimal - Resultado</h2>

            <p>
                
            <dl>
                <dt>Números originales:</dt>
                <dd><?php echo $original ?></dd>
                

                <dt>Números corregidos:</dt>
                <dd><?php echo $corregido ?></dd>
                

            </dl>
            </p>
		
		</div>
	
	<?php
	
	}
	
	?>
	
	</body>
</html>
