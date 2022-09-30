<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 10 - Javier Parodi</title>
</head>
<body>
	
	<h1>Enteros</h1>
    <?php
        const LONG = 10;
        $naturales;
        
        for($i=1;$i<=LONG;$i++){
        
        	$naturales[]=$i;
        }
        
        $sumatorio=0;
        $posiciones_pares=0;
        
        for($j=0;$j<=count($naturales);$j+=2){
        
        	
        	$sumatorio += $naturales[$j];
        	$posiciones_pares++;
        }
        
        echo "<p>La media de las posiciones pares es ".$posiciones_pares."</p>";
        
        echo"<p>Los números en posicion impar son: <br/>";
        
        for($k=1;$k<=count($naturales);$k+=2){
        
        	echo $k." ";
        	
        }
        
    ?>
</body>
</html>
