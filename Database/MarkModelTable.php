<?php namespace Attendance\Database;

use Attendance\Database\Connection;

/**
 * Model for storing subject specific mark models.
 */
class MarkModelTable extends AbstractTable
{

    protected static $instance;

    private function __construct()
    {
        $this->table_name = 'mark_model';
    }

    public function create()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `" . $this->getTableName() . "` (
           `id` INT NOT NULL AUTO_INCREMENT ,
           `name` INT NOT NULL ,
           `subject` VARCHAR(50) NOT NULL ,
           `weight` VARCHAR(50) NOT NULL ,
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
