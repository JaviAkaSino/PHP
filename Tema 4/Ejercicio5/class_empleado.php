<?php

class Empleado
{

    private $nombre;
    private $sueldo;

    public function __construct($nombre_nuevo, $sueldo_nuevo)
    {
        $this->setNombre($nombre_nuevo);
        $this->setSueldo($sueldo_nuevo);
    }


    public function imprimir()
    {
        echo "<p><strong>Empleado: </strong>" . $this->getNombre() . "</p>";
        if ($this->sueldo > 3000)
            echo "<p>Debe pagar impuestos</p>";
        else
            echo "<p>No debe pagar impuestos</p>";
    }

    public function getNombre()
    {

        return $this->nombre;
    }

    public function getSueldo()
    {

        return $this->sueldo;
    }

    public function setNombre($nombre_nuevo)
    {

        $this->nombre = $nombre_nuevo;
    }

    public function setSueldo($sueldo_nuevo)
    {

        $this->sueldo = $sueldo_nuevo;
    }
}
