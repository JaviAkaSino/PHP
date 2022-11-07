<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <h1>Teoría de fechas</h1>
    <?php
        //La función time da los segundos desde el 01/01/1970 (FB)
        $tiempo = time();
    
        echo $tiempo."<br/>";

        //La función date da un formato date("formato", segundos desde FB)
        $fecha = date("d/m/Y h:i:s", 12);

        echo $fecha."<br/>";

        //Sin pasar segundo parámetro, es la actual
        $fecha = date("D, d-M-Y h:i:s");

        echo $fecha."<br/>";

        //Cuánto tiempo ha pasado desde FB mktime(h, m, s, mes, día, año)
        $cumpl = mktime(0,0,0,9,16,1996);

        echo $cumpl."<br/>";

        //OJO porque se traga el mes
        $cumpl = mktime(0,0,0,21,16,1995);
        echo $cumpl."<br/>";

        //Si quiero ver si una fecha es verdadera checkdate (mes, día, año)

        if (checkdate(9,16,1996))
            echo "La fecha es correcta<br/>";
        else 
            echo "La fecha es incorrecta<br/>";

        //Si le doy un string que es una fecha, me lo pasa a segundos strtotime("año, mes, día") ó strtotime("mes, día, año")

        echo strtotime("1996/9/16")."<br/>";
        echo strtotime("9/16/1996")."<br/>";

        //Redondea hacia abajo

        echo floor(5.6)."<br/>";

        //Redondea hacia arriba

        echo ceil(5.1)."<br/>";

        //Valor absoluto

        echo abs(-5)."<br/>";


    ?>
</body>
</html>