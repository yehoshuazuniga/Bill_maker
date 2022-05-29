
-- -----------------------------------------------------
-- Schema billmaker
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table `gerente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gerente` (
  `idGerente` VARCHAR(7) NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `apellido` VARCHAR(45) NOT NULL,
  `dni` VARCHAR(10) NOT NULL,
  `email` VARCHAR(30) NOT NULL,
  `direccion` VARCHAR(45) NULL,
  `basedatos` VARCHAR(45) NOT NULL,
  `usuario` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idGerente`),
  UNIQUE INDEX `dni_UNIQUE` (`dni` ASC),
  UNIQUE INDEX `usuarioGerente_UNIQUE` (`usuario` ASC),
  UNIQUE INDEX `basedatos_UNIQUE` (`basedatos` ASC),
  UNIQUE INDEX `idGerente_UNIQUE` (`idGerente` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))

;


-- -----------------------------------------------------
-- Table `empleado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `empleado` (
  `idEmpleado` VARCHAR(7) NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `apellido` VARCHAR(45) NOT NULL,
  `dni` VARCHAR(10) NOT NULL,
  `email` VARCHAR(30) NOT NULL,
  `direccion` VARCHAR(45) NULL,
  `idGerente` VARCHAR(7) NOT NULL,
  `usuario` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idEmpleado`),
  UNIQUE INDEX `dni_UNIQUE` (`dni` ASC),
  UNIQUE INDEX `usuaarioEmpleado_UNIQUE` (`usuario` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
;


-- -----------------------------------------------------
-- Table `acceso``
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `acceso` (
  `usuario` VARCHAR(45) NOT NULL,
  UNIQUE INDEX `usuarioGerente_UNIQUE` (`usuario` ASC))
;


-- -----------------------------------------------------
-- Data for table `gerente`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO gerente  VALUES ('BMGR000', 'pedro', 'axz', '5276142a', 
'studyehoshua@gmddail.com', 'calle falsa 123', 'billMaker', 
'yehoshua_gt@bill-maker.com', 'password');

COMMIT;


-- -----------------------------------------------------
-- Data for table `empleado`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `empleado`  VALUES ('BMEM000', 'Yehoshua', 'DEFAULT', 
'523641258a', 'studyehoshua@gmail.com', 'calle fasa 3',  '
BMGR000', 'yehoshua_emp@bill-maker.com', 'password');

COMMIT;


-- -----------------------------------------------------
-- Data for table `acceso``
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `acceso` (`usuario`) VALUES ('yehoshua_gt@bill-maker.com');
INSERT INTO `acceso` (`usuario`) VALUES ('yehoshua_emp@bill-maker.com');

COMMIT;

