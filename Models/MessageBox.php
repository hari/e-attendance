<?php namespace Attendance\Models;
class MessageBox {

  public static function setMessage($message) {
    $_SESSION['message'] = $message;
  }

  public static function getMessage() {
    return (isset($_SESSION['message'])) ? $_SESSION['message'] : [];
  }

  public static function pullMessage() {
    $ret = MessageBox::getMessage();
    unset($_SESSION['message']);
    return $ret;
  }

}