<?php
define('DS', DIRECTORY_SEPARATOR);
define('VIEW', __DIR__.DS.'view');
define('SOURCE', __DIR__.DS.'source');
define('DATA', __DIR__.DS.'data');

require_once SOURCE.DS.'functions.php';

$content = '';

ob_start();
session_start();

register_shutdown_function(function() use(&$content){
    require_once VIEW.DS.'layout.php';
    ob_end_flush();
});