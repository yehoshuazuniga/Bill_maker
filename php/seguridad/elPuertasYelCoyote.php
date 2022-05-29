<?php

class PuertasYcoyote
{
    const SALT = 'biLlMakEr';

    //con seciones
    static function tockenSession($bd, $idPersonaje)
    {
        $cargo = null;
        $roll = 'roll';
        $bdName = array_pop($bd);
        $bbdd = 'BBDD';
        $id = array_shift($idPersonaje);
        $id = substr($id, 2, 2);
        $nombre = ucfirst(strtolower(array_shift($idPersonaje)));
        $apellido = array_pop($idPersonaje) == 'DEFAULT'?'': ucfirst(strtolower(array_shift($idPersonaje)));
        $usuario = trim($nombre . ' ' . $apellido);


        switch ($id) {
            case 'GR':
                $cargo = 'gerente';
                break;
            case 'EM':
                $cargo = 'empleado';
                break;

            default:
                $cargo = null;
                break;
        }
        if ($cargo != null && gettype($cargo) == 'string' && gettype($bdName) == 'string') {
            session_start();
            $_SESSION[$bbdd] = $bdName;
            $_SESSION[$roll] = $cargo;
            $_SESSION[$cargo] = $usuario;
        }
    }
    //hash
    public static function passHash($password)
    {
        return hash('sha512', self::SALT . $password);
    }
    //identidy hass
    public static  function verificarPass($hassBBDD, $passwordEnt)
    {
        return ($hassBBDD == self::passHash($passwordEnt));
    }

    public static function filtrado($texto)
    {
        $texto = trim($texto);
        $texto = htmlspecialchars($texto);
        $texto = stripslashes($texto);
        return $texto;
    }
   
    static function validadcionSesiones(){
        if(count($_SESSION)!==3 && !isset($_SESSION['roll']) && 
        (!isset($_SESSION['empleado']) || !isset($_SESSION['gerente']) && 
        !isset($_SESSION['BBDD']))){
            header('Location: index.php');
        }
    }


    function cerrarSesion()
    {
        $estado = false;
        $_SESSION = array();
        setcookie('PHPSESSID', '', time() - 1);
        session_destroy();
        if (count($_SESSION) <= 0) {
            $estado = true;
        }
        return $estado;
    }
}/*
-----------+--------+----------+-----------+--------------------------+-----------------+---------------+------------------------------------+---------------+
| idGerente | nombre | apellido | dni       | email                    | direccion       | basedatos     | usuario                            | password      |
+-----------+--------+----------+-----------+--------------------------+-----------------+---------------+------------------------------------+---------------+
| brfsd52   | pedro  | axz      | 5276142a  | studyehoshua@gmddail.com | calle falsa 123 | billMaker     | yehosddhua_g@bill-maddker.com      | password      |
| DPGT92    | Juan   | alfonoso | g85963641 | mabel.munoz@gmail.com    | c/dancing power | dancing_power | juan.alfonoso_gt@dancing-power.com | dancing power |
+-----------+--------+----------+-----------+--------------------------+-----------------+---------------+------------------------------------+---------------*/