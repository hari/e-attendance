<?php namespace Attendance\Database;

/**
 * ---------------------------------------------------------
 * | id | reg_no | taken_by | subject | taken_on | remarks |
 * ---------------------------------------------------------
 */
class AttendanceTable extends AbstractTable {

  public function __construct() {
    $this->table_name = 'attendance';
  }

  public function create() {
    $sql = "CREATE TABLE IF NOT EXISTS `" . $this->getTableName() . "` (
           `id` INT NOT NULL AUTO_INCREMENT ,
           `reg_no` VARCHAR(10) NOT NULL ,
           `subject` VARCHAR(30) NOT NULL ,
           `taken_by` INT NOT NULL ,
           `taken_on` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
           `remarks` text NOT NULL ,
           PRIMARY KEY (`id`))";
    return $this->execute($sql);
  }

}