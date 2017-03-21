<?php namespace Attendance\Utils;

class MessageBox
{

    public static function set($message)
    {
        $_SESSION['message'] = $message;
    }

    public static function get()
    {
        return (isset($_SESSION['message'])) ? $_SESSION['message'] : [];
    }

    public static function pull()
    {
        $ret = MessageBox::get();
        unset($_SESSION['message']);
        return $ret;
    }
}
