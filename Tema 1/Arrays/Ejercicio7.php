<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 7 - Javier Parodi</title>
</head>
<body>
	
	<h1>Array ciudades indice</h1>
    <?php
        $ciudades["MD"]="Madrid";
        $ciudades["BCN"]="Barcelona";
        $ciudades["LON"]="Londres";
        $ciudades["NY"]="New York";
        $ciudades["LA"]="Los Ángeles";
        $ciudades["CHI"]="Chicago";
        
        foreach ($ciudades as $i => $ciudad){
        
        	echo "<p>El indice del array que contiene como valor ".$ciudad." es ".$i.".</p>";
        }
        
    ?>
</body>
</html>
