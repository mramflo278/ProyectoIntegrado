<?php 
require __DIR__ . '/vendor/autoload.php';
include './funciones/Funciones.php';
session_start();
if(isset($_SESSION['usuario'])){
    echo
    header('Location:adminTeacher.php');
}
$error=false;
if (isset($_POST['enviar'])) {

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
$range = 'USUARIOS!A:B';
//peticion a la api de google
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
//recoger los valores de lar espuesta en una variable
$values = $response->getValues();

$result=login($_POST['password'],$_POST['usuario'],$values);
if($result){
    $_SESSION['usuario']=$_POST['usuario'];
    header('Location:adminTeacher.php');
}else{
    $error=true;
}

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>login</title>
    <style>
        body{
            background-color: grey;
        }
    </style>
    <script>
     function showModalError() {
            Swal.fire({
                icon: 'error',
                title: 'Usuario o contraseña imcorrectos',
                showConfirmButton: false,
                timer: 2000
            });
        }
    </script>
</head>

<body>
    <div class="container">
        <?php if($error) echo '<script>showModalError();</script>' ?>
        <div class="row">
            <div class="col m-auto text-center">
                <img src="resources/img/login.png" alt="">
                <form action="" method="POST" >
            <div class="row mb-3">
                <div class="col-sm-12 ">
                    <input type="text" class="form-control" name="usuario" placeholder="Escriba aqui su nombre de usuario" id="inputEmail3">
                </div>
            </div>
            <div class="row mb-3 ">
                <div class="col-sm-12">
                    <input type="password"  name="password" placeholder="Escriba aqui su contraseña" class="form-control" id="inputPassword3">
                </div>
            </div>

            <button type="submit" class="btn btn-primary" name="enviar">Iniciar sesion</button>
        </form></div>
        </div>
        
    </div>
</body>

</html>