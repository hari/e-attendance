<?php namespace Attendance\Database;

class SubjectTable extends AbstractTable
{

    protected static $instance;

    private function __construct()
    {
        $this->table_name = 'subjects';
    }

    public function create()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `" . $this->getTableName() . "` (
           `id` INT NULL AUTO_INCREMENT ,
           `name` VARCHAR(255) NULL ,
           `code` VARCHAR(10) UNIQUE NOT NULL ,
           `sem` INT NULL ,
           `teacher` varchar(200) NULL ,
           `created_by` INT NULL ,
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
