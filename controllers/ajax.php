<?php

header('Content-Type: application/json');
global $user;
switch(urlNode(1)){
    case 'restaurant-comment':
        $userID = (int) request('user-id');
        $restaurantID = (int) request('restaurant-id');
        $comment = request('comment');
        if(empty($userID) || empty($restaurantID) || empty($comment)){
            debug("insufficient data");
            debug([$userID, $restaurantID, $comment]);
            exit;
        }
        RESTAURANTS::addComment($restaurantID, $userID, $comment);
        
        echo json_encode(['user' => $user->userName(), 'date' => date('m/d/Y g:i:s A'), 'comment' => $comment]);
        break;
    case 'restaurant-vote':
        $userID = (int) request('user-id');
        $restaurantID = (int) request('restaurant-id');
        $vote = request('vote');
        if(empty($userID) || empty($restaurantID) || !in_array($vote, ['0', '1'])){
            exit;
        }
        VOTES::saveVote($restaurantID, $userID, $vote);
        echo json_encode(RESTAURANTS::getVotesForRestaurant($restaurantID));
        break;
    
}

exit;