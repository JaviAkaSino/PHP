<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 13 - Javier Parodi</title>
</head>
<body>
	
	<h1>Mostrar en orden inverso</h1>
    <?php
        
        $animales=array("Lagartija", "Araña", "Perro", "Gato", "Ratón");
        $numeros=array("12", "34", "45", "52", "12");
        $varios=array("Sauce", "Pino", "Naranjo", "Chopo", "Perro", "34");
        
        $mix = array_merge($animales, $numeros, $varios);
        //Reverse / Next prev
        for($j=count($mix)-1;$j>=0;$j--){
 
        echo "<p>".$mix[$j]."</p>";
        
        }
        
    ?>
</body>
</html>
