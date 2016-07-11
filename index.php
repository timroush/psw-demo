<?php
require_once('config.php');
require_once('globals.php');

//User is global scope, since it's needed site-wide
$user = new User();
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
            //Ajax controller exits flow
            controller('ajax.php');
            break;
        case 'logout':
            User::logout();
            $inner = view('login.php');
            header('Location: '.BASE_URL);
            exit();
            break;
        case 'restaurants':
            $restaurant = RESTAURANTS::getRestaurantByURLSlug(urlNode(1));
            if(!$restaurant){
            
            }
            else{
                $inner = view('restaurant_details.php');
            }
            break;
        case 'suggest':
            $added = null;
            if(request('name') && request('address')){
                $added = RESTAURANTS::add(request('name'), request('address'));
            }
            $inner = view('suggest.php');
            break;
        case 'ratings-history':
            $votes = $user->getVotesForUser();
            $inner = view('user_history.php');
            break;
        default:
            $inner = view('user_home.php');
            break;
    }
}

//Output represents all the HTML to the screen. Start by loading the outer template
$output = view('template.php');
//Replace template placeholders with actual content
$output = str_replace('{%BODY%}', $inner, $output);

echo $output;
exit;