<?php
/*
For system-wide constants that govern the site's configuration
*/
define('BASE_PATH', $_SERVER['DOCUMENT_ROOT']);
define('MODELS_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'models');
define('VIEWS_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'views');
define('CONTROLLERS_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'controllers');
define('BASE_URL', 'http://localhost');