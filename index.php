<?php
require_once('config.php');
require_once('globals.php');

$user = new User();
$output = view(VIEWS_PATH. DIRECTORY_SEPARATOR .'template.php');
$inner = '';


if(!$user->isLoggedIn()){
    if(request('username')){
        $user->login(request('username'));
        $inner = view(VIEWS_PATH. DIRECTORY_SEPARATOR .'user_home.php');
    }
    else{
        $inner = view(VIEWS_PATH. DIRECTORY_SEPARATOR .'login.php');
    }
}
else{
    switch(urlNode(0)){
        case 'logout':
            User::logout();
            $inner = view(VIEWS_PATH. DIRECTORY_SEPARATOR .'login.php');
            break;
        case 'suggest':
            $inner = view(VIEWS_PATH. DIRECTORY_SEPARATOR .'suggest.php');
            break;
        default:
            $inner = view(VIEWS_PATH. DIRECTORY_SEPARATOR .'user_home.php');
            break;
    }
}

$output = str_replace('{%BODY%}', $inner, $output);

echo $output;
exit;