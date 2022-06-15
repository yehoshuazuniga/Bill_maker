<?php
require_once __DIR__ . '/fpdf/plantillaFactura.php';
require_once __DIR__ . '/PHPMailer-master/envioMail.php';
include __DIR__ . '/base_datos/accesoBD.php';
include __DIR__ . '/seguridad/elPuertasYelCoyote.php';
$conex = Funciones_en_BBDD::singleton();
session_start();
$seguridad = new PuertasYcoyote();
if (isset($_SESSION['BBDD']) && count($_SESSION) === 4) {
    $bd = $_SESSION['BBDD'];
    $conex = new Funciones_en_BBDD($bd);
}
if (isset($_POST['accesousuario'])) {
    $datosEnt = (json_decode($_POST['accesousuario']));
    $usuario = $seguridad->filtrado($datosEnt->usuario_nick);
    $pass = $seguridad->filtrado($datosEnt->usuario_password);
    $datosSesiones = $conex->extraerDatos($usuario, $pass);

    if ($conex->verificarUsuario($usuario, $pass) && count($datosSesiones) > 1) {
        $seguridad->tockenSession($datosSesiones[0], $datosSesiones[1]);
        if (count($_SESSION) === 4) {
            echo json_encode(true);
        }
    } else {
        echo json_encode(false);
    }
}


