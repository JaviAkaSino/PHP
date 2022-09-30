<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 6 - Javier Parodi</title>
</head>
<body>
	
	<h1>Array ciudades</h1>
    <?php
        $ciudades=array("Madrid", "Barcelona", "Londres", "New York", "Los Ángeles", "Chicago");
        
        foreach ($ciudades as $i => $ciudad){
        
        	echo "<p>La ciudad con índice ".$i." tiene el nombre ".$ciudad.".</p>";
        }
        
    ?>
</body>
</html>
