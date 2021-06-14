<?php
require __DIR__ . '/vendor/autoload.php';
include './funciones/Funciones.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location:login.php');
}



    $client = new Google_Client();
    $client->setApplicationName('Google Sheets API PHP Quickstart');
    $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
    $client->setAuthConfig(__DIR__.'/credenciales.json');
    $client->setAccessType('offline');
    $client->setPrompt("select_account consent");

  

$service = new Google_Service_Sheets($client);

// recoger los datos de la hoja de calculo  tanto de los profesores como de los departamentos:
// https://docs.google.com/spreadsheets/d/1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms/edit
$spreadsheetId = '1PoW9yNjqTkjDBwTZWmQ0RzZocuZ5Z6dftO0FFvFupsM';
// rango de columnas que selecionamos
$rangeDepartament= 'Departamentos!A2:A';
//peticion a la api de google
$responseDepartament = $service->spreadsheets_values->get($spreadsheetId, $rangeDepartament);
//recogemos los valores de la respuesta de departamentos en una variable
$departamentos =  $responseDepartament->getValues();
$range = 'Profesores';


if(isset($_POST['Guardar'])){

if (isset( $_FILES['foto'])){
   $secondClien = new Google_Client();
   $secondClien->setApplicationName('Google Sheets API PHP Quickstart');
   $secondClien->setScopes(['https://www.googleapis.com/auth/drive.file']);
   $secondClien->setAuthConfig(__DIR__.'/credenciales.json');
   $secondClien->setAccessType('offline');
   $secondClien->setPrompt("select_account consent");
   $serviceDrive =  new Google_Service_Drive($secondClien);
   try {
       $file= new Google_Service_Drive_DriveFile();
       $file->setName('foto_'.$_POST['nombre'].$_POST['apellidos']);
       $file->setParents(array('14m2PgewQXEH81RP4K3LxHlFjmAiAsqFd7sPcaqXJVGKfnEuGc7IKd99wdQkXRi0EFpWd--th'));
       $file->setDescription('foto del PRofesor'.$_POST['nombre'].$_POST['apellidos']);
       $file->setMimeType($_FILES['foto']['type']);
       if(is_uploaded_file($_FILES['foto']['tmp_name'])){

       $result= $serviceDrive->files->create(
            $file,
            array(
                    'data' =>  file_get_contents($_FILES['foto']['tmp_name']),
                    'mimeType' => $file->getMimeType(),
                    'uploadType' => 'media'
            )
       );

    }
       echo '<a href="https://drive.google.com/open?id='.$result->id.'" >'.$result->name.'</a>';
       } catch (Google_Service_Exception $gs) {
        $mensaje = json_decode(($gs->getMessage()));
        print_r( $mensaje->error->message);
   }
   
}

$values = [
    [date(time()),
    $_POST['nombre'],
    $_POST['apellidos'],
    'https://drive.google.com/open?id='.$result->id,
    $_POST['departamentos'],
    $_POST['cargo'],
    $_POST['mail'],
    $_POST['telefono']
    ],
];
$body =  new Google_Service_Sheets_ValueRange([
    'values' => $values
]);
$insert = [
    'instertDataOption' => "INSERT_ROWS"
];
$params = [
    'valueInputOption' => 'RAW'
];
$result = $service->spreadsheets_values->append(
    $spreadsheetId,$range,$body,$params,$insert
);
header("Location: teachers.php?nuevo=true");
}
?>
<html>
    <head>
        <title>Nuevo Profesor</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
       <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
       <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
       <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js" integrity="sha384-lpyLfhYuitXl2zRZ5Bn2fqnhNAKOAaM/0Kr9laMspuaMiZfGmfwRNFh8HlMy49eQ" crossorigin="anonymous"></script>
       <link rel="stylesheet" type="text/css" href="resources/css/style.css" media="screen" />
    </head>
    <body>
    <div class="container">
    <?php include('header.php') ?>
        <div class="row">
            <div class="col text-center">
                <h2>Crear Profesor</h2>
            </div>
        </div>
        <form action="" method="post" class="form-group" enctype='multipart/form-data'>
            <label>Nombre: </label> <input type="text" name="nombre" class="form-control">
            <label>Apellidos: </label> <input type="text" name="apellidos" class="form-control">
            <label>Foto: </label> <input type="file" name="foto" class="form-control">
            <label>Departamentos: </label>
            <select name="departamentos"class="form-select">
               <?php foreach ($departamentos as $value) { ?>
                <option value="<?php echo $value[0] ?>"><?php echo $value[0] ?></option>
               <?php } ?>
            </select>
            <label>Cargo: </label> <input type="text" name="cargo"  class="form-control">
            <label>email: </label> <input type="email" name="mail"  class="form-control">
            <label>telefono: </label> <input type="tel" name="telefono"  class="form-control">
            <input type="submit" name="Guardar" class="btn btn-success">
        </form>
    </div>
    </body>
</html>
