<?php namespace Attendance\Models;

use Attendance\Database\AttendanceTable;

/**
 * 
 */
class Attendance extends Model {

  public static function create($pv = []) {
    return parent::_create(new AttendanceTable(), $pv);
  }

  /**
   * Deletes a matching row from the table
   *
   *  delete(['age' => '=> 12', 'name' =>  '= ram']);
   *
   * @param $wheres array A collection of condition to meet for deleting the record
   *
   * @return boolean true if successfully deleted
   */
  public static function delete($wheres = []) {
    return parent::_delete(new AttendanceTable(), $wheres);
  }

}