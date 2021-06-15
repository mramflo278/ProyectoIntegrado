<?php 

/**
 * 
 * clase donde se almacenan los datos de cada profesor para su mejor procesamiento
 * 
 * 
 */

class Profesor {
    private $nombre;
    private $apellidos;
    private $mail;
    private $telefono;
    private $cargo;
    private $departamento;
    private $imagen;
    
    function __construct($nombre="",$apellidos="",$mail="",$telefono="",$cargo="",$departamento=null,$imagen="") 
    {
       $this->nombre=$nombre;
       $this->apellidos=$apellidos;
       $this->mail=$mail;
       $this->telefono=$telefono;
       $this->cargo=$cargo;
       $this->departamento=$departamento;
       $this->imagen=$imagen;
       
    }
    function __get($name)
    {
        return $this->$name;
    }
    function __set($name, $value)
    {
        $this->$name=$value;
    }
    function newProfesor($nombre="",$apellido="",$mail="",$telefono="",$cargo="",$departamento=null,$imagen="")
    {
        $this->nombre=$nombre;
        $this->apellidos=$apellido;
        $this->mail=$mail;
        $this->telefono=$telefono;
        $this->cargo=$cargo;
        $this->departamento=$departamento;
        $this->imagen=$imagen;
        
    }
 
}