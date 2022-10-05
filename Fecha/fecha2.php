<?php
	
	//Cuando se pulsa submit, se comprueban los input
	if (isset($_POST["boton_submit"])){

        $error_fecha1 = !checkdate($_POST["mes1"], $_POST["dia1"], $_POST["anio1"]);
        $error_fecha2 = !checkdate($_POST["mes2"], $_POST["dia2"], $_POST["anio2"]);

        $error_form = $error_fecha1 || $error_fecha2;
	}

	
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8"/>
        <title>Fechas 2 - Javier Parodi Piñero</title>
        <style>
        	div{border:2px solid black;}
        	#entrada{background:lightblue;}
        	#resultado{background:lightgreen;}
        	h1{text-align:center}
        </style>
    </head>

    <body>
		<div id="entrada">
			<h1>Fechas - Formulario</h1>
			
			<form method="post" action="fecha2.php">
				<p>Introduzca una fecha:</p>

				<p>
                <label for="dia1">Día: </label>
                <select id="dia1" name="dia1">
                    <?php for ($i=1;$i<=31;$i++) {

                        echo "<option value='".$i."'";
                        if(isset($_POST["dia1"]) && $_POST["dia1"]==$i) echo " selected";
                        echo ">".$i."</option>" ;
                
                    }?>
                </select>

				<label for="mes1">Mes: </label>
                <select id="mes1" name="mes1">
                    <option value="01" <?php if(isset($_POST["mes1"]) && $_POST["mes1"]=="01") echo "selected"; ?>>Enero</option> 
                    <option value="02" <?php if(isset($_POST["mes1"]) && $_POST["mes1"]=="02") echo "selected"; ?>>Febrero</option> 
                    <option value="03" <?php if(isset($_POST["mes1"]) && $_POST["mes1"]=="03") echo "selected"; ?>>Marzo</option> 
                    <option value="04" <?php if(isset($_POST["mes1"]) && $_POST["mes1"]=="04") echo "selected"; ?>>Abril</option> 
                    <option value="05" <?php if(isset($_POST["mes1"]) && $_POST["mes1"]=="05") echo "selected"; ?>>Mayo</option> 
                    <option value="06" <?php if(isset($_POST["mes1"]) && $_POST["mes1"]=="06") echo "selected"; ?>>Junio</option> 
                    <option value="07" <?php if(isset($_POST["mes1"]) && $_POST["mes1"]=="07") echo "selected"; ?>>Julio</option> 
                    <option value="08" <?php if(isset($_POST["mes1"]) && $_POST["mes1"]=="08") echo "selected"; ?>>Agosto</option> 
                    <option value="09" <?php if(isset($_POST["mes1"]) && $_POST["mes1"]=="09") echo "selected"; ?>>Septiembre</option> 
                    <option value="10" <?php if(isset($_POST["mes1"]) && $_POST["mes1"]=="10") echo "selected"; ?>>Octubre</option> 
                    <option value="11" <?php if(isset($_POST["mes1"]) && $_POST["mes1"]=="11") echo "selected"; ?>>Noviembre</option> 
                    <option value="12" <?php if(isset($_POST["mes1"]) && $_POST["mes1"]=="12") echo "selected"; ?>>Diciembre</option> 
                </select>

                <label for="anio1">Año: </label>
                <select id="anio1" name="anio1">
                    <?php for ($i=0;$i<=50;$i++){
                        $valor = (date("Y") - $i);

                        echo "<option value='".$valor."'";
                        if (isset($_POST["anio1"]) && $_POST["anio1"]==$valor) echo " selected";
                        echo ">".$valor."</option>";
                    }?> 

                </select>

                <?php 
                    if(isset($_POST["boton_submit"])){

                        if ($error_fecha1)
                            echo " * Fecha no válida";
                    }    
                ?>
                </p>



                <p>Introduzca otra fecha:</p>

				<p>
                <label for="dia2">Día: </label>

                <select id="dia2" name="dia2">
                    <?php for ($i=1;$i<=31;$i++) {

                        echo "<option value='".$i."'";
                        if(isset($_POST["dia2"]) && $_POST["dia2"]==$i) echo " selected";
                        echo ">".$i."</option>" ;
                    }?>
                </select>
                

				<label for="mes2">Mes: </label>
                <select id="mes2" name="mes2">
                    <option value="01" <?php if(isset($_POST["mes2"]) && $_POST["mes2"]=="01") echo "selected"; ?>>Enero</option> 
                    <option value="02" <?php if(isset($_POST["mes2"]) && $_POST["mes2"]=="02") echo "selected"; ?>>Febrero</option> 
                    <option value="03" <?php if(isset($_POST["mes2"]) && $_POST["mes2"]=="03") echo "selected"; ?>>Marzo</option> 
                    <option value="04" <?php if(isset($_POST["mes2"]) && $_POST["mes2"]=="04") echo "selected"; ?>>Abril</option> 
                    <option value="05" <?php if(isset($_POST["mes2"]) && $_POST["mes2"]=="05") echo "selected"; ?>>Mayo</option> 
                    <option value="06" <?php if(isset($_POST["mes2"]) && $_POST["mes2"]=="06") echo "selected"; ?>>Junio</option> 
                    <option value="07" <?php if(isset($_POST["mes2"]) && $_POST["mes2"]=="07") echo "selected"; ?>>Julio</option> 
                    <option value="08" <?php if(isset($_POST["mes2"]) && $_POST["mes2"]=="08") echo "selected"; ?>>Agosto</option> 
                    <option value="09" <?php if(isset($_POST["mes2"]) && $_POST["mes2"]=="09") echo "selected"; ?>>Septiembre</option> 
                    <option value="10" <?php if(isset($_POST["mes2"]) && $_POST["mes2"]=="10") echo "selected"; ?>>Octubre</option> 
                    <option value="11" <?php if(isset($_POST["mes2"]) && $_POST["mes2"]=="11") echo "selected"; ?>>Noviembre</option> 
                    <option value="12" <?php if(isset($_POST["mes2"]) && $_POST["mes2"]=="12") echo "selected"; ?>>Diciembre</option> 
                </select>

                <label for="anio2">Año: </label>

                <select id="anio2" name="anio2">
                    <?php for ($i=0;$i<=50;$i++){
                        $valor = (date("Y") - $i);

                        echo "<option value='".$valor."'";
                        if (isset($_POST["anio2"]) && $_POST["anio2"]==$valor) echo " selected";
                        echo ">".$valor."</option>";
                    }?>  
                </select>

                <?php 
                    if(isset($_POST["boton_submit"])){

                        if ($error_fecha2)
                            echo " * Fecha no válida";
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
            if (isset($_POST["boton_submit"]) && !$error_form){

                $resultado_seg = mktime(0,0,0,$_POST["mes1"], $_POST["dia1"], $_POST["anio1"]) - mktime(0,0,0,$_POST["mes2"], $_POST["dia2"], $_POST["anio2"]);
			    $resultado_dias = floor(abs($resultado_seg / (60*60*24)));

                echo "<div id='resultado'><h1>Fechas - Respuesta</h1>";
                echo "<p>La diferencia en días entre las dos fechas es de ".$resultado_dias."</p></div>";


            }
        ?>
	
    </body>
</html>
