<?php
$dirs = [
 'controllers/',
 'database/',
 'models/'
];
spl_autoload_register(function($class_name) use ($dirs) {
  foreach ($dirs as $key => $dir) {
    $file = $dir . $class_name . '.php';
    if (file_exists($file)) {
      require_once $file;
      break;
    }
  }
});