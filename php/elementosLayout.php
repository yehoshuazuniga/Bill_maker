<?php
include './elPuertasYelCoyote.php';

class Constructor extends PuertasYcoyote
{


    function header()
    {
        session_start();
        ?>
                <!DOCTYPE html>
                <html lang="en">

                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <meta name="Author" content="Yehoshua Zuñiga">
                    <link rel="stylesheet" href="./css/bootstrap.min.css">
                    <link rel="stylesheet" href="./css/misestilos.css">

                    <title>Clientes</title>

                </head>

                <body class="container-fluid">
                    <header class="row  bg  bg-secondary">
                        <div class="logo row 
                    justify-content-md-between justify-content-center m-auto">


                            <img src="./img/Logo_TV_2015.png" alt="logo" class="img-fluid col-12 col-md-2 logo-img bg-info">
                            <nav class="col-12  col-md-6 align-self-center bg-danger">
                                <ul class="nav d-flex justify-content-md-end 
                                    justify-content-center  flex-column
                                    flex-sm-row text-center">
                                    <li class="nav-link text-dark">rol1</dd>
                                    <li class="nav-link text-dark">Seting del roll</dd>
                                    <li class="nav-link text-dark">Cerrar secion</dd>
                                </ul>
                            </nav>
                        </div>
                        <nav class="row m-0">
                            <div class="col-l2">
                                <ul class="nav d-flex justify-content-sm-around
                                    justify-content-center flex-column flex-sm-row
                                    text-center ">
                                    <li><a class="link-dark" href="./inicio.html">inicio</a></li>
                                    <li><a class="link-dark" href="./empleados.html">Empleados</a></li>
                                    <li><a class="link-dark" href="./clientes.html">Clientes</a></li>
                                    <li><a class="link-dark" href="./proveedores.html">Proveedores</a></li>
                                    <li><a class="link-dark" href="./servicios.html">Servicios</a></li>
                                    <li><a class="link-dark" href="./facturas.html">Facturas</a></li>
                                    <li><a class="link-dark" href="./presupuestos.html">Presupuestos</a></li>
                                </ul>
                            </div>
                        </nav>
                    </header>

        <?php
    }
    function footer()
    {
    }
    function aside()
    {
    }


    function menuGerente()
    {
        ?>
            <li><a class="link-dark" href="./inicio.html">inicio</a></li>
            <li><a class="link-dark" href="./empleados.html">Empleados</a></li>
            <li><a class="link-dark" href="./proveedores.html">Proveedores</a></li>
            <li><a class="link-dark" href="./servicios.html">Servicios</a></li>
        <?php
    }

    function menuEmpleado()
    {
        ?>
            <li><a class="link-dark" href="./inicio.html">inicio</a></li>
            <li><a class="link-dark" href="./clientes.html">Clientes</a></li>
            <li><a class="link-dark" href="./facturas.html">Facturas</a></li>
            <li><a class="link-dark" href="./presupuestos.html">Presupuestos</a></li>
    <?php
    }

    function tablas($tablasDelServ)
    {
    }
}
