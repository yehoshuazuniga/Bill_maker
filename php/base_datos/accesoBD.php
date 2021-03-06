<?php
require __DIR__ . '/crearBD.php';
class Funciones_en_BBDD extends BBDD
{

    public static $instancia; // contenedor de la instancia 
    private $h;
    private $usu;
    private $pw;
    private $nombreBD;
    private $conexion;

    public function __construct($database = 'billmaker', $usuario = 'root2', $pass = '', $host = 'localhost')
    {
        $this->h = $host;
        $this->usu = $usuario;
        $this->nombreBD = $database;
        try {
            $this->conexion = new PDO("mysql:host=$host;dbname=$this->nombreBD", $usuario, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
        } catch (PDOException $e) {
            echo 'fallo en la conexion: ' . $e->getMessage();
        }
    }
    public static function singleton() //método singleton que crea instancia sí no está creada
    {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    public function __clone() // Evita que el objeto se pueda clonar
    {
        trigger_error('La clonación de este objeto no está permitida', E_USER_ERROR);
    }

    function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }

    public function __set($propiedad, $valor)
    {

        $this->$propiedad = $valor;
    }

    //hash
    public static function passHash($password)
    {
        $salt = 'biLlMakEr';

        return hash('sha512', $salt . $password);
    }
    //identidy hass
    public static  function verificarPass($hassBBDD, $passwordEnt)
    {
        return ($hassBBDD == self::passHash($passwordEnt));
    }
    //si falla la accion de regustrar, elimnar registro de acceeso, gerente y de empleados de billmaker 

    function facturaMedia()
    {
        $sql1 = "SELECT AVG(precio), count(idFacturas) FROM facturas  where estado = 'normal'";
        $sql2 = "SELECT AVG(precio), count(idFacturas) FROM facturas  where estado = 'rectificado'";
        $a = $this->conexion->query($sql1);
        $a->execute();
        $b = $this->conexion->query($sql2);
        $b->execute();
        $info = [$a->fetchAll(PDO::FETCH_ASSOC)[0], $b->fetchAll(PDO::FETCH_ASSOC)[0]];
        $respuesta = " <div class=\"text-black card-header\">La media de facturas </div>
            <div class=\"text-black card-body\">
                <h5 class=\"text-black card-title\">Desgloce</h5>
                <p> Se han realizado " . array_pop($info[0]) . " facturas y se ha obtenido de beneficio " . number_format(array_pop($info[0]), 2) . " €</p>
                <p> Se han rectificado " . array_pop($info[1]) . " facturas  y se ha perdido de beneficio " . number_format(array_pop($info[1]), 2) . " €</p>
            </div>";
        return $respuesta;
    }
    function presuMedio()
    {
        $sql1 = "SELECT AVG(precio), count(idPresupuesto) FROM presupuestos  where estado = 'aprobado'";
        $sql2 = "SELECT AVG(precio), count(idPresupuesto) FROM presupuestos  where estado = 'cancelado'";
        $sql3 = "SELECT AVG(precio), count(idPresupuesto) FROM presupuestos  where estado = 'pendiente'";
        $a = $this->conexion->query($sql1);
        $a->execute();
        $b = $this->conexion->query($sql2);
        $b->execute();
        $c = $this->conexion->query($sql3);
        $c->execute();
        $info = [$a->fetchAll(PDO::FETCH_ASSOC)[0], $b->fetchAll(PDO::FETCH_ASSOC)[0], $c->fetchAll(PDO::FETCH_ASSOC)[0]];
        $respuesta = " <div class=\"text-black card-header\">La media de presupuestos </div>
            <div class=\"text-black card-body\">
                <h5 class=\"text-black card-title\">Desgloce</h5>
                <p> Se han aprobado " . array_pop($info[0]) . " presupuestos y se ha obtenido de beneficio " . number_format(array_pop($info[0]), 2) . " €</p>
                <p> Se han rechazado " . array_pop($info[1]) . " presupuestos  y se ha perdido de beneficio " . number_format(array_pop($info[1]), 2) . " €</p>
                <p> Presupuestos pedientes " . array_pop($info[2]) . " y se espera de beneficio " . number_format(array_pop($info[2]), 2) . " €</p>
            </div>";
        return $respuesta;
    }
    function mejorPresupuesto()
    {
        $sql1 = "SELECT e.nombre, COUNT(p.idPresupuesto), AVG(p.precio)
                    FROM empleados e, presupuestos p
                    WHERE e.idempleado = p.idempleado   
                    GROUP BY p.idempleado
                    LIMIT 3";
        //	select avg(precio) from facturas

        $a = $this->conexion->query($sql1);
        $a->execute();
        $parf = '';
        $a->execute();
        $info = $a->fetchAll(PDO::FETCH_ASSOC);
        for ($i = 0; $i < count($info); $i++) {
            $aux = $info[$i];
            $parf .= "<p>" . array_shift($aux) . " ha hecho " . (array_shift($aux)) . " presupuestosm, con un fondo de " .  number_format((array_shift($aux)),2) . " €</p>";
        }

        $respuesta = " <div class=\"text-black card-header\">Las mejores presupuestos </div>
            <div class=\"text-black card-body\">
                <h5 class=\"text-black card-title\">Desgloce</h5>
                " . $parf . "
                </div>";
        return $respuesta;
    }

    function mejorFactura()
    {
        $sql1 = "SELECT e.nombre, COUNT(p.idFacturas), AVG(precio)
                    FROM empleados e, facturas p
                    WHERE e.idempleado = p.idempleado   
                    GROUP BY p.idempleado
                    LIMIT 3";
        //	select avg(precio) from facturas

        $a = $this->conexion->query($sql1);
        $a->execute();
        $parf = '';
        $a->execute();
        $info = $a->fetchAll(PDO::FETCH_ASSOC);
        for ($i = 0; $i < count($info); $i++) {
            $aux = $info[$i];
            $parf .= "<p>" . array_shift($aux) . " ha hecho " . (array_shift($aux)) . " presupuestosm, con un fondo de " . (array_shift($aux)) . " €</p>";
        }

        $respuesta = " <div class=\"text-black card-header\">Las mejores Facturas </div>
            <div class=\"text-black card-body\">
                <h5 class=\"text-black card-title\">Desgloce</h5>
                " . $parf . "
                </div>";
        return $respuesta;
    }
    function fondos()
    {
        $sql = 'SELECT AVG(gastos), AVG(ingresos) FROM fondos';
        $a = $this->conexion->query($sql);
        $a->execute();          
        $info = $a->fetchAll(PDO::FETCH_ASSOC)[0];

        $respuesta = " <div class=\"text-black card-header\">Los fondos de la empresa</div>
            <div class=\"text-black card-body\">
                <h5 class=\"text-black card-title\">Desgloce</h5>
                <p class=\"fw-3\"> Se han registrado " . number_format(array_pop($info), 2). "€ de gastos frente a " . number_format(array_pop($info), 2) . " € de beneficios</p>
                </div>";
        return $respuesta;

    }
    function selectTop($target)
    {
        $respuesta = null;
        switch ($target) {
            case 'factura-media':
                $respuesta = $this->facturaMedia();
                break;
            case 'presupuesto-medio':
                $respuesta = $this->presuMedio();
                break;
            case 'mejor-factura':
                $respuesta = $this->mejorFactura();
                break;
            case 'mejor-presupuesto':
                $respuesta = $this->mejorPresupuesto();
                break;
            case 'fondos':
                $respuesta = $this->fondos();
                break;

            default:
                # code...
                break;
        }
        return $respuesta;
    }




    function elimnarGerente($dni)
    {
        $delete = false;
        $sql = 'DELETE FROM billmaker.gerente WHERE dni = ?';
        $sentPre = $this->conexion->prepare($sql);
        $sentPre->bindParam(1, $dni, PDO::PARAM_STR);
        $sentPre->execute();
        if ($sentPre->rowCount() > 0) $delete = true;
        return $delete;
    }
    function elimnarEmpleado($dni)
    {
        $delete = false;
        $sql = 'DELETE FROM billmaker.empleados WHERE dni = ?';
        $sentPre = $this->conexion->prepare($sql);
        $sentPre->bindParam(1, $dni, PDO::PARAM_STR);
        $sentPre->execute();
        if ($sentPre->rowCount() > 0) $delete = true;
        return $delete;
    }
    function elimnarAcceso($usu1, $usu2)
    {
        $delete = false;
        $sql = 'DELETE FROM billmaker.acceso WHERE usuario = ? or usuario = ?';
        $sentPre = $this->conexion->prepare($sql);
        $sentPre->bindParam(1, $usu1, PDO::PARAM_STR);
        $sentPre->bindParam(2, $usu2, PDO::PARAM_STR);
        $sentPre->execute();
        if ($sentPre->rowCount() > 1) $delete = true;
        return $delete;
    }
    // usca el nombre de la base de datos y la devuelve junto a otros datos
    function extraerDatos($usu, $pass)
    {
        $pass = $this->passHash($pass);
        $datos = [];
        $sent1 = "  SELECT  g.basedatos FROM gerente g , empleados e
                        WHERE g.idGerente=e.idGerente AND ( (e.usuario= :usu AND e.password = :pass) OR
                                                            (g.usuario= :usu AND g.password = :pass)) LIMIT 1 
                    ";
        $sentPre = $this->conexion->prepare($sent1);
        $sentPre->execute(
            array(
                ':usu' => $usu,
                ':pass' => $pass
            )
        );
        $datos = $sentPre->fetchAll(PDO::FETCH_ASSOC);
        $sent2 = 'SELECT idEmpleado, nombre, apellido FROM empleados WHERE usuario = :usu  AND password = :pass;';
        $sentpre2 = $this->conexion->prepare($sent2);
        $sentpre2->execute(
            array(
                ':usu' => $usu,
                ':pass' => $pass
            )
        );
        $sent3 = 'SELECT idGerente, nombre, apellido  FROM gerente WHERE usuario = :usu  AND password = :pass;';
        $sentpre3 = $this->conexion->prepare($sent3);
        $sentpre3->execute(
            array(
                ':usu' => $usu,
                ':pass' => $pass
            )
        );
        if ($sentpre2->rowCount() > 0) {
            array_push($datos, $sentpre2->fetchAll(PDO::FETCH_ASSOC)[0]);
        }
        if ($sentpre3->rowCount() > 0) {
            array_push($datos, $sentpre3->fetchAll(PDO::FETCH_ASSOC)[0]);
        }
        return $datos;
    }


    function verificarUsuario($usu, $pass)
    {

        $pass = $this->passHash($pass);
        // echo 'verificarUsuario******'. $pass.'*******';
        $respuesta = false;
        $sql        = "SELECT *
                        FROM acceso
                        where usuario IN (
                            SELECT a.usuario
                            FROM gerente g , empleados e, acceso a
                            where   (a.usuario = g.usuario AND 
                                    g.usuario = :usu AND 
                                    g.password = :pass )
                            OR
                                    (a.usuario = e.usuario AND 
                                    e.usuario = :usu 
                                    AND e.password = :pass) )
                        ";
        $sentPre  = $this->conexion->prepare($sql);
        $sentPre->execute(
            array(
                ':usu'  => $usu,
                ':pass' => $pass
            )
        );
        if ($sentPre->rowCount() > 0) {
            $respuesta = true;
        }

        return $respuesta;
    }

    //este metodo ayuda a buscar solo un parametro en la base de datos la base de datos
    function existeParametro($selectParam, $whereParan, $parametro, $bd = 'billmaker', $tabla = 'gerente')
    {
        $cambios = false;
        $newConex = $this;
        // $newConex = Funciones_en_BBDD::singleton();
        if ($bd !== 'billmaker') {
            $newConex = null;
            //$database = 'billmaker', $usuario = 'root2', $pass = '', $host = 'localhost'
            $newConex = new Funciones_en_BBDD($bd, 'root2', '', 'localhost');
        }

        $sentencia = "SELECT ? FROM $tabla  WHERE $whereParan = ?";
        $sentPre = $newConex->conexion->prepare($sentencia);
        $sentPre->bindParam(1, $selectParam, PDO::PARAM_STR);
        $sentPre->bindParam(2, $parametro, PDO::PARAM_STR);
        $sentPre->execute();

        if ($sentPre->rowCount() > 0) {
            $cambios = true;
        }
        return $cambios;
    }

    function crearBDyTablas($nombreEmpresa)
    {
        $nombreBD = str_replace(' ', '_', $nombreEmpresa);
        $nuevaConex = $this->crearBd($nombreBD); // esto crea la base de datos y devuelve una nueva conexcion a esa base de dato creada
        $this->crearTablas($nuevaConex);
    }
    function insertTrabajador($pagina, $datos, $tipoID = 'idEmpleado', $campo8 = 'idGerente')
    {
        $hayInsercion = false;
        $sql = 'INSERT INTO ' . $pagina . '
            (' . $tipoID . ', nombre, apellido, dni, email, telefono, direccion, ' . $campo8 . ', usuario, password)
                        VALUES  (?, ?, ?, ?, ?, ?, ?, ?, ?,?)';
        $sentPre = $this->conexion->prepare($sql);
        $pass = $this->passHash($datos->password);
        $sentPre->bindParam(1, $datos->idEmpleado, PDO::PARAM_STR);
        $sentPre->bindParam(2, $datos->nombre, PDO::PARAM_STR);
        $sentPre->bindParam(3, $datos->apellido, PDO::PARAM_STR);
        $sentPre->bindParam(4, $datos->dni, PDO::PARAM_STR);
        $sentPre->bindParam(5, $datos->email, PDO::PARAM_STR);
        $sentPre->bindParam(6, $datos->telefono, PDO::PARAM_STR);
        $sentPre->bindParam(7, $datos->direccion, PDO::PARAM_STR);
        $sentPre->bindParam(8, $datos->idGerente, PDO::PARAM_STR);
        $sentPre->bindParam(9, $datos->usuario, PDO::PARAM_STR);
        $sentPre->bindParam(10, $pass, PDO::PARAM_STR);
        $sentPre->execute();
        if ($sentPre->rowCount() > 0) {
            $hayInsercion = true;
        }
        return $hayInsercion;
    }

    //registro del empleado y gerente 
    function registrarGer_Emp($datosEnt)
    {
        $respuesta = null;
        $cargos = ['gerente', 'empleados'];
        $nombreApellido = explode(' ', $datosEnt->contacto);
        $nombre = ucfirst($nombreApellido[0]);
        $apellido = isset($nombreApellido[1]) ? ucfirst($nombreApellido[1]) : '';
        $nombreEmpresa = str_replace(' ', '_', (ltrim($datosEnt->nombreEmpresa)));
        $datosGerente = [
            'idEmpleado' => $datosEnt->idGerente,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'dni' => $datosEnt->dni,
            'email' => $datosEnt->email,
            'telefono' => $datosEnt->telefono,
            'direccion' => $datosEnt->direccion,
            'idGerente' => $nombreEmpresa,
            'usuario' => $datosEnt->usuarioGerente,
            'password' => $datosEnt->password
        ];
        $datosEmpleado = [
            'idEmpleado' => $datosEnt->idEmpleado,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'dni' => $datosEnt->dni,
            'email' => $datosEnt->email,
            'telefono' => $datosEnt->telefono,
            'direccion' => $datosEnt->direccion,
            'idGerente' => $datosEnt->idGerente,
            'usuario' => $datosEnt->usuarioEmpleado,
            'password' => $datosEnt->password
        ];
        $datosGerente = (object)$datosGerente;
        $datosEmpleado = (object)$datosEmpleado;
        $gerenteRegistrado = $this->insertTrabajador($cargos[0], $datosGerente, 'idGerente', 'basedatos');
        $empleadoRegistrado = $this->insertTrabajador($cargos[1], $datosEmpleado,);
        if ($gerenteRegistrado && $empleadoRegistrado) {
            $respuesta = "Tablas de datos generadas, usuario gerente y empleado generados, sus credenciales se enviaran por mail";
        } else {
            $respuesta = 'Vuelve a introducir los datos';
        }
        return $respuesta;
    }
    // registra en la tabla de acceso bilmaker
    function registroTablaAcceso($usuario)
    {
        //echo $usuario;
        try {
            $grabadoEnBBDD = false;
            $sql = 'INSERT INTO billmaker.acceso VALUES (?)';
            $sentPre = $this->conexion->prepare($sql);
            $sentPre->bindParam(1, $usuario, PDO::PARAM_STR);
            $sentPre->execute();
            if ($sentPre->rowCount() > 0) {
                $grabadoEnBBDD = true;
            }
        } catch (PDOException $e) {
            $grabadoEnBBDD = true;
        }
        return $grabadoEnBBDD;
    }
    // funcion que devuelve los proveedores para el listadp de productos externos en
    function proveedoresProdExter()
    {
        $packEnvioEnt = null;
        // vamos a utilizar como ejemplo a gerente de billmaker es la unica bbdd que tiene registros;
        $sql = "SELECT nombre, idProducto FROM productos_externos";
        $sentencia = $this->conexion->query($sql);
        $packEnvioEnt = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $packEnvioEnt;
    }


    //esta funcion estrae las datos de la tabla que le pasemos
    function datosLista_vista($tabla)
    {
        $sql = $this->identificaLista_vita($tabla);
        $sentencia = $this->conexion->query($sql);
        $packEnvioEnt = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $packEnvioEnt;
    }

    function devolverUnRegistro($tabla, $dni, $tipo = 'dni')
    {
        $sql = $this->identificaLista_vita($tabla);

        $where =  ' WHERE ' . $tipo . '=?';
        if ($tabla === 'servicios') {
            $where =  ' WHERE idServicios=?';
        }
        if ($tabla === 'presupuestos') {
            $sql = '';
            $sql =  'SELECT c.dni, c.nombreEmpresa, p.idPresupuesto, 
                    c.direccion, c.email, c.telefono, c.personaContacto, 
                    p.fechaCreacion, p.precio, p.estado
                    FROM presupuestos p, clientes c';
            $where =  ' WHERE p.dniCliente=c.dni AND p.idPresupuesto=?';
        }

        if ($tabla === 'facturas') {
            $sql = '';
            $sql =  '   SELECT c.dni, c.nombreEmpresa, f.idFacturas,
                        f.idPresupuesto, c.direccion, c.email, c.telefono, 
                        c.personaContacto, f.fechaCreacion, f.precio, f.estado FROM
                        facturas f, clientes c ';
            $where =  ' WHERE f.dniCliente=c.dni AND f.idFacturas=?';
        }

        $sql = $sql . '' . $where;
        $sentPre = $this->conexion->prepare($sql);
        $sentPre->bindParam(1, $dni, PDO::PARAM_STR);
        $sentPre->execute();

        return $sentPre->fetchAll(PDO::FETCH_ASSOC);
    }


    function registrarResgistroClientes($pagina, $datos)
    {
        $hayInsercion = false;

        $sql = 'INSERT INTO ' . $pagina . '
                        (dni,nombreEmpresa,direccion,email,telefono,personaContacto)
                        VALUES (?,?,?,?,?,?)';
        $sentPre = $this->conexion->prepare($sql);

        $sentPre->bindParam(1, $datos->dni);
        $sentPre->bindParam(2, $datos->nombreEmpresa);
        $sentPre->bindParam(3, $datos->direccion);
        $sentPre->bindParam(4, $datos->email);
        $sentPre->bindParam(5, $datos->telefono);
        $sentPre->bindParam(6, $datos->personaContacto);

        $sentPre->execute();
        if ($sentPre->rowCount() > 0) {
            $hayInsercion = true;
        } else {
            if ($this->existeParametro('dni', 'dni', $datos->dni, $_SESSION['BBDD'], $pagina)) {
                $hayInsercion = 'El usuario ya existe';
            }
        }
        return  $hayInsercion;
    }

    function registrarResgistroEmpleados($pagina, $datos)
    {
        $hayInsercion = $this->insertTrabajador($pagina, $datos);
        if (!$hayInsercion) {
            if (
                $this->existeParametro('dni', 'dni', $datos->dni, $_SESSION['BBDD'], $pagina) ||
                $this->existeParametro('dni', 'dni', $datos->dni, 'billMaker', $pagina)
            ) {
                $hayInsercion = 'El dni de usuario ya existe';
            }
            if (
                $this->existeParametro('email', 'email', $datos->email, $_SESSION['BBDD'], $pagina)
            ) {
                $hayInsercion = 'El mail ya se ha usado';
            }
        }

        return  $hayInsercion;
    }

    //busca el id de una factura o presupuesto

    function devuelveIdyFacFacturaPresupuesto($dateTime, $trabajador, $tabla, $reg = 'idPresupuesto')
    {
        $id = '';
        $sql = "SELECT " . $reg . ", fechaCreacion  FROM " . $tabla . " WHERE fechaCreacion = ? AND idEmpleado = ?";
        $sentPre = $this->conexion->prepare($sql);
        $sentPre->bindParam(1, $dateTime, PDO::PARAM_STR);
        $sentPre->bindParam(2, $trabajador, PDO::PARAM_STR);

        $sentPre->execute();
        if ($sentPre->rowCount() > 0) {
            $auxi = $sentPre->fetchAll(PDO::FETCH_ASSOC);
            $id = $auxi[0];
        }
        $id[$reg]  = (int)$id[$reg];
        return $id;
    }

    function insertarFondo($valorID, $valorOperacion, $estado = '')
    {
        $hayInsercion = false;
        $valorOperacion = (int)$valorOperacion;
        $sql = "INSERT INTO fondos (idFactura,ingresos) VALUES(?,?)";
        if ($estado == 'rectificado') {
            $sql = "INSERT INTO fondos (idFactura,gastos) VALUES(?,?)";
        }
        if ($estado == 'compra') {
            $sql = "INSERT INTO fondos (idProducto,gastos) VALUES(?,?)";
        }
        $sentPre = $this->conexion->prepare($sql);
        $sentPre->bindParam(1, $valorID, PDO::PARAM_STR);
        $sentPre->bindParam(2, $valorOperacion, PDO::PARAM_INT);
        $sentPre->execute();
        if ($sentPre->rowCount() > 0) {
            $hayInsercion = true;
        }
        return $hayInsercion;
    }

    function registrarResgistroPresupuestos($pagina, $datos)
    {
        if ($datos[2] == 0) {
            $respuesta = [false, 'Selecciona algun producto jjhhjjhjhjh'];
        } else if ($datos[2] != 0) {
            $servicios = json_decode($datos[3]);
            $datosServico = [];
            $tiempo = new DateTime('NOW');
            $hayInsercion = false;
            $idPresuFact = '';
            $sql = 'INSERT INTO ' . $pagina . '(dniCliente, idEmpleado,precio,fechaCreacion) 
                VALUES(?,?,?,?)';
            $sentPre = $this->conexion->prepare($sql);
            $ahora = $tiempo->format('Y-m-d H:i:s');
            $sentPre->bindParam(1, $datos[0], PDO::PARAM_STR);
            $sentPre->bindParam(2, $datos[1], PDO::PARAM_STR);
            $sentPre->bindParam(3, $datos[2], PDO::PARAM_INT);
            $sentPre->bindParam(4, $ahora, PDO::PARAM_STR);
            $sentPre->execute();
            if ($sentPre->rowCount() > 0) {
                $idPresuFact = $this->devuelveIdyFacFacturaPresupuesto($ahora, $datos[1], $pagina);

                $nombreTrabajador = $_SESSION['empleado'];
                $datosEmpresa = $this->devolverUnRegistro('gerente', $_SESSION['BBDD'], 'basedatos');
                $datosCliente = $this->devolverUnRegistro('clientes', $datos[0]);
                foreach ($servicios as $key => $value) {
                    array_push($datosServico, $this->devolverUnRegistro('servicios', $value));
                }
                if (
                    gettype($idPresuFact['idPresupuesto']) === 'integer' && gettype($nombreTrabajador) === 'string' &&
                    gettype($datosEmpresa) === 'array' && gettype($datosServico) === 'array' && gettype($datosCliente) == 'array' &&
                    count($datosCliente) > 0 && count($datosEmpresa) > 0 && count($datosServico) > 0
                ) {
                    $hayInsercion = true;
                }
            }
            $respuesta = [$hayInsercion, $nombreTrabajador, $idPresuFact,  $datosEmpresa[0], $datosCliente, $datosServico];
        }
        return $respuesta;
    }
    function registrarResgistroFacturas($pagina, $datos, $idPresupuesto = NULL)
    {
        if ($datos[2] == 0) {
            $respuesta = [false, ' Selecciona algun producto servicio '];
        } else if ($datos[2] !== 0) {
            $servicios = json_decode($datos[3]);
            $datosServico = [];
            $tiempo = new DateTime('NOW');
            $hayInsercion = false;
            $idPresuFact = '';
            $sql = 'INSERT INTO ' . $pagina . '(dniCliente, idEmpleado, idPresupuesto,precio ,fechaCreacion) 
                VALUES(?,?,?,?,?)';
            $sentPre = $this->conexion->prepare($sql);
            $ahora = $tiempo->format('Y-m-d H:i:s');
            $sentPre->bindParam(1, $datos[0], PDO::PARAM_STR);
            $sentPre->bindParam(2, $datos[1], PDO::PARAM_STR);
            $sentPre->bindParam(3, $idPresupuesto, PDO::PARAM_STR);
            $sentPre->bindParam(4, $datos[2], PDO::PARAM_INT);
            $sentPre->bindParam(5, $ahora, PDO::PARAM_STR);
            $sentPre->execute();
            if ($sentPre->rowCount() > 0) {
                $idPresuFact = $this->devuelveIdyFacFacturaPresupuesto($ahora, $datos[1], $pagina, 'idFacturas');
                $aux1 = $idPresuFact;
                $aux1 = array_shift($aux1);
                if ($pagina === 'facturas') $this->insertarFondo($aux1, $datos[2]);
                $nombreTrabajador = $_SESSION['empleado'];
                $datosEmpresa = $this->devolverUnRegistro('gerente', $_SESSION['BBDD'], 'basedatos');
                $datosCliente = $this->devolverUnRegistro('clientes', $datos[0]);
                foreach ($servicios as $key => $value) {
                    array_push($datosServico, $this->devolverUnRegistro('servicios', $value));
                }
                if (
                    gettype($aux1) === 'integer' && gettype($nombreTrabajador) === 'string' &&
                    gettype($datosEmpresa) === 'array' && gettype($datosServico) === 'array' && gettype($datosCliente) == 'array' &&
                    count($datosCliente) > 0 && count($datosEmpresa) > 0 && count($datosServico) > 0
                ) {
                    $hayInsercion = true;
                }
            }

            $respuesta =  [$hayInsercion, $nombreTrabajador, $idPresuFact,  $datosEmpresa[0], $datosCliente, $datosServico];
        }
        return $respuesta;
    }


    function registrarResgistroProveedores($pagina, $datos)
    {
        $hayInsercion = false;

        $sql = 'INSERT INTO ' . $pagina . ' (dni,nombre,direccion,email,telefono,personaContacto) 
                        VALUES(?, ?, ?, ?, ?, ? )';
        $sentPre = $this->conexion->prepare($sql);

        $sentPre->bindParam(1, $datos->dni, PDO::PARAM_STR);
        $sentPre->bindParam(2, $datos->nombre, PDO::PARAM_STR);
        $sentPre->bindParam(3, $datos->direccion, PDO::PARAM_STR);
        $sentPre->bindParam(4, $datos->email, PDO::PARAM_STR);
        $sentPre->bindParam(5, $datos->telefono, PDO::PARAM_STR);
        $sentPre->bindParam(6, $datos->personaContacto, PDO::PARAM_STR);

        $sentPre->execute();
        if ($sentPre->rowCount() > 0) {
            $hayInsercion = true;
        } else {
            if ($this->existeParametro('dni', 'dni', $datos->dni, $_SESSION['BBDD'], $pagina)) {
                $hayInsercion = 'El proveedor ya existe';
            }
        }
        return  $hayInsercion;
    }
    function registrarResgistroServicios($pagina, $datos)
    {
        $hayInsercion = false;
        $idProducto = null;
        /*echo $pagina;
        print_r($datos);
        */
        $sql = 'INSERT INTO ' . $pagina . ' (idServicios,idProducto,nombre,descripcion,precio)
                        VALUES (?, ?, ?, ?, ?)';
        //   echo $sql;
        if (!isset($datos->idProducto) || $datos->idProducto == 'on') {
            $datos->idProducto = NULL;
        }

        // echo $idProducto;
        $sentPre = $this->conexion->prepare($sql);
        $precio = (int)$datos->precio;
        //   print_r($datos);
        $sentPre->bindParam(1, $datos->idServicios, PDO::PARAM_STR);
        $sentPre->bindParam(2, $datos->idProducto, PDO::PARAM_STR);
        $sentPre->bindParam(3, $datos->nombre, PDO::PARAM_STR);
        $sentPre->bindParam(4, $datos->descripcion, PDO::PARAM_STR);
        $sentPre->bindParam(5, $precio, PDO::PARAM_INT);

        $sentPre->execute();
        if ($sentPre->rowCount() > 0) {
            $hayInsercion = true;
        } else {
            if ($this->existeParametro('idServicios', 'idServicios', $datos->idServicios, $_SESSION['BBDD'], $pagina)) {
                $hayInsercion = 'El servicio ya existe';
            }
        }
        return  $hayInsercion;
    }

    function seleccionarQueryRegistroPagina($pagina, $datos)
    {
        $result = null;
        switch ($pagina) {
            case 'clientes':
                $result = $this->registrarResgistroClientes($pagina, $datos);
                break;

            case 'empleados':
                $result = $this->registrarResgistroEmpleados($pagina, $datos);

                break;
            case 'facturas':
                $result = $this->registrarResgistroFacturas($pagina, $datos);
                break;

            case 'presupuestos':
                $result = $this->registrarResgistroPresupuestos($pagina, $datos);

                break;
            case 'proveedores':
                $result = $this->registrarResgistroProveedores($pagina, $datos);

                break;
            case 'servicios':
                $result = $this->registrarResgistroServicios($pagina, $datos);
        }
        return $result;
    }

    // function insertarDato($tabla, $indiceSet, $valorSet, $indiceWhereId, $valorWhereID)
    function insertarDato($tabla, $indiceSet, $valorSet, $valorWhereID, $tipoVarSet)
    {
        $hayInsercion = false;
        $param1 = $valorSet;
        $param2 = $valorWhereID;
        $sql = '';
        if ($tabla === 'servicios') {
            if ($indiceSet == 'precio') {
                $valorSet = (int) $valorSet;
            }
            $sql = "UPDATE " . $tabla . " SET " . $indiceSet . " = ? WHERE idServicios = ? ";
        }
        if ($tabla === 'productos_externos') {
            if ($indiceSet == 'precio') {
                $valorSet = (int) $valorSet;
            }
            $sql = "UPDATE " . $tabla . " SET " . $indiceSet . " = ? WHERE idProducto = ? ";
        }
        if ($tabla === 'facturas') {
            $sql = "UPDATE " . $tabla . " SET " . $indiceSet . " = ? WHERE idFacturas = ? ";
        }
        if ($tabla === 'presupuestos') {
            $sql = "UPDATE " . $tabla . " SET " . $indiceSet . " = ? WHERE idPresupuesto = ? ";
        }

        if ($tabla === 'clientes' || $tabla === 'proveedores' || $tabla === 'empleados') {
            $sql = "UPDATE " . $tabla . " SET " . $indiceSet . " = ? WHERE dni = ? ";
        }
        $sentPre = $this->conexion->prepare($sql);
        if ($tipoVarSet == 'string') {
            $sentPre->bindParam(1, $param1, PDO::PARAM_STR);
        }
        if ($tipoVarSet == 'integer') {
            $sentPre->bindParam(1, $param1, PDO::PARAM_INT);
        }
        $sentPre->bindParam(2, $param2, PDO::PARAM_STR);
        $sentPre->execute();
        if ($sentPre->rowCount() > 0) {
            $hayInsercion = true;
        }
        return $hayInsercion;
    }

    function datopsOperacion($tabla, $paramWhere, $idPresu)
    {
        $sql = 'SELECT * FROM ' . $tabla . ' WHERE ' . $paramWhere . ' = ?';
        $sentPre = $this->conexion->prepare($sql);
        $sentPre->bindParam(1, $idPresu, PDO::PARAM_STR);
        $sentPre->execute();

        $datos = $sentPre->fetchAll(PDO::FETCH_ASSOC);
        return ($datos[0]);
    }

    function presuAFactura($datos, $idPresupuesto)
    {
        $hayInsercion = false;
        $tiempo = new DateTime('NOW');
        $sql = 'INSERT INTO facturas (dniCliente, idEmpleado, idPresupuesto,precio ,fechaCreacion) 
                VALUES(?,?,?,?,?)';
        $sentPre = $this->conexion->prepare($sql);
        $ahora = $tiempo->format('Y-m-d H:i:s');
        $sentPre->bindParam(1, $datos[0], PDO::PARAM_STR);
        $sentPre->bindParam(2, $datos[1], PDO::PARAM_STR);
        $sentPre->bindParam(3, $idPresupuesto, PDO::PARAM_STR);
        $sentPre->bindParam(4, $datos[2], PDO::PARAM_INT);
        $sentPre->bindParam(5, $ahora, PDO::PARAM_STR);
        $sentPre->execute();
        if ($sentPre->rowCount() > 0) $hayInsercion = true;
        return $hayInsercion;
    }
}
