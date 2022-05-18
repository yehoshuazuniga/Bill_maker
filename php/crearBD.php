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

        $sql = "CREATE TABLE IF NOT EXISTS GERENTE (
                idGerente VARCHAR(7) NOT NULL,
                nombre VARCHAR(45) NOT NULL,
                apellido VARCHAR(45) NOT NULL,
                dni VARCHAR(10) NOT NULL,
                email VARCHAR(30) NOT NULL,
                direccion VARCHAR(45) NULL,
                basedatos VARCHAR(45) NOT NULL,
                usuario VARCHAR(45) NOT NULL,
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

        $sql = "CREATE TABLE IF NOT EXISTS EMPLEADO (
                idEmpleado VARCHAR(7) NOT NULL,
                Nombre VARCHAR(45) NOT NULL,
                apellido VARCHAR(45) NOT NULL,
                dni VARCHAR(10) NOT NULL,
                email VARCHAR(30) NOT NULL,
                direccion VARCHAR(45) NULL,
                idGerente VARCHAR(7) NOT NULL,
                usuario VARCHAR(45) NOT NULL,
                password VARCHAR(45) NOT NULL,
                PRIMARY KEY (idEmpleado),
                UNIQUE INDEX dni_UNIQUE (dni ASC),
                UNIQUE INDEX usuaarioEmpleado_UNIQUE (usuario ASC),
                UNIQUE INDEX email_UNIQUE (email ASC))";

        $enlace->query($sql);
        // if(!$sentencia)
    }
    function tablaClientes($enlace)
    {
        //  $this->conexion = new mysqli('localhost', 'banco', '', 'banco');

        $sql = "CREATE TABLE IF NOT EXISTS CLIENTES (
                nif VARCHAR(10) NOT NULL,
                nombreEmpresa VARCHAR(45) NOT NULL,
                direccion VARCHAR(45) NULL,
                email VARCHAR(45) NOT NULL,
                telefono VARCHAR(9) NOT NULL,
                personaContacto VARCHAR(45) NULL,
                PRIMARY KEY (nif),
                UNIQUE INDEX nif_UNIQUE (nif ASC))
                 ";

        $enlace->query($sql);
        // if(!$sentencia)
    }
    function tablaServicios($enlace)
    {
        //  $this->conexion = new mysqli('localhost', 'banco', '', 'banco');

        $sql = "CREATE TABLE IF NOT EXISTS SERVICIOS (
                idServicios VARCHAR(7) NOT NULL,
                idProducto VARCHAR(7) NULL,
                nombre VARCHAR(45) NOT NULL,
                descripcion VARCHAR(45) NOT NULL,
                precio INT NOT NULL,
                PRIMARY KEY (idServicios),
                UNIQUE INDEX idServicios_UNIQUE (idServicios ASC))
                ";

        $enlace->query($sql);
        // if(!$sentencia)
    }
    function tablaProducExter($enlace)
    {
        //  $this->conexion = new mysqli('localhost', 'banco', '', 'banco');

        $sql = "CREATE TABLE IF NOT EXISTS PRODUCTOS_EXTERNOS (
                idProducto VARCHAR(7) NOT NULL,
                nifProveedor VARCHAR(10) NOT NULL,
                nombre VARCHAR(45) NOT NULL,
                descripcion VARCHAR(45) NOT NULL,
                precio INT NOT NULL,
                PRIMARY KEY (idProducto),
                UNIQUE INDEX idCliente_UNIQUE (idProducto ASC))
                ";

        $enlace->query($sql);
        // if(!$sentencia)
    }
    function tablaProveedor($enlace)
    {
        //  $this->conexion = new mysqli('localhost', 'banco', '', 'banco');

        $sql = "CREATE TABLE IF NOT EXISTS PROVEEDOR (
                nif VARCHAR(10) NOT NULL,
                nombre VARCHAR(45) NOT NULL,
                direccion VARCHAR(45) NULL,
                email VARCHAR(45) NOT NULL,
                telefono VARCHAR(9) NOT NULL,
                personaContacto VARCHAR(45) NULL,
                PRIMARY KEY (nif),
                UNIQUE INDEX nif_UNIQUE (nif ASC))
                ";

        $enlace->query($sql);
        // if(!$sentencia)
    }
    function tablaFondos($enlace)
    {
        //  $this->conexion = new mysqli('localhost', 'banco', '', 'banco');

        $sql = "CREATE TABLE IF NOT EXISTS FONDOS (
                idProducto VARCHAR(7) NOT NULL,
                idFactura VARCHAR(7) NOT NULL,
                ingresos INT NOT NULL,
                gastos INT NOT NULL,
                arcas INT NOT NULL,
                UNIQUE INDEX idFactura_UNIQUE (idFactura ASC),
                UNIQUE INDEX idProducto_UNIQUE (idProducto ASC))
                ";

        $enlace->query($sql);
        // if(!$sentencia)
    }
    function tablaFacturas($enlace)
    {
        //  $this->conexion = new mysqli('localhost', 'banco', '', 'banco');

        $sql = "CREATE TABLE IF NOT EXISTS FACTURAS (
                idFacturas VARCHAR(7) NOT NULL,
                nif VARCHAR(10) NOT NULL,
                idServicios VARCHAR(7) NOT NULL,
                idEmpleado VARCHAR(7) NOT NULL,
                idPresupuesto VARCHAR(45) NULL,
                precioTotalSinIva INT NOT NULL,
                fechaCreacion DATETIME NOT NULL,
                PRIMARY KEY (idFacturas),
                UNIQUE INDEX idFacturas_UNIQUE (idFacturas ASC),
                UNIQUE INDEX nif_UNIQUE (nif ASC),
                UNIQUE INDEX idEmpleado_UNIQUE (idEmpleado ASC),
                CONSTRAINT nif
                    FOREIGN KEY (nif)
                    REFERENCES CLIENTES (nif)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION)
                ";

        $enlace->query($sql);
        // if(!$sentencia)
    }
    function tablaPresupuestos($enlace)
    {
        //  $this->conexion = new mysqli('localhost', 'banco', '', 'banco');

        $sql = "CREATE TABLE IF NOT EXISTS PRESUPUESTO (
                idPresupuesto VARCHAR(7) NOT NULL,
                nifCliente VARCHAR(10) NOT NULL,
                idServicios VARCHAR(7) NOT NULL,
                idEmpleado VARCHAR(7) NOT NULL,
                precio INT NOT NULL,
                fechaCreacion DATETIME NOT NULL,
                PRIMARY KEY (idPresupuesto),
                UNIQUE INDEX idCliente_UNIQUE (nifCliente ASC),
                UNIQUE INDEX idEmpleado_UNIQUE (idEmpleado ASC),
                CONSTRAINT nifCliente
                    FOREIGN KEY (nifCliente)
                    REFERENCES CLIENTES (nif)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION)
                ";

        $enlace->query($sql);
        // if(!$sentencia)
    }
    function tabalaAcceso($enlace)
    {
        //  $this->conexion = new mysqli('localhost', 'banco', '', 'banco');

        $sql = "CREATE TABLE IF NOT EXISTS ACCESO (
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
        $this->tablaServicios($enlace);
        $this->tablaProducExter($enlace);
        $this->tablaProveedor($enlace);
        $this->tablaFondos($enlace);
        $this->tablaFacturas($enlace);
        $this->tablaPresupuestos($enlace);
        $this->tabalaAcceso($enlace);
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