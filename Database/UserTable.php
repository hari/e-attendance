<?php namespace Attendance\Database;

/**
 * ---------------------------------------------------------------
 * | id | name | batch | reg_no | created_by | role | created_on |
 * ---------------------------------------------------------------
 */
class UserTable extends AbstractTable {

  public function __construct() {
    $this->table_name = 'users';
  }

  public function create() {
    $sql = "CREATE TABLE IF NOT EXISTS `" . $this->getTableName() . "` (
           `id` INT NOT NULL AUTO_INCREMENT ,
           `full_name` VARCHAR(50) NOT NULL ,
           `batch` INT(4) NOT NULL ,
           `reg_no` VARCHAR(10) NOT NULL ,
           `created_by` INT NOT NULL ,
           `created_on` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
           `role` INT NOT NULL ,
           PRIMARY KEY (`id`))";
    return $this->execute($sql);
  }

}