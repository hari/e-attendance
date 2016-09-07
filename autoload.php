<?php
$dirs = [
 'Controllers/',
 'Database/',
 'Models/',
 'Core/',
 'Utils/',
 'Utils/Validators/'
];
spl_autoload_register(function($class_name) use ($dirs) {
  foreach ($dirs as $key => $dir) {
    $parts = explode('\\', $class_name);
    $class_name = end($parts);
    $file = $dir . $class_name . '.php';
    if (file_exists($file)) {
      require_once $file;
      break;
    }
  }
});