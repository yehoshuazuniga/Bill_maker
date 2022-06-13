<?php
require_once __DIR__ . '/fpdf/plantillaFactura.php';
include __DIR__ . '/base_datos/accesoBD.php';
include __DIR__ . '/seguridad/elPuertasYelCoyote.php';
$conex = Funciones_en_BBDD::singleton();
$pdf = new FPDF();
session_start();
$seguridad = new PuertasYcoyote();
if (isset($_SESSION['BBDD']) && count($_SESSION) === 4) {
    $bd = $_SESSION['BBDD'];
    $conex = new Funciones_en_BBDD($bd);
    //$conex->consultaPrueba();
}
if (isset($_POST['accesousuario'])) {
    $datosEnt = (json_decode($_POST['accesousuario']));
    $usuario = $seguridad->filtrado($datosEnt->usuario_nick);
    $pass = $seguridad->filtrado($datosEnt->usuario_password);
    $datosSesiones = $conex->extraerDatos($usuario, $pass);

    if ($conex->verificarUsuario($usuario, $pass) && count($datosSesiones) > 1) {
        // echo'accede 1';
        //print_r($datosSesiones);
        $seguridad->tockenSession($datosSesiones[0], $datosSesiones[1]);
        if (count($_SESSION) === 4) {
            echo json_encode(true);
            // hay q eliminar a apartir de este else
        } /* else {
            echo count($_SESSION);
        }
    } else {
        echo 'no pasa el primer filtro'; */
    } else {
        echo json_encode(false);
    }
}


if (isset($_POST['nuevoUsuario'])) {
    $datosEnt = (json_decode($_POST['nuevoUsuario']));
    //priemro se busca en la base de datos de billmaker y ya exte ese cif, 
    //si existe se notifica al cliente y no se registra nada 
    //las operacones devuel an cliente y un boolean
    foreach ($datosEnt as $key => $value) {
        $datosEnt->$key = $seguridad->filtrado($value);
    }
    if ($conex->existeParametro('dni', 'dni', $datosEnt->dni)) {
        echo json_encode(['La empresa ya ha sido dada de alta', true]);
    } else {
        if ($conex->existeParametro('email', 'email', $datosEnt->email)) {
            echo json_encode(['Este mail ya ha sido usado', true]);
        } else {
            if ($conex->existeParametro('basedatos', 'basedatos', str_replace(' ', '_', ltrim($datosEnt->nombreEmpresa)))) {
                echo json_encode(['Este nombre de emperesa ya ha sido usado', true]);
            } else {
                // si en cif no exixte se recopila la informacion y se registarn en 
                //la tabla gerente y empelado de billmaker y la bbdd recien
                $conex->crearBDyTablas($datosEnt->nombreEmpresa);
                //eto registra los usuario en la bbdd de billmaker
                $creaTablasCliente = $conex->registrarGer_Emp($datosEnt);

                if (gettype($creaTablasCliente) == 'string' && $conex->registroTablaAcceso($datosEnt->usuarioGerente) && $conex->registroTablaAcceso($datosEnt->usuarioEmpleado)) {
                    $bdnname = str_replace(' ', '_', $datosEnt->nombreEmpresa);
                    $conex = null;
                    //  echo $bdnname;
                    $conex = new Funciones_en_BBDD($bdnname);
                    $seguridad->crearCarpetas($bdnname);
                    echo json_encode([($conex->registrarGer_Emp($datosEnt)), false]);
                }
            }
        }
    }
}


if (isset($_POST['cerrarSesion'])) {
    $resultSession = '';
    if ($resultSession = $seguridad->cerrarSesion()) {
        echo json_encode(['Sesion Cerrada, adios', $resultSession]);
    } else {
        echo json_encode(['Sesion no cerrada', $resultSession]);
    }
}

if (isset($_POST['compo']) && count($_SESSION) === 4) {
    echo json_encode($conex->consultaPrueba());
}

if (isset($_POST['proveedorProExt'])) {

    echo json_encode($conex->proveedoresProdExter());
}

if (isset($_POST['clientes'])) {
    echo json_encode($conex->datosLista_vista($_POST['clientes']));
}
if (isset($_POST['empleados'])) {
    echo json_encode($conex->datosLista_vista($_POST['empleados']));
}
if (isset($_POST['facturas'])) {
    echo json_encode($conex->datosLista_vista($_POST['facturas']));
}
if (isset($_POST['proveedores'])) {
    echo json_encode($conex->datosLista_vista($_POST['proveedores']));
}
if (isset($_POST['presupuestos'])) {
    echo json_encode($conex->datosLista_vista($_POST['presupuestos']));
}
if (isset($_POST['servicios'])) {
    echo json_encode($conex->datosLista_vista($_POST['servicios']));
}

