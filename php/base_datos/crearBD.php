<?php
header("Content-Type: application/json; charset=UTF-8");

class BBDD
{


    function crearBd($dbase)
    {
        $this->conexion->query("CREATE DATABASE $dbase");
        //$this->conexion = null;
        $con = new PDO("mysql:host=$this->h; dbname=$dbase", $this->usu, $this->pw);
        return $con;
    }


    // creacion de tablas;
    function tablaGerente($enlace)
    {
        //  $this->conexion = new mysqli('localhost', 'banco', '', 'banco');

        $sql = "CREATE TABLE IF NOT EXISTS gerente (
                idGerente VARCHAR(7) NOT NULL,
                nombre VARCHAR(45) NOT NULL,
                apellido VARCHAR(45) NOT NULL,
                dni VARCHAR(10) NOT NULL,
                email VARCHAR(65) NOT NULL,
                telefono VARCHAR(9) NULL,
                direccion VARCHAR(45) NULL,
                basedatos VARCHAR(45) NOT NULL,
                usuario VARCHAR(65) NOT NULL,
                password VARCHAR(45) NOT NULL,
                PRIMARY KEY (idGerente),
                UNIQUE INDEX dni_UNIQUE (dni ASC),
                UNIQUE INDEX usuarioGerente_UNIQUE (usuario ASC),
                UNIQUE INDEX basedatos_UNIQUE (basedatos ASC),
                UNIQUE INDEX idGerente_UNIQUE (idGerente ASC),
                UNIQUE INDEX email_UNIQUE (email ASC))
                ";

