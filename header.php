<nav class="navbar navbar-dark bg-dark navbar-expand-lg navbar-light bg-light">
            <div class="container">

                <a class="navbar-brand" href="#"><img src="resources/img/cropped-logo_header3.png" alt="" style="width: 100px; height: 40px;"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Organigrama</a>
                        </li>
                        <?php if(!isset($_SESSION['usuario'])){ ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">inicio Sesion</a>
                        </li>
                        <?php }else{ ?>
                            <li class="nav-item">
                            <a class="nav-link" href="adminTeacher.php">Listado Profesores</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="logout.php">cerrar Sesion</a>
                            </li>
                        <?php } ?>

                    </ul>
                    
                </div>
            </div>
        </nav>
      
        <div class="row" style="padding: 0px !important;">
            <div class="contenedor">
                <img src="resources/img/cropped-DSCN0785.jpg" alt="" style="height: 300px; width: 100%;">
                <h1 class="text-white "><div class="centrado bg-primary">Organigrama Profesorado</div></h1>
            </div>
        </div>