<?php

if(!defined('LIB')) { exit('Hacking Attempt!'); }

//Системные константы
define('LIB_ROOT', dirname(__FILE__).'/');
define('LIB_ENGINE_PATH', LIB_ROOT.'engine/');
define('LIB_CONFIG_PATH', LIB_ROOT.'configs/');
define('LIB_MOD_PATH', LIB_ROOT.'modules/');
define('LIB_BLOCK_PATH', LIB_ROOT.'blocks/');
define('LIB_LIBS_PATH', LIB_ENGINE_PATH.'libs/');

if(!session_start()) { session_start(); }

//Установка стандартного charset
header('Content-Type: text/html; charset=UTF-8');

//Загрузка ядра
require_once(LIB_ENGINE_PATH.'core.class.php');

$core = new core();

?>