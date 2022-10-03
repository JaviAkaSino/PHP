<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 16 - Javier Parodi</title>
    <style>
    	table, th, td{border:1px solid black;border-collapse:collapse;padding:3px;text-align:center};
    </style>
</head>
<body>
	
	<h1>Números</h1>
    <?php
        $numeros=array(5=>1,12=>2,13=>56,"x"=>42);
     
        ?>
        
        <table>
        
        	<tr><th>Numeros</th></tr>

		<?php
		
		foreach ($numeros as $i => $name){
		
			echo "<tr><td>".$i."</td><td>".$name."</td></tr>";
		}

        echo "</table>";

        unset($numeros[5]);
		
	    ?>

        <h3>Borramos la posición 5</h3>

        <table>
        
            <tr><th colspan="2">Numeros</th></tr>

        <?php
    
        foreach ($numeros as $i => $name){
    
            echo "<tr><td>".$i."</td><td>".$name."</td></tr>";
        }

        unset($numeros);
    	
        ?>

    	</table>
        



</body>
</html>
