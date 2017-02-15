<?php namespace Attendance\Models;

use Attendance\Database\MarkModelTable;

/**
 * 
 */
class MarksModel extends Model {

  public static $fields = ["Assignment", "Assesment", "Unit Test 1", "Unit Test 2", "Attendance", "Practical", "Lab Report"];

  public static function create($pv = []) {
    return parent::_create(MarkModelTable::getInstance(), $pv);
  }

  public static function select($pv = [], $where) {
    return parent::_select(MarkModelTable::getInstance(), $pv, $where);
  }

  public static function delete($wheres = []) {
    return parent::_delete(MarkModelTable::getInstance(), $wheres);
  }

  public static function exists($field, $subject) {
    $where = sprintf("WHERE name = %d AND subject = '%s'", $field, $subject);
    return count(self::select(['weight'], $where));
  }

  public static function getTotalOf($subject) {
    $where = sprintf("WHERE subject = '%s'", $subject);
    $existing = self::select(['weight'], $where);
    $total = 0;
    if (count($existing) > 0) {
      foreach ($existing as $field) {
        $total += $field['weight'];
      }
    }
    return $total;
  }

}