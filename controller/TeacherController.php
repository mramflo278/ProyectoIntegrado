<?php
require_once './modelo/profesor.php';
/**
 * 
 * clase controller de departamento 
 * 
 * 
 */

class TeacherController
{


    static function getAll($service)
    {
        $spreadsheetId = '1PoW9yNjqTkjDBwTZWmQ0RzZocuZ5Z6dftO0FFvFupsM';
        // rango de columnas que se selecionaran
        $range = 'profesores!A2:H';
        //peticion a la api de google
        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        //recoger los valores de la respuesta en una variable
        $values = $response->getValues();
        $arrayTeacher = [];
        $teacher =  new Profesor();
        foreach ($values as $value) {
            $teacher->newProfesor($value[1], $value[2], $value[6], $value[7], $value[5], $value[4], $value[3]);
            $arrayTeacher[] = clone ($teacher);
        }
        return $arrayTeacher;
    }
    static function deleteTeacher($service)
    {
        $spreadsheetId = '1PoW9yNjqTkjDBwTZWmQ0RzZocuZ5Z6dftO0FFvFupsM';

        $requestBody = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest(array(
            'requests' => array(
                'deleteDimension' => array(
                    'range' => array(
                        'sheetId' => 1603471664, // id de la url  esta al final de la url en la  hoja de calculo 
                        'dimension' => "ROWS",
                        'startIndex' => $_POST['rowToDelete'], // numero de row que va a ser borrada
                        'endIndex' => $_POST['rowToDelete'] + 1
                    )
                )
            )
        ));
        $response = $service->spreadsheets->batchUpdate($spreadsheetId, $requestBody);
        return  true;
    }

    static function getEquipoDirectivo($service)
    {
        $profesores = TeacherController::getAll($service);
        $equipoDirectivo = [];
        foreach ($profesores as $value) {
            if ($value->cargo != '') {
                $equipoDirectivo[] = $value;
            }
        }
        return $equipoDirectivo;
    }
}
