<?php namespace Attendance\Models;

use Attendance\Database\SubjectTable;

/**
 * 
 */
class Subject extends Model {

  public static function create($pv = []) {
    return parent::_create(SubjectTable::getInstance(), $pv);
  }

  public static function select($cols = [], $where) {
    return parent::_select(SubjectTable::getInstance(), $cols, $where);
  }

  public static function delete($wheres = []) {
    return parent::_delete(SubjectTable::getInstance(), $wheres);
  }
  
}