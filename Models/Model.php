<?php namespace Attendance\Models;

abstract class Model {
  
  /** @var Array The property-value pair of all the attributes of model */
  protected $instance = [];

  public function getAttribute($prop) {
    if (array_key_exists($prop, $this->instance)) {
      return $this->instance[$prop];
    }
    return null;
  }
  
}