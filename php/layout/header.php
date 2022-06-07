<?php
require './php/layout/manejadorLayout.php';
require './php/seguridad/elPuertasYelCoyote.php';
session_start();
PuertasYcoyote::validadcionSesionIniciada();
PuertasYcoyote::seccionDesignada();
print_r($_SESSION);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="Author" content="Yehoshua Zuñiga">
    <link rel="stylesheet" href="./css/bootstrap_css/bootstrap.css">
    <link rel="stylesheet" href="./css/mi_estilo/misestilos.css">

    <title>titulo de pagina</title>

</head>

<body class="container-fluid">
    <input type="hidden" id="miEmpresa" name="<?php echo str_replace('_', ' ', $_SESSION['codSujeto']) ?>" value="<?php echo str_replace('_', ' ', $_SESSION['BBDD']) ?>">
    <header class="row  bg  bg-secondary">
        <div class="logo row 
            justify-content-md-between justify-content-center m-auto">


            <img src="./src/img/Logo_TV_2015.png" alt="logo" class="img-fluid col-12 col-md-2 logo-img " id="logo">
            <nav class="col-12  col-md-6 align-self-center ">
                <ul class="nav d-flex justify-content-md-end 
                             justify-content-center  flex-column
                             mt-3
                              flex-sm-row text-center">

                    <?php
                    ControladorMenus::menUsuario();
                    ?>
                </ul>
            </nav>
        </div>
        <nav class="row m-0">
            <div class="col-l2">
                <ul class="nav d-flex justify-content-sm-around
                             justify-content-center flex-column flex-sm-row
                             text-center 
                             mt-1">
                    <?php
                    ControladorMenus::menuCorrespontienteCargos();
                    ?>
                </ul>
            </div>
        </nav>
    </header>  
    