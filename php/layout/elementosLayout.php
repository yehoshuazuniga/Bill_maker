<?php
print( __DIR__);
class Menus
{

    static function menuGerente()
    {
?>
        <li><a class="link-dark" href="./inicio.php">inicio</a></li>
        <li><a class="link-dark" href="./empleados.php">Empleados</a></li>
        <li><a class="link-dark" href="./proveedores.php">Proveedores</a></li>
        <li><a class="link-dark" href="./servicios.php">Servicios</a></li>
    <?php
    }

    static function menuEmpleado()
    {
    ?>
        <li><a class="link-dark" href="./inicio.php">inicio</a></li>
        <li><a class="link-dark" href="./clientes.php">Clientes</a></li>
        <li><a class="link-dark" href="./facturas.php">Facturas</a></li>
        <li><a class="link-dark" href="./presupuestos.php">Presupuestos</a></li>
    <?php
    }


 
    function tablas($tablasDelServ)
    {
    }
}
