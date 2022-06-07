<?php
include __DIR__.'/elementosLayout.php';
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
                    Menus::menuEmpleado();
                    break;
                case 'gerente'&& isset($_SESSION['gerente']):
                    Menus::menuGerente();
                    break;
            }
        }
    }

    static function seguridadFunciones(){

    }

    static function menUsuario()
    {

    ?>
        <li class="nav-link btn btn-dark bg-gradient2 fw-normal text-white"><?php echo ucfirst($_SESSION['roll']) . ': ' . $_SESSION[$_SESSION['roll']] ?></li>
        <li class="nav-link btn btn-dark bg-gradient2 fw-normal text-white "><a class="link text-white text-decoration-none" href="./configuracionUsuario.php" >Configuracion Usuario</a></li>
        <li class="nav-link btn btn-dark bg-gradient2 fw-normal text-white cerrarSesion" id="cerrarSesion">Cerrar sesion</li>
    <?php
    }
}
