<?php namespace Attendance\Models;

abstract class Model {
  
  /** @var Array The property-value pair of all the attributes of model */
  protected $instance = [];

  /** @var Attendance\Database\AbstractTable The table associated with this model */
  protected $abs_table;

  public function getAttribute($prop) {
    if (array_key_exists($prop, $this->instance)) {
      return $this->instance[$prop];
    }
    return null;
  }

  /**
   *  Creates an SQL statement from given key-value pair array and executes INSERT command
   */
  public function create($prop = []) {
    if ($this->abs_table == null)
      throw new \Exception("The associated table is null. Make sure to set table in constructor", 1);
    return $this->abs_table->insert($prop);
  }
  
}