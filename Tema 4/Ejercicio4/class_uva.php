<?php

require_once "class_fruta.php";

class Uva extends Fruta
{

    private $tieneSemilla;

    public function __construct($color_nuevo, $tamanio_nuevo, $tiene_semilla)
    {
        parent::__construct($color_nuevo, $tamanio_nuevo);
        $this->tieneSemilla = $tiene_semilla;
    }

    public function imprimir()
    {
        parent::imprimir();
        if ($this->tieneSemilla())
            echo "<p>Tiene semillas</p>";
        else
            echo "<p>No tiene semillas</p>";
    }

    public function tieneSemilla()
    {
        return $this->tieneSemilla;
    }
}
