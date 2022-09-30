<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 8 - Javier Parodi</title>
</head>
<body>
	
	<h1>Array nombres</h1>
    <?php
        $nombres=array("Pedro", "Ismael", "Sonia", "Clara", "Susana", "Alfonso", "Teresa");
        
        echo "Número de elementos: ".count($nombres)."<br/><ul>";
        
        
        foreach ($nombres as $i => $name){
        
        	echo "<li>".$name."</li>";
        }
        
        echo "</ul>"
        
    ?>
</body>
</html>
