-- MySQL Script generated by MySQL Workbench
-- sob 21 dec 2019 16:29:09 CET
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema baza
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema baza
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `baza` DEFAULT CHARACTER SET utf8 ;
USE `baza` ;

-- -----------------------------------------------------
-- Table `baza`.`naslov`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `baza`.`naslov` ;

CREATE TABLE IF NOT EXISTS `baza`.`naslov` (
  `id_naslov` INT(11) NOT NULL AUTO_INCREMENT,
  `postna_stevilka` INT(20) NOT NULL,
  `mesto` VARCHAR(45) NOT NULL,
  `ulica` VARCHAR(45) NOT NULL,
  `hisna_stevilka` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_naslov`),
  UNIQUE INDEX `id_naslov_UNIQUE` (`id_naslov` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `baza`.`uporabnik`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `baza`.`uporabnik` ;

CREATE TABLE IF NOT EXISTS `baza`.`uporabnik` (
  `id_uporabnik` INT(11) NOT NULL AUTO_INCREMENT,
  `ime` VARCHAR(45) NOT NULL,
  `priimek` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `geslo` VARCHAR(45) NOT NULL,
  `telefon` VARCHAR(45) NULL,
  `status` VARCHAR(45) NOT NULL,
  `uloga` VARCHAR(45) NOT NULL,
  `fk_id_naslov` INT(11) NULL,
  PRIMARY KEY (`id_uporabnik`),
  UNIQUE INDEX `id_uporabnik_UNIQUE` (`id_uporabnik` ASC),
  INDEX `fk_uporabnik_naslov_idx` (`fk_id_naslov` ASC),
  CONSTRAINT `fk_id_naslov`
    FOREIGN KEY (`fk_id_naslov`)
    REFERENCES `baza`.`naslov` (`id_naslov`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `baza`.`kosarica`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `baza`.`kosarica` ;

CREATE TABLE IF NOT EXISTS `baza`.`kosarica` (
  `id_kosarica` INT(11) NOT NULL AUTO_INCREMENT,
  `datum` DATETIME NOT NULL,
  `status` VARCHAR(45) NOT NULL,
  `fk_id_uporabnik` INT(11) NULL,
  UNIQUE INDEX `id_narocilo_UNIQUE` (`id_kosarica` ASC),
  PRIMARY KEY (`id_kosarica`),
  INDEX `fk_narocilo_uporabnik1_idx` (`fk_id_uporabnik` ASC),
  CONSTRAINT `fk_id_uporabnik`
    FOREIGN KEY (`fk_id_uporabnik`)
    REFERENCES `baza`.`uporabnik` (`id_uporabnik`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `baza`.`avto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `baza`.`avto` ;

CREATE TABLE IF NOT EXISTS `baza`.`avto` (
  `id_avto` INT(11) NOT NULL AUTO_INCREMENT,
  `marka` VARCHAR(45) NOT NULL,
  `cena` INT(20) NOT NULL,
  `slika` VARCHAR(100) NOT NULL,
  `aktiven` INT(1) NOT NULL,
  PRIMARY KEY (`id_avto`),
  UNIQUE INDEX `id_avto_UNIQUE` (`id_avto` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `baza`.`narocen_avto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `baza`.`narocen_avto` ;

CREATE TABLE IF NOT EXISTS `baza`.`narocen_avto` (
  `kolicina` INT(11) NOT NULL,
  `fk_id_kosarica` INT(11) NULL,
  `fk_id_avto` INT(11) NULL,
  INDEX `fk_narocen_avto_avto1_idx` (`fk_id_avto` ASC),
  INDEX `fk_id_kosarica` (`fk_id_kosarica` ASC),
  CONSTRAINT `fk_id_kosarica`
    FOREIGN KEY (`fk_id_kosarica`)
    REFERENCES `baza`.`kosarica` (`id_kosarica`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_id_avto`
    FOREIGN KEY (`fk_id_avto`)
    REFERENCES `baza`.`avto` (`id_avto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `baza`.`naslov`
-- -----------------------------------------------------
START TRANSACTION;
USE `baza`;
INSERT INTO `baza`.`naslov` (`id_naslov`, `postna_stevilka`, `mesto`, `ulica`, `hisna_stevilka`) VALUES (DEFAULT, 1000, 'Ljubljana', 'Neubergerjeva', '21');
INSERT INTO `baza`.`naslov` (`id_naslov`, `postna_stevilka`, `mesto`, `ulica`, `hisna_stevilka`) VALUES (DEFAULT, 1000, 'Ljubljana', 'Kolajbova', '22');
INSERT INTO `baza`.`naslov` (`id_naslov`, `postna_stevilka`, `mesto`, `ulica`, `hisna_stevilka`) VALUES (DEFAULT, 1000, 'Ljubljana', 'Dvorakova', '6');
INSERT INTO `baza`.`naslov` (`id_naslov`, `postna_stevilka`, `mesto`, `ulica`, `hisna_stevilka`) VALUES (DEFAULT, 2000, 'Maribor', 'Velika ulica', '56');
INSERT INTO `baza`.`naslov` (`id_naslov`, `postna_stevilka`, `mesto`, `ulica`, `hisna_stevilka`) VALUES (DEFAULT, 2000, 'Maribor', 'Slovenska', '142');
INSERT INTO `baza`.`naslov` (`id_naslov`, `postna_stevilka`, `mesto`, `ulica`, `hisna_stevilka`) VALUES (DEFAULT, 3000, 'Kranj', 'Titova cesta', '79');

COMMIT;


-- -----------------------------------------------------
-- Data for table `baza`.`uporabnik`
-- -----------------------------------------------------
START TRANSACTION;
USE `baza`;
INSERT INTO `baza`.`uporabnik` (`id_uporabnik`, `ime`, `priimek`, `email`, `geslo`, `telefon`, `status`, `uloga`, `fk_id_naslov`) VALUES (DEFAULT, 'Admin', 'Adminovic', 'admin@gmail.com', 'Admin123', NULL, 'aktiven', 'admin', NULL);
INSERT INTO `baza`.`uporabnik` (`id_uporabnik`, `ime`, `priimek`, `email`, `geslo`, `telefon`, `status`, `uloga`, `fk_id_naslov`) VALUES (DEFAULT, 'Martin', 'Arsovski', 'martin@gmail.com', 'Martin123', NULL, 'aktiven', 'prodajalec', NULL);
INSERT INTO `baza`.`uporabnik` (`id_uporabnik`, `ime`, `priimek`, `email`, `geslo`, `telefon`, `status`, `uloga`, `fk_id_naslov`) VALUES (DEFAULT, 'Emil', 'Batakliev', 'emil@gmail.com', 'Emil123', NULL, 'blokiran', 'prodajalec', NULL);
INSERT INTO `baza`.`uporabnik` (`id_uporabnik`, `ime`, `priimek`, `email`, `geslo`, `telefon`, `status`, `uloga`, `fk_id_naslov`) VALUES (DEFAULT, 'Maja', 'Nikoloska', 'maja@gmail.com', 'Maja123', NULL, 'aktiven', 'prodajalec', NULL);
INSERT INTO `baza`.`uporabnik` (`id_uporabnik`, `ime`, `priimek`, `email`, `geslo`, `telefon`, `status`, `uloga`, `fk_id_naslov`) VALUES (DEFAULT, 'Luka', 'Doncic', 'luka@gmail.com', 'Luka123', '030123123', 'aktiven', 'stranka', 1);
INSERT INTO `baza`.`uporabnik` (`id_uporabnik`, `ime`, `priimek`, `email`, `geslo`, `telefon`, `status`, `uloga`, `fk_id_naslov`) VALUES (DEFAULT, 'Goran', 'Dragic', 'goran@gmail.com', 'Gorannn', '070987987', 'aktiven', 'stranka', 2);
INSERT INTO `baza`.`uporabnik` (`id_uporabnik`, `ime`, `priimek`, `email`, `geslo`, `telefon`, `status`, `uloga`, `fk_id_naslov`) VALUES (DEFAULT, 'Ana', 'Novak', 'ana@gmail.com', 'Ana123', '030456456', 'blokiran', 'stranka', 3);

COMMIT;


-- -----------------------------------------------------
-- Data for table `baza`.`kosarica`
-- -----------------------------------------------------
START TRANSACTION;
USE `baza`;
INSERT INTO `baza`.`kosarica` (`id_kosarica`, `datum`, `status`, `fk_id_uporabnik`) VALUES (DEFAULT, '2020-01-08 22:34:04', 'neobdelano', 5);
INSERT INTO `baza`.`kosarica` (`id_kosarica`, `datum`, `status`, `fk_id_uporabnik`) VALUES (DEFAULT, '2019-11-27 09:36:11', 'potrjeno', 6);
INSERT INTO `baza`.`kosarica` (`id_kosarica`, `datum`, `status`, `fk_id_uporabnik`) VALUES (DEFAULT, '2019-12-18 11:11:45', 'stornirano', 6);
INSERT INTO `baza`.`kosarica` (`id_kosarica`, `datum`, `status`, `fk_id_uporabnik`) VALUES (DEFAULT, '2019-12-22 15:54:22', 'potrjeno', 7);

COMMIT;


-- -----------------------------------------------------
-- Data for table `baza`.`avto`
-- -----------------------------------------------------
START TRANSACTION;
USE `baza`;
INSERT INTO `baza`.`avto` (`id_avto`, `marka`, `cena`, `slika`, `aktiven`) VALUES (DEFAULT, 'bmw', 125000, 'bmw.png', 1);
INSERT INTO `baza`.`avto` (`id_avto`, `marka`, `cena`, `slika`, `aktiven`) VALUES (DEFAULT, 'audi', 115000, 'audi.png', 1);
INSERT INTO `baza`.`avto` (`id_avto`, `marka`, `cena`, `slika`, `aktiven`) VALUES (DEFAULT, 'opel', 25000, 'opel.png', 1);
INSERT INTO `baza`.`avto` (`id_avto`, `marka`, `cena`, `slika`, `aktiven`) VALUES (DEFAULT, 'honda', 20000, 'honda.png', 1);
INSERT INTO `baza`.`avto` (`id_avto`, `marka`, `cena`, `slika`, `aktiven`) VALUES (DEFAULT, 'ferrafi', 675400, 'ferrari.png', 1);
INSERT INTO `baza`.`avto` (`id_avto`, `marka`, `cena`, `slika`, `aktiven`) VALUES (DEFAULT, 'lamborghini', 567250, 'lamborghini.png', 1);

COMMIT;


-- -----------------------------------------------------
-- Data for table `baza`.`narocen_avto`
-- -----------------------------------------------------
START TRANSACTION;
USE `baza`;
INSERT INTO `baza`.`narocen_avto` (`kolicina`, `fk_id_kosarica`, `fk_id_avto`) VALUES (1, 1, 1);
INSERT INTO `baza`.`narocen_avto` (`kolicina`, `fk_id_kosarica`, `fk_id_avto`) VALUES (2, 2, 3);
INSERT INTO `baza`.`narocen_avto` (`kolicina`, `fk_id_kosarica`, `fk_id_avto`) VALUES (5, 1, 2);
INSERT INTO `baza`.`narocen_avto` (`kolicina`, `fk_id_kosarica`, `fk_id_avto`) VALUES (1, 3, 4);

COMMIT;

