-- MySQL Script generated by MySQL Workbench
-- ven. 08 mars 2019 12:24:20 CET
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema LeBlog
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema LeBlog
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table `b_categorie`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `b_categorie` (
  `c_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `c_title` VARCHAR(255) NULL,
  `c_parent_cat` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`c_id`),
  INDEX `fk_b_categorie_b_categorie1_idx` (`c_parent_cat` ASC),
  CONSTRAINT `fk_b_categorie_b_categorie1`
    FOREIGN KEY (`c_parent_cat`)
    REFERENCES `b_categorie` (`c_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `b_user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `b_user` (
  `u_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `u_nom` VARCHAR(255) NULL,
  `u_prenom` VARCHAR(255) NULL,
  `u_email` VARCHAR(255) NULL,
  `u_password` VARCHAR(255) NULL,
  `u_valide` VARCHAR(255) NULL DEFAULT 1,
  `b_usercol` VARCHAR(45) NULL,
  PRIMARY KEY (`u_id`),
  UNIQUE INDEX `u_email_UNIQUE` (`u_email` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `b_article`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `b_article` (
  `a_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `a_titre` VARCHAR(255) NULL,
  `a_date_publication` DATETIME NULL,
  `a_contenu` MEDIUMTEXT NULL,
  `a_image` VARCHAR(255) NULL,
  `b_categorie_c_id` INT UNSIGNED NOT NULL,
  `a_auteur` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`a_id`),
  INDEX `fk_b_article_b_categorie_idx` (`b_categorie_c_id` ASC),
  INDEX `fk_b_article_b_user1_idx` (`a_auteur` ASC),
  CONSTRAINT `fk_b_article_b_categorie`
    FOREIGN KEY (`b_categorie_c_id`)
    REFERENCES `b_categorie` (`c_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_b_article_b_user1`
    FOREIGN KEY (`a_auteur`)
    REFERENCES `b_user` (`u_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `b_comment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `b_comment` (
  `c_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `c_contenu` VARCHAR(45) NOT NULL,
  `c_pseudo` VARCHAR(100) NOT NULL,
  `c_email` VARCHAR(100) NOT NULL,
  `c_date_publi` DATETIME NOT NULL,
  `c_valide` TINYINT UNSIGNED NULL DEFAULT 1,
  `c_article` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`c_id`),
  INDEX `fk_b_comment_b_article1_idx` (`c_article` ASC),
  CONSTRAINT `fk_b_comment_b_article1`
    FOREIGN KEY (`c_article`)
    REFERENCES `b_article` (`a_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
