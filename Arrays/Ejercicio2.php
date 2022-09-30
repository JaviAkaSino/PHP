<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 2 - Javier Parodi</title>
</head>
<body>
	
	<h1>Imprimir array asociativo con foreach</h1>
    <?php
        $v[1]=90;
        $v[30]=7;
        $v['e']=99;
        $v['hola']=43;
        
        foreach($v as $i => $value){
        
        echo "EL valor de ".$i." es ".$value."<br/>";
        }
        
    ?>
</body>
</html>
