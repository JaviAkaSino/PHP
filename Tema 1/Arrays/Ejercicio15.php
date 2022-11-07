<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 15 - Javier Parodi</title>
    <style>
    	table, th, td{border:1px solid black;border-collapse:collapse;padding:3px;text-align:center};
    </style>
</head>
<body>
	
	<h1>Números</h1>
    <?php
        $numeros=array(3,2,8,123,5,1);
        
            sort($numeros);

            
        ?>
        
        <table>
        
        	<tr><th colspan="2">Numeros</th></tr>

		<?php
		
		foreach ($numeros as $i => $name){
		
			echo "<tr><td>".$name."</td></tr>";
		}
		
	    ?>
    	
    	</table>

</body>
</html>
