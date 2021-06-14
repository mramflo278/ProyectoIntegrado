<?php 

/**
 * 
 * clase donde se almacenan los datos de cada Departamento para su mejor procesamiento
 * 
 * 
 */

class Departament {
    private $nombre;
  
    
    function __construct($nombre="") 
    {
       $this->nombre=$nombre;
    }
    function __get($name)
    {
        return $this->$name;
    }
    function __set($name, $value)
    {
        $this->$name=$value;
    }
    function newDepartament($nombre="") 
    {
       $this->nombre=$nombre;
    }
 
}