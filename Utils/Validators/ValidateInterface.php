<?php namespace Attendance\Utils\Validators;

interface ValidateInterface {
  /**
   * Checks if the given input is valid
   *
   * @param $in the input value to check
   *
   * @return bool true if validation is successful
   *
   */
  public static function isValid($in);
  /**
   * returns any error message and code if the error during validation
   *
   * @return array
   *
   */
  public static function getMessage();
}