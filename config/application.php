<?php
define('APP_NAME', 'Hotel Campeão');
define('SITE_ROOT', '/hotel'); # com barras
define('APP_ROOT_FOLDER', $_SERVER['DOCUMENT_ROOT'] . '/' . SITE_ROOT);

define('ASSETS_FOLDER', SITE_ROOT . '/app/assets');
define('FILES_FOLDER', SITE_ROOT . '/app/assets/files');
define('LOG_FILE', APP_ROOT_FOLDER . '/logs/application.log');
define('VIEW_FOLDER', SITE_ROOT . '/app/views');
define('DS', DIRECTORY_SEPARATOR);


/* Adicionar pastas defaults para inclução de arquivos com as funções require e include */
set_include_path(get_include_path() . PATH_SEPARATOR . APP_ROOT_FOLDER);
set_include_path(get_include_path() . PATH_SEPARATOR . APP_ROOT_FOLDER . '/config/');
set_include_path(get_include_path() . PATH_SEPARATOR . APP_ROOT_FOLDER . '/app/');
set_include_path(get_include_path() . PATH_SEPARATOR . APP_ROOT_FOLDER . '/lib/');
set_include_path(get_include_path() . PATH_SEPARATOR . APP_ROOT_FOLDER . '/vendor/');

session_start();

date_default_timezone_set('America/Sao_Paulo');

require_once 'core/config/auto_load_classes.php';
require_once 'php_logger/logger.class.php';

Logger::getInstance()->loadFile(LOG_FILE);
?>