if (isset($_POST['soicitarUnRegistro'])) {
    $datos = json_decode($_POST['soicitarUnRegistro']);

    echo json_encode($conex->devolverUnRegistro($datos[0], $datos[1]));
}

if (isset($_POST['registrar'])) {
    $packRegistro = json_decode($_POST['registrar']);
    $packRegistro = [$packRegistro[0], json_decode($packRegistro[1])];
    $respuesta = null;
    //var_dump($packRegistro);
    if ($packRegistro[0] === 'empleados') {
        $respuesta = $conex->seleccionarQueryRegistroPagina($packRegistro[0], $packRegistro[1]);
        if ($respuesta && gettype($respuesta) !== 'string') {
            // esto lo guar en el bbdd principal
            $conex = null;
            $conex = Funciones_en_BBDD::singleton();
            $respuesta = json_encode($conex->seleccionarQueryRegistroPagina($packRegistro[0], $packRegistro[1]));
            $conex->registroTablaAcceso($packRegistro[1]->usuario);
        } /* else {
            if (gettype($respuesta) === 'string') {
                $respuesta = 
            }
        } */
    } else {
        $respuesta = $conex->seleccionarQueryRegistroPagina($packRegistro[0], $packRegistro[1]);
        //  print_r($packRegistro[1][3]);


        //ESTO NO VALE HAY QUE QUITALO, NO HACE NADA
        if (gettype($respuesta) === 'array' && $respuesta[0] == true) {
            //echo 'hola';
            //  array_unshift($packRegistro,$respuesta[1], json_decode($packRegistro[1][3]));
            array_push($respuesta, json_decode($packRegistro[1][3]));
        }
        // var_dump($respuesta);
    }
    //  print_r($packRegistro);
    // var_dump($respuesta);
    //  echo gettype($respuesta[2]);
    if ($respuesta[0] && ($packRegistro[0] === 'presupuestos' || $packRegistro[0] === 'facturas')) {
        // print_r($respuesta);
        $cabeceraServ = ['Nombre', 'Descripcion', 'Precio'];
        // print_r($respuesta[2]);
        $aux = $respuesta[2];
        $nombrePDF = substr($_SESSION['codSujeto'], 0, 2) . '' . array_shift($aux);
        //construct($empresa, $cliente, $operacion, $operador)
        //print_r($respuesta[1]);
        // print_r($respuesta[2]['idFacturas']);

        $doc = ucfirst(substr($packRegistro[0], 0, strlen($packRegistro[0]) - 1));
        $pdf = new PDF($respuesta[3], $respuesta[4][0], $respuesta[2], $respuesta[1], $doc);
        $direc = "../clientes/" . $_SESSION['BBDD'] . "/" . $packRegistro[0] . "/" . $nombrePDF . ".pdf";
        $pdf->AliasNbPages();
        $pdf->AddPage('P', 'A4');
        $pdf->SetFont('Times', '', 12);
        $pdf->BasicTable($cabeceraServ, $respuesta[5]);
        $pdf->Output('F', $direc);
        $carpetasContenedoresPdf = $_SESSION['BBDD'] . '/' . $packRegistro[0];
        $respuesta = [$respuesta[0], $carpetasContenedoresPdf, $nombrePDF];
        //  var_dump($respuesta);
    } else {
        if ($packRegistro[0] === 'presupuestos' || $packRegistro[0] === 'facturas') {
            $respuesta = [false, 'Selecciona algun producto'];
        }
    }
    //var_dump($respuesta);
    echo json_encode($respuesta);
}
if (isset($_POST['existe_cliente'])) {
    //   echo $_POST['existe_cliente'];
    $datos = $conex->devolverUnRegistro('clientes', ($_POST['existe_cliente']));
    //  print_r($datos);
    echo json_encode($datos[0]);
}

if (isset($_POST['modificar'])) {
    $pack = json_decode($_POST['modificar']);
    $pagina = $seguridad->filtrado($pack[0]);
    $datos = $pack[1];
    $errores = [];
    foreach ($datos as $key => $value) {
        //   $datos->$key = $seguridad->filtrado($value);
        if ($key != 'dni') {
            //    nsertarDatos( $tabla, $indice, $valor, $valorDni , $indiceDni = 'dni', $tipoIndice = 'string'){
            $insert = $conex->insertarDatos($pagina, $key, $seguridad->filtrado($value), $datos->dni, gettype($value));
            if (!$insert) {
                $errores []= 'El ' . $key . ' no se ha insertado';
            }
        }
    }
    if (count($errores) > 0) {
        $respuesta = $errores;
    }

    echo json_encode($respuesta);
}
