
-- -----------------------------------------------------
-- Schema billmaker
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table gerente
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS gerente (
  idGerente VARCHAR(7) NOT NULL,
  nombre VARCHAR(45) NOT NULL,
  apellido VARCHAR(45) NOT NULL,
  dni VARCHAR(10) NOT NULL,
  email VARCHAR(65) NOT NULL,
  telefono VARCHAR(9) NULL,
  direccion VARCHAR(45) NULL,
  basedatos VARCHAR(45) NOT NULL,
  usuario VARCHAR(65) NOT NULL,
  password TEXT NOT NULL,
  estado VARCHAR(10) DEFAULT 'activo',
  PRIMARY KEY (idGerente),
  UNIQUE INDEX dni_UNIQUE (dni ASC),
  UNIQUE INDEX usuarioGerente_UNIQUE (usuario ASC),
  UNIQUE INDEX basedatos_UNIQUE (basedatos ASC),
  UNIQUE INDEX idGerente_UNIQUE (idGerente ASC),
  UNIQUE INDEX email_UNIQUE (email ASC))

;


-- -----------------------------------------------------
-- Table empleado
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS empleados (
  idEmpleado VARCHAR(7) NOT NULL,
  nombre VARCHAR(45) NOT NULL,
  apellido VARCHAR(45) NOT NULL,
  dni VARCHAR(10) NOT NULL,
  email VARCHAR(65) NOT NULL,
  telefono VARCHAR(9) NULL,
  direccion VARCHAR(45) NULL,
  idGerente VARCHAR(7) NOT NULL,
  usuario VARCHAR(65) NOT NULL,
  password TEXT NOT NULL,
  estado VARCHAR(10) DEFAULT 'activo',
  PRIMARY KEY (idEmpleado),
  UNIQUE INDEX dni_UNIQUE (dni ASC),
  UNIQUE INDEX usuaarioEmpleado_UNIQUE (usuario ASC),
  INDEX idGerente_idx (idGerente ASC),
  CONSTRAINT idGerente
  FOREIGN KEY (idGerente)
  REFERENCES gerente (idGerente)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION)
;

-- -----------------------------------------------------
-- Table acceso
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS acceso (
  usuario VARCHAR(45) NOT NULL,
  UNIQUE INDEX usuarioGerente_UNIQUE (usuario ASC))
;


-- -----------------------------------------------------
-- Data for table gerente
-- -----------------------------------------------------
