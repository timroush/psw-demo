<?php
/*
For global-scope functions and select objects like the DBH
*/
function debug($what){
    echo '<pre>';
    if(is_bool($what)){
        echo ($what) ? 'True' : 'False';
    }
    else{
        print_r($what);
    }
    echo '</pre>';
    $bt = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
    echo 'File: '.$bt[0]['file'] .' line ' . $bt[0]['line'];
}

function request($what){
    return isset($_REQUEST[$what]) ? $_REQUEST[$what] : null;
}

function urlNode($index){
    $chunks = explode('/', ltrim(str_replace('?'.$_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI']), '/'));
    return isset($chunks[$index]) ? $chunks[$index] : '';
}

function view($path){
    ob_start();
    include(VIEWS_PATH . DIRECTORY_SEPARATOR . $path);
    $ret = ob_get_contents();
    ob_end_clean();
    return $ret;
}

function controller($path){
    include(CONTROLLERS_PATH . DIRECTORY_SEPARATOR . $path);
    return $ret;
}

spl_autoload_register(function ($class_name) {
    include MODELS_PATH . DIRECTORY_SEPARATOR . $class_name . '.php';
});

$dbh = new PDO('mysql:dbname=psw_demo;host=localhost', 'psw_user', 'psw_password');