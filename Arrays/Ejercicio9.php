<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 9 - Javier Parodi</title>
    <style>
    	table, th, td{border:1px solid black;border-collapse:collapse;padding:3px;text-align:center};
    </style>
</head>
<body>
	
	<h1>Lenguajes</h1>
    <?php
        $lenguajes_cliente=array("LC1"=>"Cliente 1", "LC2"=>"Cliente 2", "LC3"=>"Cliente 3");
        $lenguajes_servidor=array("LS1"=>"Servidor 1", "LS2"=>"Servidor 2", "LS3"=>"Servidor 3");
        
        
        $lenguajes = $lenguajes_cliente;
        
        foreach ($lenguajes_servidor as $i => $name){
        
        	$lenguajes[$i]=$name;
        }
        
        ?>
        
        <table>
        
        	<tr><th colspan="2">Lenguajes</th></tr>
        	<tr>
        		<th>Índice</th>
        		<th>Nombre</th>
        	</tr>
		<?php
		
		foreach ($lenguajes as $i => $name){
		
			echo "<tr><td>".$i."</td><td>".$name."</td></tr>";
		}
		
	    ?>
    	
    	</table>
</body>
</html>