        $enlace->query($sql);
        // if(!$sentencia)
    }
    function tablaEmpleado($enlace)
    {
        //  $this->conexion = new mysqli('localhost', 'banco', '', 'banco');

        $sql = "CREATE TABLE IF NOT EXISTS `empleados` (
                `idEmpleado` VARCHAR(7) NOT NULL,
                `nombre` VARCHAR(45) NOT NULL,
                `apellido` VARCHAR(45) NOT NULL,
                `dni` VARCHAR(10) NOT NULL,
                `email` VARCHAR(65) NOT NULL,
                `telefono` VARCHAR(9) NULL,
                `direccion` VARCHAR(45) NULL,
                `idGerente` VARCHAR(7) NOT NULL,
                `usuario` VARCHAR(65) NOT NULL,
                `password` VARCHAR(45) NOT NULL,
                PRIMARY KEY (`idEmpleado`),
                UNIQUE INDEX `dni_UNIQUE` (`dni` ASC),
                UNIQUE INDEX `usuaarioEmpleado_UNIQUE` (`usuario` ASC),
                INDEX `idGerente_idx` (`idGerente` ASC),
                UNIQUE INDEX `email_UNIQUE` (`email` ASC),
                CONSTRAINT `idGerente`
                    FOREIGN KEY (`idGerente`)
                    REFERENCES `gerente` (`idGerente`)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION)
        ";

        $enlace->query($sql);
        // if(!$sentencia)
    }
    function tablaClientes($enlace)
    {
        //  $this->conexion = new mysqli('localhost', 'banco', '', 'banco');

        $sql = "CREATE TABLE IF NOT EXISTS clientes (
                dni VARCHAR(10) NOT NULL,
                nombreEmpresa VARCHAR(45) NOT NULL,
                direccion VARCHAR(45) NULL,
                email VARCHAR(45) NOT NULL,
                telefono VARCHAR(9) NOT NULL,
                personaContacto VARCHAR(45) NULL,
                PRIMARY KEY (dni),
                UNIQUE INDEX dni_UNIQUE (dni ASC))
                ";

        $enlace->query($sql);
        // if(!$sentencia)
    }
    function tablaProveedor($enlace)
    {
        //  $this->conexion = new mysqli('localhost', 'banco', '', 'banco');

        $sql = "CREATE TABLE IF NOT EXISTS proveedores (
                dni VARCHAR(10) NOT NULL,
                nombre VARCHAR(45) NOT NULL,
                direccion VARCHAR(45) NULL,
                email VARCHAR(45) NOT NULL,
                telefono VARCHAR(9) NOT NULL,
                personaContacto VARCHAR(45) NULL,
                PRIMARY KEY (dni),
                UNIQUE INDEX dni_UNIQUE (dni ASC))
                ";

        $enlace->query($sql);
        // if(!$sentencia)
    }
    function tablaProducExter($enlace)
    {
        //  $this->conexion = new mysqli('localhost', 'banco', '', 'banco');

        $sql = "CREATE TABLE IF NOT EXISTS productos_externos (
                idProducto VARCHAR(7) NOT NULL,
                dniProveedor VARCHAR(10) NOT NULL,
                nombre VARCHAR(45) NOT NULL,
                descripcion VARCHAR(200) NOT NULL,
                precio INT NOT NULL,
                PRIMARY KEY (idProducto),
                UNIQUE INDEX idCliente_UNIQUE (idProducto ASC),
                INDEX dniProveedor_idx (dniProveedor ASC),
                CONSTRAINT dniProveedor
                    FOREIGN KEY (dniProveedor)
                    REFERENCES proveedores (dni)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION)";

        $enlace->query($sql);
        // if(!$sentencia)
    }
    function tablaServicios($enlace)
    {
        //  $this->conexion = new mysqli('localhost', 'banco', '', 'banco');

        $sql = "CREATE TABLE IF NOT EXISTS servicios (
                idServicios VARCHAR(7) NOT NULL,
                idProducto VARCHAR(7) NULL,
                nombre VARCHAR(45) NOT NULL,
                descripcion VARCHAR(200) NOT NULL,
                precio INT NOT NULL,
                PRIMARY KEY (idServicios),
                UNIQUE INDEX idServicios_UNIQUE (idServicios ASC),
                INDEX idProducto_idx (idProducto ASC),
                CONSTRAINT idProducto
                    FOREIGN KEY (idProducto)
                    REFERENCES productos_externos (idProducto)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION)";

        $enlace->query($sql);
        // if(!$sentencia)
    }
    function tablaPresupuestos($enlace)
    {
        //  $this->conexion = new mysqli('localhost', 'banco', '', 'banco');

        $sql = "CREATE TABLE IF NOT EXISTS presupuestos (
                idPresupuesto INT AUTO_INCREMENT,
                dniCliente VARCHAR(10) NOT NULL,
                idEmpleado VARCHAR(7) NOT NULL,
                precio INT NOT NULL,
                fechaCreacion DATE DEFAULT NOW(),
                PRIMARY KEY (idPresupuesto),
                UNIQUE INDEX idPresupuesto_UNIQUE (idPresupuesto ASC),
                CONSTRAINT idEmpleado
                    FOREIGN KEY (idEmpleado)
                    REFERENCES empleados (idEmpleado)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION,
                CONSTRAINT dniCliente
                    FOREIGN KEY (dniCliente)
                    REFERENCES clientes (dni)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION)
                    AUTO_INCREMENT = 227000
                    ";

        $enlace->query($sql);
        // if(!$sentencia)
    }
    function tablaFacturas($enlace)
    {
        //  $this->conexion = new mysqli('localhost', 'banco', '', 'banco');

        $sql =
        "CREATE TABLE IF NOT EXISTS facturas (
                idFacturas INT AUTO_INCREMENT,
                dni VARCHAR(10) NOT NULL,
                idEmpleado VARCHAR(7) NOT NULL,
                idPresupuesto INT NULL,
                precioTotalSinIva INT NOT NULL,
                fechaCreacion DATE DEFAULT NOW(),
                PRIMARY KEY (idFacturas),
                UNIQUE INDEX idFacturas_UNIQUE (idFacturas ASC),
                INDEX idPresupuesto_idx (idPresupuesto ASC),
                    FOREIGN KEY (idEmpleado)
                    REFERENCES empleados (idEmpleado)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION,
                    FOREIGN KEY (idPresupuesto)
                    REFERENCES presupuestos (idPresupuesto)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION,
                    FOREIGN KEY (dni)
                    REFERENCES clientes (dni)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION)
                    AUTO_INCREMENT = 223000
                    ";
        $enlace->query($sql);
        // if(!$sentencia)
    }
    function tablaFondos($enlace)
    {
        //  $this->conexion = new mysqli('localhost', 'banco', '', 'banco');

        $sql = "CREATE TABLE IF NOT EXISTS fondos (
                idProducto VARCHAR(7) NULL,
                idFactura INT NULL,
                ingresos INT NULL,
                gastos INT NULL,
                INDEX idProducto_idx (idProducto ASC),
                INDEX idFactura_idx (idFactura ASC),
                UNIQUE INDEX idFactura_UNIQUE (idFactura ASC),
                    FOREIGN KEY (idProducto)
                    REFERENCES productos_externos (idProducto)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION,
                    FOREIGN KEY (idFactura)
                    REFERENCES facturas (idFacturas)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION)
                ";

        $enlace->query($sql);
        // if(!$sentencia)
    }


    function tabalaAcceso($enlace)
    {
        //  $this->conexion = new mysqli('localhost', 'banco', '', 'banco');

        $sql = "CREATE TABLE IF NOT EXISTS acceso (
                usuario VARCHAR(45) NOT NULL,
                UNIQUE INDEX usuarioGerente_UNIQUE (usuario ASC))
                ";

        $enlace->query($sql);
        // if(!$sentencia)
    }

    function crearTablas($enlace)
    {
        $this->tablaGerente($enlace);
        $this->tablaEmpleado($enlace);
        $this->tablaClientes($enlace);
        $this->tablaProveedor($enlace);
        $this->tablaProducExter($enlace);
        $this->tablaServicios($enlace);
        $this->tablaPresupuestos($enlace);
        $this->tablaFacturas($enlace);
        $this->tablaFondos($enlace);
        // $this->tabalaAcceso($enlace);
    }


    function borrarBD($db)
    {
        $this->conexion->query("DROP DATABASE $db");
    }
}
/*$conex = crearDB::singleton();//se va a usar esta fuuncio para el resto de creaciones

$nuevaConex = $conex->crearBd('dancig_power');// esto crea la base de datos y devuelve una nueva conexcion a esa base de dato creada

$conex->crearTablas ($nuevaConex);
 echo str_replace(' ', '_', 'esto es una prueba');*/