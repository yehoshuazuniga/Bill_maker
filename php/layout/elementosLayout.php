
<?php
//print( __DIR__);
class Menus
{

    static function menuGerente()
    {
?>
        <li><a class=" my-2 rounded-pill btn btn-outline-dark bg-gradient fw-bolder " href="./inicio.php">Inicio</a></li>
        <li><a class=" my-2 rounded-pill btn btn-outline-dark bg-gradient fw-bolder " href="./empleados.php">Empleados</a></li>
        <li><a class=" my-2 rounded-pill btn btn-outline-dark bg-gradient fw-bolder " href="./proveedores.php">Proveedores</a></li>
        <li><a class=" my-2 rounded-pill btn btn-outline-dark bg-gradient fw-bolder " href="./servicios.php">Servicios</a></li>
    <?php
    }

    static function menuEmpleado()
    {
    ?>
        <li><a class=" my-2 rounded-pill btn btn-outline-dark bg-gradient fw-bolder " href="./inicio.php">Inicio</a></li>
        <li><a class=" my-2 rounded-pill btn btn-outline-dark bg-gradient fw-bolder " href="./clientes.php">Clientes</a></li>
        <li><a class=" my-2 rounded-pill btn btn-outline-dark bg-gradient fw-bolder " href="./facturas.php">Facturas</a></li>
        <li><a class=" my-2 rounded-pill btn btn-outline-dark bg-gradient fw-bolder " href="./presupuestos.php">Presupuestos</a></li>
    <?php
    }


 
    function tablas($tablasDelServ)
    {
    }
}