if (isset($_POST['nuevoUsuario'])) {
    $datosEnt = (json_decode($_POST['nuevoUsuario']));
    $respuesta = null;
    $mailEnviado = null;
    //priemro se busca en la base de datos de billmaker y ya exte ese cif, 
    //si existe se notifica al cliente y no se registra nada 
    //las operacones devuel an cliente y un boolean
    foreach ($datosEnt as $key => $value) {
        $datosEnt->$key = $seguridad->filtrado($value);
    }
    if ($conex->existeParametro('dni', 'dni', $datosEnt->dni)) {
        $respuesta = (['La empresa ya ha sido dada de alta', true]);
    } else {
        if ($conex->existeParametro('email', 'email', $datosEnt->email)) {
            $respuesta = (['Este mail ya ha sido usado', true]);
        } else {
            if ($conex->existeParametro('basedatos', 'basedatos', str_replace(' ', '_', ltrim($datosEnt->nombreEmpresa)))) {
                $respuesta = (['Este nombre de emperesa ya ha sido usado', true]);
            } else {
                // si en cif no exixte se recopila la informacion y se registarn en 
                //la tabla gerente y empelado de billmaker y la bbdd que se acaba de crear
                $conex->crearBDyTablas($datosEnt->nombreEmpresa);
                //eto registra los usuario en la bbdd de billmaker
                $regisGtEpBDP = $conex->registrarGer_Emp($datosEnt);
                //$email = new EnvioMail('Chocolate union', 'yehsssoshuagame@gmail.com');
                if (
                    gettype($regisGtEpBDP) == 'string' &&
                    $conex->registroTablaAcceso($datosEnt->usuarioGerente) &&
                    $conex->registroTablaAcceso($datosEnt->usuarioEmpleado)
                ) {
                    $bdnname = str_replace(' ', '_', $datosEnt->nombreEmpresa);
                    $conex = null;
                    //  echo $bdnname;
                    $conex = new Funciones_en_BBDD($bdnname);
                    $creacionCarpetas = $seguridad->crearCarpetas($bdnname);
                    $regisGtEp = $conex->registrarGer_Emp($datosEnt);
                    $respuesta = [$regisGtEp, false];
                    if ($regisGtEp != 'Vuelve a introducir los datos' && $creacionCarpetas) {
                        $email = new EnvioMail($datosEnt->nombreEmpresa, $datosEnt->email);
                        $mailEnviado = $email->envioMailGerenteYempleado($datosEnt->usuarioGerente, $datosEnt->usuarioEmpleado, $datosEnt->password);
                    }
                    if ($regisGtEp == 'Vuelve a introducir los datos' && !$creacionCarpetas && !$mailEnviado) {
                        $this->borrarBD($bdnname);
                        $this->elimnarEmpleado($datosEnt->dni);
                        $this->elimnarGerente($datosEnt->dni);
                        $this->elimnarAcceso($datosEnt->usuarioGerente, $datosEnt->usuarioEmpleado);
                        $seguridad->eliminarCarpetas($bdnname);
                        $respuesta = ['Ocurrio un error vuelve a introducir tus tados', true];
                    }
                }
            }
        }
    }
    echo json_encode($respuesta);
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
    $codServi = null;
    if ($packRegistro[0] === 'empleados') {
        $respuesta = $conex->seleccionarQueryRegistroPagina($packRegistro[0], $packRegistro[1]);
        if ($respuesta && gettype($respuesta) !== 'string') {
            // esto lo guardar en el bbdd principal
            $conex = null;
            $conex = Funciones_en_BBDD::singleton();
            $respuesta = json_encode($conex->seleccionarQueryRegistroPagina($packRegistro[0], $packRegistro[1]));
            $regisAcceso = $conex->registroTablaAcceso($packRegistro[1]->usuario);
            if ($respuesta && $regisAcceso) {
                $nomBreEmpresa = str_replace('_', ' ', $_SESSION['BBDD']);
                $email = new EnvioMail($nomBreEmpresa, $packRegistro[1]->email);
                $mailEnviado = $email->enviarMailEmpleado($packRegistro[1]->usuario, $packRegistro[1]->password);
            }
        } 
    } else {
        $respuesta = $conex->seleccionarQueryRegistroPagina($packRegistro[0], $packRegistro[1]);
        if (gettype($respuesta) === 'array' && $respuesta[0] == true) {
            //  array_unshift($packRegistro,$respuesta[1], json_decode($packRegistro[1][3]));
            $codServi = json_decode($packRegistro[1][3]);
            array_push($respuesta, $codServi);
        }
    }
    if ($respuesta[0] && ($packRegistro[0] === 'presupuestos' || $packRegistro[0] === 'facturas')) {
        $cabeceraServ = ['Nombre', 'Descripcion', 'Precio'];
        $aux = $respuesta[2];
        $nombrePDF = substr($_SESSION['codSujeto'], 0, 2) . '' . array_shift($aux);
        $doc = ucfirst(substr($packRegistro[0], 0, strlen($packRegistro[0]) - 1));
        $pdf = new PDF($respuesta[3], $respuesta[4][0], $respuesta[2], $respuesta[1], $doc);
        $urlTxt = "../clientes/" . $_SESSION['BBDD'] . "/" . $packRegistro[0];
        $direc = "../clientes/" . $_SESSION['BBDD'] . "/" . $packRegistro[0] . "/" . $nombrePDF . ".pdf";
        $pdf->AliasNbPages();
        $pdf->AddPage('P', 'A4');
        $pdf->SetFont('Times', '', 12);
        $pdf->BasicTable($cabeceraServ, $respuesta[5]);
        $pdf->Output('F', $direc);
        $carpetasContenedoresPdf = $_SESSION['BBDD'] . '/' . $packRegistro[0];
        if ($packRegistro[0] === 'presupuestos') {
            $seguridad->escribirFicheroServicios($codServi, $urlTxt, $nombrePDF);
        }
        $respuesta = [$respuesta[0], $carpetasContenedoresPdf, $nombrePDF];
    } else {
        if ($packRegistro[0] === 'presupuestos' || $packRegistro[0] === 'facturas') {
            $respuesta = [false, 'Selecciona algun producto'];
        }
    }
    //print_r($respuesta);
    echo json_encode($respuesta);
}
if (isset($_POST['existe_cliente'])) {
    $datos = $conex->devolverUnRegistro('clientes', ($_POST['existe_cliente']), " estado = 'activo' AND dni"); ///
    $respuesta = 'Cliente no registrado o en estado inactivo';
    if (isset($datos[0])) {
        $respuesta = $datos[0];
    }
    echo json_encode($respuesta);
}

