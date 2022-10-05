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
			
			<form method="post" action="fecha3.php">
				<p>Introduzca una fecha:
                
                <input type="date" id="fecha1" name="fecha1" 
                    value="<?php if(isset($_POST['fecha1']))
                                    echo $_POST['fecha1'];
                                else
                                    echo date('Y-m-d');?>" 
                    min="<?php $menos50=date("Y")-50; echo $menos50."-".date("m-d"); ?>" 
                    max="<?php echo date("Y-m-d"); ?>"/>

                </p>



                <p>Introduzca otra fecha:

                <input type="date" id="fecha2" name="fecha2" 
                value="<?php if(isset($_POST['fecha2']))
                                    echo $_POST['fecha2'];
                                else
                                    echo date('Y-m-d');?>" 
                    min="<?php $menos50=date("Y")-50; echo $menos50."-".date("m-d"); ?>" 
                    max="<?php echo date("Y-m-d"); ?>"/>

                </p>

				<p>
				<button type="submit" name="boton_submit">Calcular</button>
				</p>

			</form>
		
		</div>
		<br/>

        <?php
        
            if (isset($_POST["boton_submit"])){

                $resultado_seg = mktime(0, 0, 0, substr($_POST["fecha1"], 5, 2), substr($_POST["fecha1"], 8, 2), substr($_POST["fecha1"], 0, 4)) 
                    - mktime(0, 0, 0, substr($_POST["fecha2"], 5, 2), substr($_POST["fecha2"], 8, 2), substr($_POST["fecha2"], 0, 4));
			    $resultado_dias = floor(abs($resultado_seg / (60*60*24)));

                echo "<div id='resultado'><h1>Fechas - Respuesta</h1>";
                echo "<p>La diferencia en días entre las dos fechas es de ".$resultado_dias."</p></div>";
            }
        ?>
	
    </body>
</html>
