<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 3 - Javier Parodi</title>
</head>
<body>
	
	<h1>Imprimir array asociativo con foreach</h1>
    <?php
        $meses_pelis["enero"]=9;
        $meses_pelis["febrero"]=12;
        $meses_pelis["marzo"]=0;
        $meses_pelis["abril"]=17;
        
        foreach($meses_pelis as $mes => $pelis){
        
        if ($pelis != 0) echo "En ".$mes." se han visto ".$pelis."<br/>";

        }
        
    ?>
</body>
</html>
