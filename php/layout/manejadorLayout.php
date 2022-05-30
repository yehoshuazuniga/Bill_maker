<?php
include './php/layout/elementosLayout.php';
class ControladorMenus extends Menus
{

    static function menuCorrespontienteUsuarios()
    {
    }

    static function menuCorrespontienteCargos()
    {
        if (isset($_SESSION['roll'])) {
            switch ($_SESSION['roll']) {
                case 'empleado' && isset($_SESSION['empleado']):
                    parent::menuEmpleado();
                    break;
                case 'gerente'&& isset($_SESSION['gerente']):
                    parent::menuGerente();
                    break;
            }
        }
    }

    static function seguridadFunciones(){

    }

    static function menUsuario()
    {

    ?>
        <li class="nav-link text-dark"><?php echo ucfirst($_SESSION['roll']) . ': ' . $_SESSION[$_SESSION['roll']] ?></li>
        <li class="nav-link text-dark "><a class="link-dark text-decoration-none" href="./configuracionUsuario.php" >Configuracion Usuario</a></li>
        <li class="nav-link text-dark cerrarSesion" id="cerrarSesion">Cerrar sesion</li>
    <?php
    }
}
