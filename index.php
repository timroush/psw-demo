<?php
require_once('config.php');
require_once('globals.php');

//User is global scope, since it's needed site-wide
$user = new User();
//Output represents all the HTML to the screen. Start by loading the outer template
$output = view('template.php');
//Inner represents the inner content of the page, aside from the main template
$inner = '';

//If you're not logged in, you'll only get the login screen
if(!$user->isLoggedIn()){
	//Note that there's no validation here
    if(request('username')){
        $user->login(request('username'));
        $inner = view('user_home.php');
    }
    else{
        $inner = view('login.php');
    }
}
else{
	//You're logged in, which node are you on?
    switch(urlNode(0)){
        case 'ajax':
            controller('ajax.php');
            break;
        case 'logout':
            User::logout();
            $inner = view('login.php');
            break;
        case 'restaurants':
            debug($restaurant = RESTAURANTS::getRestaurantByURLSlug(urlNode(1)));
            if(!$restaurant){
            
            }
            else{
            
            }
            break;
        case 'suggest':
            $added = null;
            if(request('name')){
                $added = RESTAURANTS::add(request('name'));
            }
            $inner = view('suggest.php');
            break;
        default:
            $inner = view('user_home.php');
            break;
    }
}

//Replace template placeholders with actual content
$output = str_replace('{%BODY%}', $inner, $output);

echo $output;
exit;