if (isset($_POST['modificar'])) {
    $pack = json_decode($_POST['modificar']);
    $pagina = $pack[0];
    $datos = $pack[1];
    $hayInsert = false;
    $tabla = $seguridad->filtrado($pagina);
    $indiceSet = null;
    $valorSet = null;
    $valorWhereID = null;
    if ($pagina == 'clientes' || $tabla == 'proveedores' || $tabla == 'empleados') {
        $valorWhereID = ($seguridad->filtrado($datos->dni));
        unset($datos->dni);
    }

    if ($pagina === 'servicios') {
        $valorWhereID = ($seguridad->filtrado($datos->idServicios));
        unset($datos->precioIva);
        unset($datos->idServicios);
        if ($datos->idProducto == "") {
            unset($datos->idProducto);
        }
    }
    if ($pagina === 'productos_externos') {
        $valorWhereID = ($seguridad->filtrado($datos->idProducto));
        unset($datos->idProducto);


        unset($datos->precioIva);
        if ($datos->idProducto == "") {
            unset($datos->idProducto);
        }
    }
    $info = [];
    foreach ($datos as $key => $value) {
        $indiceSet = $seguridad->filtrado($key);
        $valorSet = $seguridad->filtrado($value);
        $tipoVarSet = gettype($valorSet);
        if ($indiceSet != 'dni' || $indiceSet != 'idServicios' || $indiceSet != 'idProducto') {
            $resultado = $conex->insertarDato($tabla, $indiceSet, $valorSet, $valorWhereID, $tipoVarSet);
            if ($resultado) {
                $info[] = "Se cambio " . $indiceSet;
            }
        }
    }
    $info = implode(' , ', $info);

    echo json_encode($info);
}
if (isset($_POST['cancelarAprobarPresupuesto'])) {
    $pack = json_decode($_POST['cancelarAprobarPresupuesto']);
    $datosServicios = [];
    $tabla = $seguridad->filtrado($pack[0]);
    $idDoc = $seguridad->filtrado($pack[1]);
    $estado = $seguridad->filtrado($pack[2]);
    $dni = $seguridad->filtrado($pack[3]);
    $respuesta = $conex->insertarDato($tabla, 'estado', $estado, $idDoc, 'string');
    if (!$respuesta) {
        $respuesta = ucfirst(substr($tabla, 0, (strlen($tabla) - 1))) . ' no cancelado';
    }
    if ($estado === 'aprobado' && $respuesta === true) {
        $fichTxt = substr($_SESSION['codSujeto'], 0, 2) . '' . $idDoc . '.txt';
        $urlTxt = "../clientes/" . $_SESSION['BBDD'] . "/" . $tabla . '/resumen_servicios/' . $fichTxt;
        $codServs = file($urlTxt);
        $datosPresu = $conex->datopsOperacion('presupuestos', 'idPresupuesto', $idDoc);
        $datosParaFact = [
            $datosPresu['dniCliente'],
            $datosPresu['idEmpleado'],
            $datosPresu['precio']
        ];
        $datosTrabajador = $conex->devolverUnRegistro('empleados', $datosPresu['idEmpleado'], 'idEmpleado');
        $crearFactura = $conex->presuAFactura($datosParaFact, $idDoc);
        $factura = $conex->datopsOperacion('facturas', 'idPresupuesto', $idDoc);

        $nombreTrabajador = ucfirst($datosTrabajador[0]['nombre']) . ' ' . $datosTrabajador[0]['apellido'];
        $idFacyFecha = [$factura['idFacturas'], $factura['fechaCreacion']];

        $datosEmpresa = $conex->devolverUnRegistro('gerente', $_SESSION['BBDD'], 'basedatos');
        $datosCliente = $conex->devolverUnRegistro('clientes', $dni);
        if ($crearFactura) $conex->insertarFondo($factura['idFacturas'], $factura['precio']);
        foreach ($codServs as $key => $value) {
            array_push($datosServicios, $conex->devolverUnRegistro('servicios', $seguridad->filtrado($value)));
        }
        $cabeceraServ = ['Nombre', 'Descripcion', 'Precio'];
        $aux = $factura;
        $nombrePDF = substr($_SESSION['codSujeto'], 0, 2) . '' . array_shift($aux);
        $pdf = new PDFAproved($datosEmpresa[0], $datosCliente[0], $idFacyFecha, $nombreTrabajador, 'Factura', $idDoc);
        $direc = "../clientes/" . $_SESSION['BBDD'] . "/facturas/" . $nombrePDF . ".pdf";
        $pdf->AliasNbPages();
        $pdf->AddPage('P', 'A4');
        $pdf->SetFont('Times', '', 12);
        $pdf->BasicTable($cabeceraServ, $datosServicios);
        $pdf->Output('F', $direc);

        $carpetasContenedoresPdf = $_SESSION['BBDD'] . '/facturas';
        $respuesta = [true, $carpetasContenedoresPdf, $nombrePDF];
    }
    echo json_encode($respuesta);
}

if (isset($_POST['rectificado'])) {
    $mensaje = null;
    $datos = json_decode($_POST['rectificado']);
    $tabla = $seguridad->filtrado($datos[0]);
    $idFac = $seguridad->filtrado($datos[1]);
    $precio = $seguridad->filtrado($datos[2]);
    $cambioEstado = $conex->insertarDato($tabla, 'estado', 'rectificado', $idFac, 'string');
    $insertFondos = $conex->insertarFondo($idFac, $precio, 'rectificado');
    $mensaje = true;
    if (!$cambioEstado) $mensaje[] = 'No se ha cambiado de estado';
    if (!$insertFondos) $mensaje[] = 'No se ha realizado el cambio';
    echo json_encode($mensaje);
}
