<?php
require './crearBD.php';
class DBB extends BBDD
{

    private $conexion;
    public static $instancia; // contenedor de la instancia 
    private $h;
    private $usu;
    private $pw;
    private function __construct($host = 'localhost', $usuario = 'root', $pass = '')
    {
        $this->h = $host;
        $this->usu = $usuario;
        $this->pw = $pass;
        try {
            $this->conexion = new PDO("mysql:host=$host", $usuario, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
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

    function verificarUsuario($usu, $pass)
    {
        $respuesta = false;
        $sql        = "SELECT *
                        FROM acceso
                        where usuario IN (
                            SELECT a.usuario
                            FROM gerente g , empleado e, acceso a
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
        $newConex = DBB::singleton();
        if ($bd !== 'billmaker') {
            $newConex = null;
            $newConex = new DBB('localhost', 'root', '', $bd);
        }
        $sentencia = "SELECT ? FROM $tabla  WHERE $whereParan = ?";
        $sentPre = $this->conexion->prepare($sentencia);
        $sentPre->bindParam(1, $selectParam, PDO::PARAM_STR);
        $sentPre->bindParam(2, $parametro, PDO::PARAM_STR);
        $sentPre->execute();
        if ($sentPre->rowCount() > 0) {
            $cambios = true;
           // echo 'existe';
        } else {
         //   echo ' no existe';
        }

        return $cambios;
    }
 
    function crearBDyTablas($nombreEmpresa)
    {
        $nombreBD = str_replace(' ', '_', $nombreEmpresa);

       // $conex = BBDD::singleton(); //se va a usar esta fuuncio para el resto de creaciones
        $nuevaConex = $this->crearBd($nombreBD); // esto crea la base de datos y devuelve una nueva conexcion a esa base de dato creada
        $this->crearTablas($nuevaConex);
    }
    //esta funcion esta vacia
    function parametroUsado($datosEnt)
    {

    

    }

    function registrarGerente($datosEnt)
    {
        //$con = new DBB('localhost', 'root', '', 'billmaker');
        $nombreApellido = explode(' ', $datosEnt->usuario_contacto);
        $respuesta = null;
        $nombreBD = str_replace(' ', '_', $datosEnt->usuario_nick_registro);
        $sql= 'INSERT INTO billmaker.gerente VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $sentPre = $this->conexion->prepare($sql);

        $sentPre->bindParam(1, $datosEnt->idGerente, PDO::PARAM_STR);
        $sentPre->bindParam(2, $nombreApellido[0], PDO::PARAM_STR);
        $sentPre->bindParam(3, $nombreApellido[1], PDO::PARAM_STR);
        $sentPre->bindParam(4, $datosEnt->usuario_cif, PDO::PARAM_STR);
        $sentPre->bindParam(5, $datosEnt->usuario_email, PDO::PARAM_STR);
        $sentPre->bindParam(6, $datosEnt->usuario_direccion, PDO::PARAM_STR);
        $sentPre->bindParam(7, $nombreBD, PDO::PARAM_STR);
        $sentPre->bindParam(8, $datosEnt->usuarioGerente, PDO::PARAM_STR);
        $sentPre->bindParam(9, $datosEnt->usuario_password_registro, PDO::PARAM_STR);
        //echo $datosEnt->usuario;

        $sentPre->execute();

        if($sentPre->rowCount() >0){
            echo 'se ha dado de alta  al gerente ';
        }else{
            
            echo 'Mail no valido, uso otro mail ';
        }
        $respuesta = $datosEnt->usuarioGerente; 
        return $respuesta;
    }

    //registro del empleado 
    function registrarGer_Emp($datosEnt)
    {
        $id = null;
        $usuario = null;
        $respuesta = [];
        $cargos = ['gerente', 'empleado'];
        $nombreApellido = explode(' ', $datosEnt->usuario_contacto);
        $nameBD_o_IdGerente =str_replace(' ', '_', $datosEnt->usuario_nick_registro);;


        for ($i=0; $i < count($cargos); $i++) {
            $sql = "INSERT INTO billmaker.$cargos[$i] VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $sentPre = $this->conexion->prepare($sql);

            if($i===0){
                $id = $datosEnt->idGerente;
                $usuario = $datosEnt->usuarioGerente;
            }else{
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
            $sentPre->bindParam(6, $datosEnt->usuario_direccion, PDO::PARAM_STR);
            $sentPre->bindParam(7, $nameBD_o_IdGerente, PDO::PARAM_STR);
            $sentPre->bindParam(8, $usuario, PDO::PARAM_STR);
            $sentPre->bindParam(9, $datosEnt->usuario_password_registro, PDO::PARAM_STR);
            //echo $datosEnt->usuario;

            $sentPre->execute();
            if ($sentPre->rowCount() > 0) {
                echo 'se ha dado de alta al empleado';
                $respuesta[$i] = $usuario;
            } else {

                echo 'Mail no valido, uso otro mail';
            }
        }
        return $respuesta;
    }

    function registrarUsuarios($datosEnt){

        $resultadoRegistros = [ $this->registrarGerente($datosEnt) ,$this->registrarGer_Emp($datosEnt)];


        if(count($resultadoRegistros)===2 ){
            for ($i=0; $i < count($resultadoRegistros); $i++) {
                $sql = 'INSERT INTO billmaker.acceso VALUES (?)';
                $sentPre = $this->conexion->prepare($sql);
                $sentPre->bindParam(1,$resultadoRegistros[$i],PDO::PARAM_STR);

            }        
        }

    }
}
//CUANDO PARAMOETRO SE PUEDE INTRODUCIR CON UNA SENTENCIA PREPARADA
$conex = DBB::singleton();
//$conex->verificarUsuario('yehoshua_g@bill-maker.com','password');
//$conex->sumarSaldo("85697123B", 1500);
if($conex->existeParametro('dni', 'cl_dni', '85697123B', 'banco', 'clientes')){
    echo 'se ejecuta';
}else{
    echo 'no se ejecuta';
}
if (isset($_POST['accesousuario'])) {
    //   $datosEnt=json_decode(str_replace('-','_', $_POST['accesousuario']));
    $datosEnt = json_decode($_POST['accesousuario']);
    echo json_encode($conex->verificarUsuario($datosEnt->usuario_nick, $datosEnt->usuario_password));
}


if (isset($_POST['nuevoUsuario'])) {
    $datosEnt = json_decode($_POST['nuevoUsuario']);
   //var_dump($datosEnt);
    if ($conex->existeParametro('dni', 'dni', $datosEnt->usuario_cif)) {
        echo json_encode('La empresa ya ha sido dada de alta');
    } else {
       $conex->crearBDyTablas($datosEnt->usuario_nick_registro);
      echo json_encode($conex->registrarGer_Emp($datosEnt));
        ////echo json_encode('se esta registrando');

        //echo json_encode('hola va todo bien');
    } 
    // var_dump($datosEnt);

}

//$conex->verificarUsuario('yehoshua_emp@bill-maker.com', 'passssword');
