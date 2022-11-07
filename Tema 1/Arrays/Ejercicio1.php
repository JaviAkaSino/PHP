<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 1 - Javier Parodi</title>
</head>
<body>
	
	<h1>Numeros pares</h1>
    <?php
        $array;
        define("NUMERO", 10);

        for($i=0;$i<NUMERO;$i++){

        $array[$i]=2*(1+$i);
        
        echo $array[$i]."<br/>";

        }
    ?>
</body>
</html>
