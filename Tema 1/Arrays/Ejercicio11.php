<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 11 - Javier Parodi</title>
</head>
<body>
	
	<h1>Juntar arrays con array_merge()</h1>
    <?php
        
        $animales=array("Lagartija", "Araña", "Perro", "Gato", "Ratón");
        $numeros=array("12", "34", "45", "52", "12");
        $varios=array("Sauce", "Pino", "Naranjo", "Chopo", "Perro", "34");
        
        $mix = array_merge($animales, $numeros, $varios);
        
        foreach ($mix as $i => $value){
        
        echo "<p>".$value."</p>";
        
        }
        
    ?>
</body>
</html>
