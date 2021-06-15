<?php
require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/modelo/Departament.php';
require_once __DIR__ . '/modelo/profesor.php';
require_once __DIR__ . '/controller/DepartementController.php';
require_once __DIR__ . '/controller/TeacherController.php';
session_start();
include './funciones/Funciones.php';
include './config/config.php';



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
$range = 'profesores!A2:H';
//peticion a la api de google
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
//recoger los valores de la respuesta en una variable
$values = $response->getValues();

$arrayDepartamentos = DepartamentController::getAll($service);


?>

<html>

<head>
    <title>Maestros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="resources/css/style.css" media="screen" />
</head>

<body>
    <div class="container">

        <?php include('header.php') ?>
        <div class="row">
            <div class="col text-center mt-5 mb-5 ">
            

                <h3 class="text-dark" style="background-color: white; padding: 5px; border-radius: 10px;"><img src="resources/pictograms/svg/002-teachers.svg" style="width: 50px; height: 50px;" alt="">Equipo directivo<img src="resources/pictograms/svg/002-teachers.svg" style="width: 50px; height: 50px;" alt=""></h3>
                

            </div>
        </div>
        <div class="row">
            <div class="col col-sm-12  ">
                <div class="row">
                    <?php foreach (TeacherController::getEquipoDirectivo($service) as $profesor) {
                        $imagen = getSRCImageFromTeacher($profesor->imagen);
                    ?>
                        <div class="col-12 col-md-4 col-lg-3 text-center">
                            <div class="divTeacher">
                                <div class=row>
                                    <div class="col">
                                        <?php if ($imagen != false && $IMAGEN) { ?>
                                            <img src="<?php echo $imagen  ?>"  class="imagenProfesor" alt="">
                                        <?php } ?>
                                        <p><?php if ($NOMBRE) {
                                                echo $profesor->nombre . ' ';
                                            }
                                            if ($APELLIDOS) {
                                                echo $profesor->apellidos;
                                            } ?></p>
                                        <p><?php if ($MAIL) {
                                                echo $profesor->mail;
                                            } ?></p>
                                        <p><?php if ($TELEFONO) {
                                                echo $profesor->telefono;
                                            } ?></p>
                                        <p><?php if ($CARGO) {
                                                echo $profesor->cargo;
                                            } ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php  } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col text-center mt-5 mb-5 ">
            <h3 class="text-dark" style="background-color: white; padding: 5px; border-radius: 10px;">Departamentos</h3>
        </div>
    </div>
    <div class="row">

        <?php foreach ($arrayDepartamentos as $value) { ?>

            <div class="col col-sm-12 col-md-6 col-lg-4">

                <div class="departamento">
                    <img src="resources/pictograms/svg/010-writing.svg" style="width: 50px; height: 50px;" alt="">
                    <h5><?php echo $value->nombre ?></h5>

                    <?php
                    $arrayProfesores = GetAllProfessorByDepartament(TeacherController::getAll($service), $value->nombre);

                    if ($arrayProfesores != false) { ?>
                        <ul class="list-group">
                            <?php foreach ($arrayProfesores as $profesor) {

                            ?>

                                <li class="list-group-item"> <?php echo ($profesor->nombre . ' ' . $profesor->apellidos) ?></li>


                            <?php
                            } ?>
                        </ul>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-danger mt-5" data-bs-toggle="modal" data-bs-target="#<?php echo str_replace(' ', '', $value->nombre); ?>">
                            + info Profesores
                        </button>
                    <?php

                    } else {
                        echo ' <P>en este departamento no existen profesores</P> ';
                    }
                    ?>



                </div>
            </div>
            <!-- Modal -->
            <div class="modal  fade  " id="<?php echo str_replace(' ', '', $value->nombre); ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="<?php echo str_replace(' ', '', $value->nombre); ?>" aria-hidden="true">
                <div class="modal-dialog modal-lg   modal-dialog-centered ">
                    <div class="modal-content bg-dark text-white">
                        <div class="modal-header">
                            <h5 class="modal-title" id="<?php echo str_replace(' ', '', $value->nombre); ?>"><?php echo $value->nombre ?></h5>
                            <button type="button " class=" btn text-white  " data-bs-dismiss="modal" aria-label="Close">X</button>
                        </div>
                        <div class="modal-body ">
                            <div class="row">
                                <?php if ($arrayProfesores != false) { ?>
                                    <?php foreach ($arrayProfesores as $profesor) {
                                        $imagen = getSRCImageFromTeacher($profesor->imagen);
                                    ?>
                                        <div class="col-12 col-md-4 col-lg-3 text-center">
                                            <div class="divTeacher">
                                                <div class=row>
                                                    <div class="col">
                                                        <?php if ($imagen != false && $IMAGEN) { ?>
                                                            <img src="<?php echo $imagen  ?>" class="imagenProfesor" alt="">
                                                        <?php } ?>
                                                        <p><?php if ($NOMBRE) {
                                                                echo $profesor->nombre . ' ';
                                                            }
                                                            if ($APELLIDOS) {
                                                                echo $profesor->apellidos;
                                                            } ?></p>
                                                        <p><?php if ($MAIL) {
                                                                echo $profesor->mail;
                                                            } ?></p>
                                                        <p><?php if ($TELEFONO) {
                                                                echo $profesor->telefono;
                                                            } ?></p>
                                                        <p><?php if ($CARGO) {
                                                                echo $profesor->cargo;
                                                            } ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php }
                                } ?>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php  } ?>
    </div>
    <?php include('footer.php') ?>

    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
<script src="resources/js/scroll.js"></script>

</html>