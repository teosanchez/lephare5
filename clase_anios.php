<?php
class anios

    {
    //Atributos de la tabla de la bd
    public $anio=null;
    public function cargar($arrayValores)
        {
        if(! is_array($arrayValores))
        {
        throw new Exception("Es necesario un array con los mismos campos que propiedades tiene el objeto");
        }
        isset($arrayValores[`anio`])?$this->anio=$arrayValores[`anio`]:$this->anio=null;
        }
    }
?>