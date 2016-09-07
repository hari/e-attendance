<?php namespace Attendance\Models;

/**
 * 
 */
class User extends Model {

  const ADMIN   = 0x0;
  const TEACHER = 0x1;
  const STUDENT = 0x2;
  
  protected $role;
}