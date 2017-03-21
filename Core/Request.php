<?php namespace Attendance\Core;

class Request
{

    private static $instance;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function get($key, $filter = true)
    {
        if (isset($_REQUEST) && isset($_REQUEST[$key])) {
            if ($filter) {
                return \htmlentities($_REQUEST[$key], ENT_QUOTES);
            }
            return $_REQUEST[$key];
        }
        return null;
    }

    public function pull($key)
    {
        $value = $this->get($key);
        if ($value != null) {
            unset($_REQUEST[$key]);
        }
        return $value;
    }

    public function all()
    {
        return array_merge($_POST, $_GET);
    }
}
