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

    // usca el nombre de la base de datos y la devuelve junto a otros datos
    function extraerDatos($usu, $pass)
    {
        //  echo " $usu -----  $pass ";
        $datos = [];

        $sent1 = '  SELECT  g.basedatos FROM gerente g , empleados e
                        WHERE g.idGerente=e.idGerente AND ( (e.usuario= :usu AND e.password = :pass) OR
                                                            (g.usuario= :usu AND g.password = :pass)) LIMIT 1 
                    ';
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
        $respuesta = false;
        $sql        = "SELECT *
                        FROM acceso
                        where usuario IN (
                            SELECT a.usuario
                            FROM gerente g , empleados e, acceso a
                            where   (a.usuario = g.usuario AND 
                                    g.usuario = :usu and 
                                    g.password = :pass )
                            OR
                                    (a.usuario = e.usuario and 
                                    e.usuario = :usu 
                                    and e.password = :pass))
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
    // esta pensado para uqe sea generico
    //aun esta en desarrollo
    // aqui hay que tener un usuario de mysql pero que no sea root RECORDAR CAMBIAR TODOS LOS ROOT , Y CREAR NUEBOS USUARIOS

    //
    //
    //
    //PROBELAMAS ARREGLARLO, NO SE CONECTA Y NO SE EJECUTA LA QUERY
    //
    //
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

            // echo 'existe';
        } /* else {
            //   echo ' no existe';
        } */

        return $cambios;
    }

    function crearBDyTablas($nombreEmpresa)
    {
        $nombreBD = str_replace(' ', '_', $nombreEmpresa);

        // $conex = BBDD::singleton(); //se va a usar esta fuuncio para el resto de creaciones
        $nuevaConex = $this->crearBd($nombreBD); // esto crea la base de datos y devuelve una nueva conexcion a esa base de dato creada
        $this->crearTablas($nuevaConex);
    }
    function insertTrabajador($pagina, $datos, $tipoID = 'idEmpleado', $campo8 = 'idGerente')
    {
        $hayInsercion = false;
        /*echo $pagina;
        print_r($datos);
      */
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
            //echo 'actua';
            $hayInsercion = true;
        }
        return $hayInsercion;
    }

    //registro del empleado y gerente 
    function registrarGer_Emp($datosEnt)
    {
        // print_r($datosEnt);             
        $id = null;
        $usuario = null;
        $respuesta = null;
        $cargos = ['gerente', 'empleados'];
        $nombreApellido = explode(' ', $datosEnt->usuario_contacto);
        $nameBD_o_IdGerente = str_replace(' ', '_', (ltrim($datosEnt->usuario_nick_registro)));
        //  $usuariosRegistrados_2 = [];
        $usuariosRegistrados_2 = 0;
        for ($i = 0; $i < count($cargos); $i++) {
            $sql = "INSERT INTO $cargos[$i] VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
            $sentPre = $this->conexion->prepare($sql);
            if ($i === 0) {
                $id = $datosEnt->idGerente;
                $usuario = $datosEnt->usuarioGerente;
            } else {
                $id = $datosEnt->idEmpleado;
                $nameBD_o_IdGerente = null;
                $nameBD_o_IdGerente = $datosEnt->idGerente;
                $usuario = $datosEnt->usuarioEmpleado;
            }
            $sentPre->bindParam(1, $id, PDO::PARAM_STR);
            $sentPre->bindParam(2, $nombreApellido[0], PDO::PARAM_STR);
            $sentPre->bindParam(3, $nombreApellido[1], PDO::PARAM_STR);
            $sentPre->bindParam(4, $datosEnt->usuario_cif, PDO::PARAM_STR);
            $sentPre->bindParam(5, $datosEnt->usuario_email, PDO::PARAM_STR);
            $sentPre->bindParam(6, $datosEnt->usuario_telefono, PDO::PARAM_STR);
            $sentPre->bindParam(7, $datosEnt->usuario_direccion, PDO::PARAM_STR);
            $sentPre->bindParam(8, $nameBD_o_IdGerente, PDO::PARAM_STR);
            $sentPre->bindParam(9, $usuario, PDO::PARAM_STR);
            $sentPre->bindParam(10, $datosEnt->usuario_password_registro, PDO::PARAM_STR);
            $sentPre->execute();
            //  if ($sentPre->rowCount() > 0) $usuariosRegistrados_2[$i] = $usuario;
            if ($sentPre->rowCount() > 0) $usuariosRegistrados_2++;
        }

        /* if (  $this->registroTablaAcceso($datosEnt->usuarioGerente) && $this->registroTablaAcceso($datosEnt->usuarioEmpleado)) {
           
                $respuesta = "Tablas de datos generadas, usuario gerente y empleado generados, sus credenciales se enviaran por mail";
                //echo $respuesta;
            
        } else {
            //printf($usuario);
          //  print_r($datosEnt); 
            //echo "   paso por aqui";
            if ($usuariosRegistrados_2 === 2) {
                $respuesta = "Usuarios, empleado y gerente, insertados en sus respectivas tablas";
                // echo "paso por el segundo registro";
            }
        } */
        if ($usuariosRegistrados_2 === 2) {
            $respuesta = "Tablas de datos generadas, usuario gerente y empleado generados, sus credenciales se enviaran por mail";
        } else {
            $respuesta = 'vuelve a introducir los datos';
        }


        return $respuesta;
    }
    function registroTablaAcceso($usuario)
    {
        //echo $usuario;
        try {
            $grabadoEnBBDD = false;
            $sql = 'INSERT INTO billmaker.acceso VALUES (?)';
            $sentPre = $this->conexion->prepare($sql);
            $sentPre->bindParam(1, $usuario, PDO::PARAM_STR);
            $sentPre->execute();
            if ($sentPre->rowCount() > 0) $grabadoEnBBDD = true;
        } catch (PDOException $e) {
            $grabadoEnBBDD = true;
        }
        // echo $grabadoEnBBDD . "<---------------";
        return $grabadoEnBBDD;
    }
    // funcion que devuelve los proveedores para el listadp de productos externos en


    function proveedoresProdExter()
    {
        $packEnvioEnt = null;
        //$sql = 'SELECT nombre, nif FROM preveedor ';
        // vamos a utilizar como ejemplo a gerente de billmaker es la unica bbdd que tiene registros;
        $sql = 'SELECT nombre, idProducto FROM productos_externos';
        $sentencia = $this->conexion->query($sql);
        $packEnvioEnt = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $packEnvioEnt;
    }

    //funcion filtra solicitante de vista_list
    function identificaLista_vita($solicitante)
    {

        $sql = '';
        $sql2 = '';
        switch ($solicitante) {
            case 'clientes':

                $sql = 'SELECT *  FROM ' . $solicitante;
                break;

            case 'empleados':

                $sql = 'SELECT idEmpleado, nombre, apellido, telefono, email, dni, direccion FROM ' . $solicitante;
                break;
            case 'facturas':

                $sql =
                    'SELECT * FROM ' . $solicitante;
                break;
            case 'presupuestos':
                $sql = 'SELECT * FROM ' . $solicitante;
                break;
            case 'proveedores':
                $sql = 'SELECT * FROM ' . $solicitante;
                break;
            case 'servicios':
                $sql = 'SELECT * ' . $sql2 . ' FROM ' . $solicitante;
                break;
            case 'gerente':
                $sql = 'SELECT dni, direccion, telefono, email ,nombre , apellido, basedatos  FROM ' . $solicitante;
                break;
        }
        return $sql;
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
                    c.direccion, c.email, c.telefono, 
                    c.personaContacto, p.fechaCreacion, p.precio 
                    FROM presupuestos p, clientes c';
            $where =  ' WHERE p.dniCliente=c.dni AND p.idPresupuesto=?';
        }

        if ($tabla === 'facturas') {
            $sql = '';
            $sql =  'SELECT c.dni, c.nombreEmpresa, f.idFacturas, f.idPresupuesto, c.direccion, c.email, c.telefono, 
                        c.personaContacto, f.fechaCreacion, f.precio FROM
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
        if(!$hayInsercion) {
            if (
                $this->existeParametro('dni', 'dni', $datos->dni, $_SESSION['BBDD'], $pagina) ||
                $this->existeParametro('dni', 'dni', $datos->dni, 'billMaker', $pagina)
            ) {
                $hayInsercion = 'El usuario ya existe';
            }
        }

        return  $hayInsercion;
    }

    //busca el id de una factura o presupuesto

    function devuelveIdyFacFacturaPresupuesto($dateTime, $trabajador, $tabla, $reg= 'idPresupuesto')
    {
        $id = '';
       // print_r([$dateTime, $trabajador, $tabla, $reg]);
        $sql = "SELECT ".$reg.", fechaCreacion  FROM " . $tabla . " WHERE fechaCreacion = ? AND idEmpleado = ?";
        $sentPre = $this->conexion->prepare($sql);
        $sentPre->bindParam(1, $dateTime, PDO::PARAM_STR);   
        $sentPre->bindParam(2, $trabajador, PDO::PARAM_STR);

        $sentPre->execute();
        if ($sentPre->rowCount() > 0) {
            $auxi = $sentPre->fetchAll(PDO::FETCH_ASSOC);
            $id = $auxi[0];
          //  echo 'se ejecutaM';
        }
        $id[$reg]  =(int)$id[$reg];

       // var_dump($id);
        return $id;
    }

    function insertarFondo($id, $oprecion, $valorID, $valorOperacion)
    {
        $hayInsercion=false;
        $sql = "INSERT INTO fondos (" . $id . ", " . $oprecion . ") VALUES(?,?)";
        $sentPre = $this->conexion->prepare($sql);
        $sentPre->bindParam(1, $valorID, PDO::PARAM_STR);
        $sentPre->bindParam(1, $valorOperacion, PDO::PARAM_INT);
        $sentPre->execute();
        if($sentPre->rowCount()>0) $hayInsercion=true;
        return $hayInsercion;

    }

    function registrarResgistroPresupuestos($pagina, $datos)
    {
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
            $aux1=$idPresuFact;
            $aux1 = array_pop($idPresuFact);
            if($pagina === ' facturas' ) $this->insertarFondo('idFactura', 'ingresos', $aux1, $datos[2]);
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

        return [$hayInsercion, $nombreTrabajador, $idPresuFact,  $datosEmpresa[0], $datosCliente, $datosServico];
    }
    function registrarResgistroFacturas($pagina, $datos)
    {
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
           // echo 'se registro';
            $idPresuFact = $this->devuelveIdyFacFacturaPresupuesto($ahora, $datos[1], $pagina, 'idFacturas');
            //echo  array_pop($idPresuFact);
            $nombreTrabajador = $_SESSION['empleado'];
            $datosEmpresa = $this->devolverUnRegistro('gerente', $_SESSION['BBDD'], 'basedatos');
            $datosCliente = $this->devolverUnRegistro('clientes', $datos[0]);
            foreach ($servicios as $key => $value) {
                array_push($datosServico, $this->devolverUnRegistro('servicios', $value));
            }
            $aux1 = $idPresuFact;
            if (
                gettype(array_shift($aux1)) === 'integer' && gettype($nombreTrabajador) === 'string' &&
                gettype($datosEmpresa) === 'array' && gettype($datosServico) === 'array' && gettype($datosCliente) == 'array' &&
                count($datosCliente) > 0 && count($datosEmpresa) > 0 && count($datosServico) > 0
            ) {
                $hayInsercion = true;
            }
        }

        return [$hayInsercion, $nombreTrabajador, $idPresuFact,  $datosEmpresa[0], $datosCliente, $datosServico];
    }

    function registrarResgistroProveedores($pagina, $datos)
    {
        $hayInsercion = false;
        /*echo $pagina;
        print_r($datos);
      */
        $sql = 'INSERT INTO ' . $pagina . '
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
        /*echo $pagina;
        print_r($datos);
      */
        $sql = 'INSERT INTO ' . $pagina . '
                        VALUES (?, ?, ?, ?, ?)';
        if (!isset($datos->idProducto)) {
            $datos->idProducto = NULL;
        }
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

    // esta funcion solo es de prueba no sirv epara nada mas
    function consultaPrueba()
    {
        $query = $this->conexion->query('show tables');
        return ($query->rowCount());
    }
}
