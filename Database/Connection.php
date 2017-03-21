<?php namespace Attendance\Database;

class Connection
{

    private static $connection;

    private function __construct()
    {
    }

    public static function execute($sql)
    {
        $con = self::get();
        $stm = $con->prepare($sql);
        if ($stm->execute()) {
            return $stm->fetchAll();
        }
        return [];
    }

    public static function get()
    {
        if (self::$connection == null) {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
            $count = 0;
            do {
                try {
                    $count++;
                    self::$connection = new \PDO($dsn, DB_USER, DB_PASS);
                    // self::$connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                    self::$connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
                } catch (Exception $e) {
                    self::$connection = null;
                }
            } while (self::$connection == null || $count < 5);
        }
        return self::$connection;
    }

    public static function close()
    {
        if (self::$connection != null) {
            $connection->close();
        }
    }
}
