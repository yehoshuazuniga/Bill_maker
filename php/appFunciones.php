<?php
require_once __DIR__.'/fpdf/plantillaFactura.php';
include __DIR__ . '/base_datos/accesoBD.php';
include __DIR__ . '/seguridad/elPuertasYelCoyote.php';
$conex = Funciones_en_BBDD::singleton();
$pdf = new FPDF();
session_start();
if (isset($_SESSION['BBDD']) && count($_SESSION) === 4) {
    $bd = $_SESSION['BBDD'];
    $conex = new Funciones_en_BBDD($bd);
    //$conex->consultaPrueba();
}

$seguridad = new PuertasYcoyote();

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
    if ($conex->existeParametro('dni', 'dni', $seguridad->filtrado($datosEnt->usuario_cif))) {
        echo json_encode(['La empresa ya ha sido dada de alta', true]);
    } else {
        // si en cif no exixte se recopila la informacion y se registarn en 
        //la tabla gerente y empelado de billmaker y la bbdd recien
        $conex->crearBDyTablas($seguridad->filtrado($datosEnt->usuario_nick_registro));
        //eto registra los usuario en la bbdd de billmaker
        $creaTablasCliente = $conex->registrarGer_Emp($datosEnt);
          
        if (gettype($creaTablasCliente) == 'string' && $conex->registroTablaAcceso($datosEnt->usuarioGerente) && $conex->registroTablaAcceso($datosEnt->usuarioEmpleado)) {
            $bdnname = str_replace(' ', '_', $seguridad->filtrado($datosEnt->usuario_nick_registro));
            $conex = null;
            $conex = new Funciones_en_BBDD($bdnname);
            echo json_encode([($conex->registrarGer_Emp($datosEnt)), false]);
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
            $conex = null;
            $conex = Funciones_en_BBDD::singleton();
            $respuesta = json_encode($conex->seleccionarQueryRegistroPagina($packRegistro[0], $packRegistro[1]));
            $conex->registroTablaAcceso($packRegistro[1]->usuario);
        } /* else {
            if (gettype($respuesta) === 'string') {
                $respuesta = 
            }
        } */
    }else{
        $respuesta = $conex->seleccionarQueryRegistroPagina($packRegistro[0], $packRegistro[1]);
        //print_r($packRegistro[1][3]);
        if(gettype($respuesta) ==='array' && $respuesta[0]== true){
          //  array_unshift($packRegistro,$respuesta[1], json_decode($packRegistro[1][3]));
           array_push($respuesta, json_decode($packRegistro[1][3]));

        }
    } 
    if($respuesta[0]){
      //  var_dump($respuesta);
        $cabeceraServ = ['Nombre', 'Descripcion', 'Precio'];
        $nombrePDF= substr($_SESSION['codSujeto'],0,2).''.array_shift($respuesta[2]);
  //                    ( $empresa, $cliente, $operacion, $operador)
        $pdf = new PDF( $respuesta[3], $respuesta[4][0], $respuesta[2], $respuesta[1]);
        $direc ='../clientes/'.$_SESSION['BBDD'].'/'.$nombrePDF.'.pdf';
        $pdf->AliasNbPages();
        $pdf->AddPage('P', 'A4');
        $pdf->SetFont('Times', '', 12);
        $pdf->BasicTable($cabeceraServ,$respuesta[5]);

      
        $pdf->Output('F', $direc);
        $pdf->Output('D'); 
      //  $pdf->Output();
    }
  //  var_dump($respuesta);
    echo json_encode($respuesta);
}

if (isset($_POST['existe_cliente'])){
 //   echo $_POST['existe_cliente'];
    $datos = $conex->devolverUnRegistro('clientes', ($_POST['existe_cliente']));
  //  print_r($datos);
    echo json_encode($datos[0]);
}