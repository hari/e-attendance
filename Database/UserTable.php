<?php namespace Attendance\Database;

/**
 */
class UserTable extends AbstractTable {

  protected static $instance;

  private function __construct() {
    $this->table_name = 'users';
  }

  public function create() {
    $sql = "CREATE TABLE IF NOT EXISTS `" . $this->getTableName() . "` (
           `id` INT NOT NULL AUTO_INCREMENT ,
           `full_name` VARCHAR(50) NOT NULL ,
           `password` VARCHAR(200) NOT NULL ,
           `batch` INT(4) NOT NULL ,
           `semester` INT(1) NOT NULL ,
           `reg_no` VARCHAR(10) NOT NULL UNIQUE ,
           `created_by` INT NOT NULL ,
           `created_on` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
           `role` INT NOT NULL ,
           PRIMARY KEY (`id`))";
    return $this->execute($sql);
  }

  public static function getInstance() {
    if (self::$instance == null) {
      self::$instance = new self;
    }
    return self::$instance;
  }

}