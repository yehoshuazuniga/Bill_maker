<?php
include __DIR__ . '/base_datos/accesoBD.php';
include __DIR__ . '/seguridad/elPuertasYelCoyote.php';
$conex = Funciones_en_BBDD::singleton();
session_start();
if (isset($_SESSION['BBDD']) && count($_SESSION)===3) {
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
        $seguridad->tockenSession($datosSesiones[0], $datosSesiones[1]);
        if (count($_SESSION) === 3) {
            echo json_encode(true);
            // hay q eliminar a apartir de este else
        } else {
            echo count($_SESSION);
        }
    } else {
        echo 'no pasa el primer filtro';
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
        $creaTablasCliente = $conex->registrarGer_Emp($datosEnt);
        if(gettype($creaTablasCliente) =='string'){
            $bdnname= str_replace(' ', '_', $datosEnt->usuario_nick_registro);
            $conex= null;
            $conex = new Funciones_en_BBDD($bdnname);
            echo json_encode([($conex->registrarGer_Emp($datosEnt)),false]);
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

if(isset($_POST['compo']) && count($_SESSION)===3){
    echo json_encode($conex->consultaPrueba());
}

if(isset($_POST['proveedores'])){
    
    echo json_encode($conex->proveedoresProdExter());
}