<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 18 - Javier Parodi</title>
    <style>
    	table, th, td{border:1px solid black;border-collapse:collapse;padding:3px;text-align:center};
    </style>
</head>
<body>
	
	<h1>Deportes</h1>
    <?php
        $deportes=array("Fútbol", "Baloncesto", "Natación", "Tenis");
        
            sort($deportes);

            
        ?>
        
        <table>
        
        	<tr><th colspan="2">Deportes</th></tr>

		<?php
		
		foreach ($deportes as $i => $name){
		
			echo "<tr><td>".$name."</td></tr>";
		}
		
	    ?>
    	
    	</table>

        <h3>Total de valores</h3>

        <?php echo "<p>".count($deportes)."</p><p>";
        $i = 0;
        echo "Primera posicion: <br/>".$deportes[$i]."<br/>";
        echo "Siguiente posicion: <br/>".$deportes[++$i]."<br/>";
        $i = count($deportes)-1;
        echo "Última posicion: <br/>".$deportes[$i]."<br/>";
        echo "Última posicion: <br/>".$deportes[--$i]."</p>";
        
        ?>



</body>
</html>
