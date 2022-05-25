<?php
class PuertasYcoyote
{
    const SALT = 'biLlMakEr';

    //con seciones
    function tockerUsuario($idPersonaje)
    {
        session_start();

        //empleado EP
        //gerente GR
        $cod = substr(strtolower($idPersonaje), 2,4);
        $valor = 0;
        for($i=0 ; strlen($cod) ; $i++){
            $valor += ord($cod[$i]);
        }

        //evaluamos el valor y identifiamos el roll
        $_SESSION['nombre'] = "Laura";
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

    //tener en cnuenta las seciones
    public static function menusConTokens()
    {
        if (isset($_SESSION["roll"])) {


            if ($_SESSION['roll'] === 1/* aqui tiene que ir el rol del sujeto  gerente*/) {
                //self::menuGerente();
            } else if ($_SESSION{
                'roll'} === 1/* aqui tiene que ir el rol del sujeto  empleado*/) {
              //  self::menuEmpleado();
            }
        } else {
            /* redireccion a la pagina de registro */
        }
    }


    public static function filtrado($texto)
    {
        $texto = trim($texto);
        $texto = htmlspecialchars($texto);
        $texto = stripslashes($texto);
        return $texto;
    }

    function cerrarSecion(){
        
    }
}
