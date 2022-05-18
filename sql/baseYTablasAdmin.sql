
-- -----------------------------------------------------
-- Schema billmaker
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table `GERENTE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `GERENTE` (
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
-- Table `EMPLEADO`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `EMPLEADO` (
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
-- Table `ACCESO`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ACCESO` (
  `usuario` VARCHAR(45) NOT NULL,
  UNIQUE INDEX `usuarioGerente_UNIQUE` (`usuario` ASC))
;


-- -----------------------------------------------------
-- Data for table `GERENTE`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO GERENTE  VALUES ('brfsd52', 'pedro', 'axz', '5276142a', 'studyehoshua@gmddail.com', 'calle falsa 123', 'billMaker', 'yehosddhua_g@bill-maddker.com', 'password');

COMMIT;


-- -----------------------------------------------------
-- Data for table `EMPLEADO`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `EMPLEADO`  VALUES ('BMEM000', 'Yehoshua', DEFAULT, '523641258a', 'studyehoshua@gmail.com', 'calle fasa 3',  'BMGR000', 'yehoshua_emp@bill-maker.com', 'password');

COMMIT;


-- -----------------------------------------------------
-- Data for table `ACCESO`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `ACCESO` (`usuario`) VALUES ('yehoshua_g@bill-maker.com');
INSERT INTO `ACCESO` (`usuario`) VALUES ('yehoshua_emp@bill-maker.com');

COMMIT;

