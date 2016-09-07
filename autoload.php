<?php

spl_autoload_register(function($class_name) {
  require_once str_replace([APP . '\\', '\\'], ['', '/'], $class_name) . '.php';
});