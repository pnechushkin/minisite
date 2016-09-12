<?php
/*
 * опредиление констант
 */
define('DS', DIRECTORY_SEPARATOR);
define('VIEW', __DIR__.DS.'view');
define('SOURCE', __DIR__.DS.'source');
define('DATA', __DIR__.DS.'data');
/*
 * подкючаем файл с функциями
 */
require_once SOURCE.DS.'functions.php';
/*
 * создаем пустую переменную контента
 */
$content = '';
/*
 * стартуем буфер
 */
ob_start();
/*
 * открываем сессию
 */
session_start();
/*
 * запуск анонимной функции с использыванием переменной контента по ссылке в которой загружается внешний вид страницы
 */
register_shutdown_function(function() use(&$content){
    require_once VIEW.DS.'layout.php';
    ob_end_flush();
});