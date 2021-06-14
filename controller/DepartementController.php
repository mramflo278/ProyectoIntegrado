<?php
require_once './modelo/Departament.php';
/**
 * 
 * clase controller de departamento 
 * 
 * 
 */

class DepartamentController
{


    static function getAll($service)
    {
        //repetir las acciones anteriores en la hoja departementos
        $spreadsheetId = '1PoW9yNjqTkjDBwTZWmQ0RzZocuZ5Z6dftO0FFvFupsM';
        $rangeDepartament = 'Departamentos!A2:A';
        $responseDepartament = $service->spreadsheets_values->get($spreadsheetId, $rangeDepartament);
        $departamentos =  $responseDepartament->getValues();
        $arrayDepartamentos = [];
        $departament = new Departament();
        foreach ($departamentos as $value) {
            $departament->newDepartament($value[0]);
            $arrayDepartamentos[] = clone($departament);
        }
        return $arrayDepartamentos;
    }
}
