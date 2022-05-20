
-- -----------------------------------------------------
-- Schema billmaker
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table GERENTE
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS gerente (
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
;


-- -----------------------------------------------------
-- Table EMPLEADO
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS empleado (
  idEmpleado VARCHAR(7) NOT NULL,
  idGerente VARCHAR(7) NOT NULL,
  nombre VARCHAR(45) NOT NULL,
  apellido VARCHAR(45) NOT NULL,
  dni VARCHAR(10) NOT NULL,
  email VARCHAR(30) NOT NULL,
  direccion VARCHAR(45) NULL,
  usuario VARCHAR(45) NOT NULL,
  password VARCHAR(45) NOT NULL,
  PRIMARY KEY (idEmpleado),
  UNIQUE INDEX dni_UNIQUE (dni ASC),
  UNIQUE INDEX usuaarioEmpleado_UNIQUE (usuario ASC),
  UNIQUE INDEX email_UNIQUE (email ASC))
;


-- -----------------------------------------------------
-- Table CLIENTES
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS clientes (
  nif VARCHAR(10) NOT NULL,
  nombreEmpresa VARCHAR(45) NOT NULL,
  direccion VARCHAR(45) NULL,
  email VARCHAR(45) NOT NULL,
  telefono VARCHAR(9) NOT NULL,
  personaContacto VARCHAR(45) NULL,
  PRIMARY KEY (nif),
  UNIQUE INDEX nif_UNIQUE (nif ASC))
;


-- -----------------------------------------------------
-- Table SERVICIOS
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS servicios (
  idServicios VARCHAR(7) NOT NULL,
  idProducto VARCHAR(7) NULL,
  nombre VARCHAR(45) NOT NULL,
  descripcion VARCHAR(45) NOT NULL,
  precio INT NOT NULL,
  PRIMARY KEY (idServicios),
  UNIQUE INDEX idServicios_UNIQUE (idServicios ASC))
;


-- -----------------------------------------------------
-- Table PRODUCTOS_EXTERNOS
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS productos_externos (
  idProducto VARCHAR(7) NOT NULL,
  nifProveedor VARCHAR(10) NOT NULL,
  nombre VARCHAR(45) NOT NULL,
  descripcion VARCHAR(45) NOT NULL,
  precio INT NOT NULL,
  PRIMARY KEY (idProducto),
  UNIQUE INDEX idCliente_UNIQUE (idProducto ASC))
;


-- -----------------------------------------------------
-- Table PROVEEDOR
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS proveedor (
  nif VARCHAR(10) NOT NULL,
  nombre VARCHAR(45) NOT NULL,
  direccion VARCHAR(45) NULL,
  email VARCHAR(45) NOT NULL,
  telefono VARCHAR(9) NOT NULL,
  personaContacto VARCHAR(45) NULL,
  PRIMARY KEY (nif),
  UNIQUE INDEX nif_UNIQUE (nif ASC))
;


-- -----------------------------------------------------
-- Table FONDOS
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS fondos (
  idProducto VARCHAR(7) NOT NULL,
  idFactura VARCHAR(7) NOT NULL,
  ingresos INT NOT NULL,
  gastos INT NOT NULL,
  arcas INT NOT NULL,
  UNIQUE INDEX idFactura_UNIQUE (idFactura ASC),
  UNIQUE INDEX idProducto_UNIQUE (idProducto ASC))
;


-- -----------------------------------------------------
-- Table FACTURAS
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS facturas (
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
;


-- -----------------------------------------------------
-- Table PRESUPUESTO
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS presupuesto (
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
;

-- -----------------------------------------------------
-- Data for table GERENTE
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO gerente (idGerente, nombre, apellido, dni, email, direccion, basedatos, usuario, password) VALUES ('BMGR000', 'Yehoshua', DEFAULT, '5236142a', 'studyehoshua@gmail.com', 'calle falsa 123', 'billMaker', 'yehoshua_g@bill-maker.com', 'password');

COMMIT;


-- -----------------------------------------------------
-- Data for table EMPLEADO
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO empleado (idEmpleado, idGerente, Nombre, apellido, dni, email, direccion, usuario, password) VALUES ('BMEM000', 'BMGR000', 'Yehoshua', DEFAULT, '523641258a', 'studyehoshua@gmail.com', 'calle fasa 3', 'yehoshua_emp@bill-maker.com', 'password');

COMMIT;






