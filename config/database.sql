create database vizinhocas;
create database vizinhocas_test;
    
GRANT ALL privileges ON vizinhocas.* TO coolmeia@localhost IDENTIFIED BY 'coolmeia';
GRANT ALL privileges ON vizinhocas_test.* TO coolmeia@localhost IDENTIFIED BY 'coolmeia';
 
use vizinhocas;

CREATE  TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(200) NOT NULL ,
  `password` VARCHAR(250) NOT NULL ,
  `name` VARCHAR(200) NULL ,
  `valid` TINYINT NULL ,
  `role` VARCHAR(20) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;
 
CREATE  TABLE IF NOT EXISTS `manifest` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(250) NOT NULL ,
  `description` TEXT NOT NULL ,
  `post_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;
 
CREATE  TABLE IF NOT EXISTS `intention` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `manifest_id` INT NOT NULL ,
  `description` TEXT NOT NULL ,
  `name` VARCHAR(200) NOT NULL ,
  `email` VARCHAR(250) NOT NULL ,
  `comment_date` TIMESTAMP NULL ,
  PRIMARY KEY (`id`, `manifest_id`) ,
  INDEX `fk_intention_manifest` (`manifest_id` ASC) ,
  CONSTRAINT `fk_intention_manifest`
    FOREIGN KEY (`manifest_id` )
    REFERENCES `manifest` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;