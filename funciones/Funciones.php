<?php
/**
 * 
 * fichero donde se almacenan las funciones del proyecto
 * 
 */

 //funcion que pasadole el array de maestros y el departamento 
 //nos devuelve todos los profesores de dicho departamento
function GetAllProfessorByDepartament($array, $departamento){
    $result = false;
    foreach  ($array as  $profesor) {
        if($profesor->departamento == $departamento){
            $result[]=$profesor;
        }
    }
    
    return $result;
}
//funcion a la que se le pasa el string de la imagen 
//para que nos devuelva la cadena adecuada para insertarla en una etiqueta img
function getSRCImageFromTeacher($row){
    $urlDrive="http://drive.google.com/uc?export=view&id=";
    $url =  preg_split("/id=/",$row);
    
    if (!isset($url[1]) ) {
        return false ;
    }else{
         $url = $urlDrive . $url[1];
        return $url; 
    }
    
}

function login($password,$user , $values){
    $result = false;
    foreach ($values as  $value) {
        if($value[0] == $user && $value[1] == $password){
            $result= true;
        }
    }
    return $result;
}