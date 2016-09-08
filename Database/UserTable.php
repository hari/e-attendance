<?php namespace Attendance\Database;

/**
 * ---------------------------------------------------------------
 * | id | name | batch | reg_no | created_by | role | created_on |
 * ---------------------------------------------------------------
 */
class UserTable implements TableInterface {

  public static function create() {
    $sql = "CREATE TABLE IF NOT EXISTS `users` (
           `id` INT NOT NULL AUTO_INCREMENT ,
           `full_name` VARCHAR(50) NOT NULL ,
           `batch` INT(4) NOT NULL ,
           `reg_no` VARCHAR(10) NOT NULL ,
           `created_by` INT NOT NULL ,
           `created_on` TIMESTAMP(10) NOT NULL DEFAULT CURRENT_TIMESTAMP ,
           `role` INT NOT NULL ,
           PRIMARY KEY (`id`))";
  }

  public static function destroy() {
    
  }

}