<?php
require __DIR__ . '/vendor/autoload.php';
include './funciones/Funciones.php';

$nuevo= false;
if(isset($_GET['nuevo'])){
    $nuevo=true;
}
$editado= false;
if(isset($_GET['editado'])){
    $editado=true;
}
/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */

$client = new Google_Client();
$client->setApplicationName('Google Sheets API PHP Quickstart');
$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
$client->setAuthConfig(__DIR__ . '/credenciales.json');
$client->setAccessType('offline');
$client->setPrompt("select_account consent");



$service = new Google_Service_Sheets($client);

// recoger los datos de la hoja de calculo  tanto de los profesores como de los departamentos:
// https://docs.google.com/spreadsheets/d/1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms/edit
//ide de la hoja de calculo de google 
$spreadsheetId = '1PoW9yNjqTkjDBwTZWmQ0RzZocuZ5Z6dftO0FFvFupsM';
// rango de columnas que se selecionaran
$range = 'profesores!A1:E';

if (isset($_POST['delete'])) {




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
    $borrado = true;
}
if(isset($_POST['edit'])){
    $id = $_POST['rowToEdit'] + 1;
    header('Location: editTeacher.php?id='.$id);
}




//peticion a la api de google
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
//recoger los valores de la respuesta en una variable
$values = $response->getValues();





?>

<html>

<head>
    <title>maestros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js" integrity="sha384-lpyLfhYuitXl2zRZ5Bn2fqnhNAKOAaM/0Kr9laMspuaMiZfGmfwRNFh8HlMy49eQ" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function showModalDelete() {
            Swal.fire({
                icon: 'success',
                title: 'Profesor borrado con exito',
                showConfirmButton: false,
                timer: 2000
            });
        }
        function showModalNuevo() {
            Swal.fire({
                icon: 'success',
                title: 'Profesor creado con exito',
                showConfirmButton: false,
                timer: 2000
            });
        }
        function showModalEditado() {
            Swal.fire({
                icon: 'success',
                title: 'Profesor editado  con exito',
                showConfirmButton: false,
                timer: 2000
            });
        }
    </script>

</head>

<body>
    <?php if (isset($borrado) && $borrado) {
        echo '<script>showModalDelete();</script>';
    } 
    
        if($nuevo){
            echo '<script>showModalNuevo();</script>';
        }
        if($editado){
            echo '<script>showModalEditado();</script>';
        }
    ?>
    <div class="container">
        <table class="table table-dark table-hover text-center">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellidos</th>
                    <th scope="col">Foto</th>
                    <th scope="col">Departamentos</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    
                </tr>
            </thead>
            <tbody>
                <?php foreach ($values as $key => $value) { ?>
                    <?php if ($key != 0) { ?>
                        <tr>
                            <td><?php echo $value[1] ?></td>
                            <td><?php echo $value[2] ?></td>
                            <td><?php echo $value[3] ?></td>
                            <td><?php echo $value[4] ?></td>
                            <td>
                                <form action="" method="post"> <input type="hidden" name="rowToDelete" value="<?php echo $key ?>"> <input type="submit" name="delete" value="Borrar" class="btn btn-danger"></form>

                            </td>
                            <td>
                            <form action="" method="post"> <input type="hidden" name="rowToEdit" value="<?php echo $key ?>"> <input type="submit" name="edit" value="editar" class="btn btn-warning"></form>

                            </td>
                        </tr>
                <?php    }
                }
                ?>

            </tbody>
        </table>
    </div>
</body>

</html>