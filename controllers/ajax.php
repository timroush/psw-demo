<?php

//header('Content-Type: application/json');
switch(urlNode(1)){
    case 'restaurant-vote':
        $userID = (int) request('user-id');
        $restaurantID = (int) request('restaurant-id');
        $vote = request('vote');
        if(empty($userID) || empty($restaurantID) || !in_array($vote, ['0', '1'])){
            debug('insufficient data');
            exit;
        }
        
        VOTES::saveVote($restaurantID, $userID, $vote);
        break;
}

exit;