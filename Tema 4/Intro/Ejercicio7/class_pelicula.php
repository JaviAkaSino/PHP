<?php

class Pelicula
{

    private $nombre;
    private $anio;
    private $director;
    private $precio;
    private $alquilada;
    private $fecha;

    private static $contador=0;
    const RECARGO_DIA = 1.2;

    public function __construct($nombre, $anio, $director, $precio, $alquilada, $fecha)
    {
        $this->setNombre($nombre);
        $this->setAnio($anio);
        $this->setDirector($director);
        $this->setPrecio($precio);
        $this->setAlquilada($alquilada);
        $this->setFecha($fecha);
        self::$contador++;
    }

    //IMPRIMIR
    public function imprimir(){

        echo "<h2>Película ".self::$contador."</h2>";
        echo "<p><strong>Título: </strong>".$this->getNombre()."</p>";
        echo "<p><strong>Director: </strong>".$this->getDirector()."</p>"; 
        echo "<p><strong>Año: </strong>".$this->getAnio()."</p>"; 
        echo "<p><strong>Precio de alquiler: </strong>".$this->getPrecio()." €</p>"; 
        
        if($this->getAlquilada()){
            echo "<p><strong>Alquilada</strong></p>";
            echo "<p><strong>Fecha de devolución: </strong>".date("d/m/Y", strtotime($this->getFecha()))."</p>";
        } else {
            echo "<p><strong>Disponible</strong></p>";
        }
    }

    //RECARGO
    public function recargo()
    {
        $recargo = 0; //Parte de que no haya recargo
        //Calcula diferencia en seg entre la fecha actual y la de devolución
        $diferencia_seg = strtotime(date('Y/m/d')) - strtotime($this->fecha);

        //Si es positiva, calcula días al alza y multiplica por el recargo diario
        if ($diferencia_seg > 0) {
            $dias = ceil($diferencia_seg / 86400);
            $recargo = $dias * self::RECARGO_DIA;
        }

        return $recargo;
    }



    //GETTERS & SETTERS

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getAnio()
    {
        return $this->anio;
    }

    public function setAnio($anio)
    {
        $this->anio = $anio;
    }

    public function getDirector()
    {
        return $this->director;
    }

    public function setDirector($director)
    {
        $this->director = $director;

        return $this;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }

    public function getAlquilada()
    {
        return $this->alquilada;
    }

    public function setAlquilada($alquilada)
    {
        $this->alquilada = $alquilada;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }
}
