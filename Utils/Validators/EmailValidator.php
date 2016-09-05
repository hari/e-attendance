<?php namespace Attendance\Utils\Validators;

/**
 * Validates the given email address
 *
 * @author Hari Lamichhane <onwithhari@gmail.com>
 *
 */
class EmailValidator implements ValidateInterface {
  private static $message = [];

  /**
   * @inheritDoc
   */
  public static function isValid($in) {

  }

  public static function getMessage() {
    return self::$message;
  }

}