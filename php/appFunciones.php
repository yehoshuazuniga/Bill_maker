<?php
include __DIR__ . '/base_datos/accesoBD.php';
include __DIR__ . '/seguridad/elPuertasYelCoyote.php';

$conex = Funciones_en_BBDD::singleton();
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
        } else {
            echo count($_SESSION);
        }
    } else {
        echo 'no pasa el primer filtro';
    }
}


if (isset($_POST['nuevoUsuario'])) {
    $datosEnt = (json_decode($seguridad->filtrado($_POST['nuevoUsuario'])));
    if ($conex->existeParametro('dni', 'dni', $datosEnt->usuario_cif)) {
        echo json_encode('La empresa ya ha sido dada de alta');
    } else {
        $conex->crearBDyTablas(($datosEnt->usuario_nick_registro));
        echo json_encode($conex->registrarGer_Emp($datosEnt));
    }
}

if (isset($_POST['cerrarSesion'])) {
    session_start();
    $resultSession = '';
    if ($resultSession= $seguridad->cerrarSesion()) {
        echo json_encode(['Sesion Cerrada, adios', $resultSession]);
    } else {
        echo json_encode(['Sesion no cerrada', $resultSession]);
    }
}
