<?php namespace Attendance\Database;

use Attendance\Database\Connection;

/**
 */
class MarksTable extends AbstractTable
{

    protected static $instance;

    private function __construct()
    {
        $this->table_name = 'marks';
    }

    public function create()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `" . $this->getTableName() . "` (
           `id` INT NOT NULL AUTO_INCREMENT ,
           `mid` INT NOT NULL ,
           `mark` INT NOT NULL ,
           `reg_no` VARCHAR(10) NOT NULL ,
           `created_by` INT NOT NULL ,
           `created_on` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
           PRIMARY KEY (`id`))";
        return $this->execute($sql);
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self;
        }
        return self::$instance;
    }
}
