<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 14 - Javier Parodi</title>
    <style>
    	table, th, td{border:1px solid black;border-collapse:collapse;padding:3px;text-align:center};
    </style>
</head>
<body>
	
	<h1>Estadios de fútbol</h1>
    <?php
        $estadios_futbol=array("Barcelona"=>"Camp Nou", "Real Madrid"=>"Santiago Bernabeu", "Valencia"=>"Mestalla", "Real Sociedad" => "Anoeta");
        
         
        
        ?>
        
        <table>
        
        	<tr><th colspan="2">Estadios</th></tr>
        	<tr>
        		<th>Equipo</th>
        		<th>Estadio</th>
        	</tr>
		<?php
		
		foreach ($estadios_futbol as $i => $name){
		
			echo "<tr><td>".$i."</td><td>".$name."</td></tr>";
		}
		
	    ?>
    	
    	</table>

        <h3>Borramos el estadio del Real Madrid</h3>

        <?php
            unset($estadios_futbol["Real Madrid"]);

            echo "<ul>";
            foreach ($estadios_futbol as $i => $name){

                echo "<li>".$i." - ".$name."</li>";
            }


        ?>
</body>
</html>
