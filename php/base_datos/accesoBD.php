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

    function extraerDatos($usu, $pass)
    {
        $datos = [];

        $sent1 = '  SELECT  g.basedatos FROM gerente g , empleados e
                        WHERE g.idGerente=e.idGerente AND ( (e.usuario= :usu AND e.password = :pass) OR
                                                            (g.usuario= :usu AND g.password = :pass));
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
            $newConex = new Funciones_en_BBDD($bd, 'root2', '','localhost');
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

    //registro del empleado y gerente 
    function registrarGer_Emp($datosEnt)
    {
        $id = null;
        $usuario = null;
        $respuesta = null;
        $cargos = ['gerente', 'empleados'];
        $nombreApellido = explode(' ', $datosEnt->usuario_contacto);
        $nameBD_o_IdGerente = str_replace(' ', '_', (ltrim($datosEnt->usuario_nick_registro)));
        $usuariosRegistrados_2 = [];
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
            $sentPre->bindParam(6, $datosEnt->telefono, PDO::PARAM_STR);
            $sentPre->bindParam(7, $datosEnt->usuario_direccion, PDO::PARAM_STR);
            $sentPre->bindParam(8, $nameBD_o_IdGerente, PDO::PARAM_STR);
            $sentPre->bindParam(9, $usuario, PDO::PARAM_STR);
            $sentPre->bindParam(10, $datosEnt->usuario_password_registro, PDO::PARAM_STR);
            $sentPre->execute();
            if ($sentPre->rowCount() > 0) $usuariosRegistrados_2[$i] = $usuario;
        }

        if (count($usuariosRegistrados_2) === 2 && $this->registrarUsuarios($usuariosRegistrados_2)) {
            $respuesta = "Tablas de datos generadas, usuario gerente y empleado generados, sus credenciales se enviaran por mail";
            //echo $respuesta;
        } else {
            /*printf($usuario);
            print_r($datosEnt); */
            //echo "   paso por aqui";
            if (count($usuariosRegistrados_2) === 2) {
                $respuesta = "Usuarios, empleado y gerente, insertados en sus respectivas tablas";
               // echo "paso por el segundo registro";
            }
        }

        return $respuesta;
    }

    function registrarUsuarios($usuarioGR_EM)
    {
        $grabadoEnBBDD = null;
        if (count($usuarioGR_EM) === 2) {
            for ($i = 0; $i < count($usuarioGR_EM); $i++) {
                $grabadoEnBBDD = false;
                $sql = 'INSERT INTO billmaker.acceso VALUES (?)';
                $sentPre = $this->conexion->prepare($sql);
                $sentPre->bindParam(1, $usuarioGR_EM[$i], PDO::PARAM_STR);
                $sentPre->execute();
                if ($sentPre->rowCount() > 0) $grabadoEnBBDD = true;
            }
        }
        return $grabadoEnBBDD;
    }
    // funcion que devuelve los proveedores para el listadp de productos externos en
    function proveedoresProdExter(){
        $packEncioEnt = null;
        //$sql = 'SELECT nombre, nif FROM preveedor ';
        // vamos a utilizar como ejemplo a gerente de billmaker es la unica bbdd que tiene registros;
        $sql ='SELECT nombre, dni FROM billmaker.gerente';
        $sentencia = $this->conexion->query($sql);
        $packEncioEnt = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $packEncioEnt;
    }

    //funcion filtra solicitante de vista_list
    function identificaLista_vita($solicitante){
        switch ($solicitante) {
            case 'clientes':
                # code...
                break;
            case 'empleados':
                # code...
                break;
            case 'facturas':
                # code...
                break;
            case 'presupuestos':
                # code...
                break;
            case 'servicios':
                # code...
                break;
            
            default:
                # code...
                break;
        }
    }

    //esta funcion estrae las datos de la tabla que le pasemos
    function datosLista_vista($tabla){
    
        

    }

    // esta funcion solo es de prueba no sirv epara nada mas
    function consultaPrueba()
    {
        $query = $this->conexion->query('show tables');
        return ($query->rowCount());
    }

}
