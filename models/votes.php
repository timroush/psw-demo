<?php

class VOTES{
    
    /**
     * For a given restaurant ID and user ID, write a vote to the DB
     * @restID: INT ID value for the restaurant to vote for
     * @userID: INT ID of user doing the voting
     * @vote: [0|1] value representing vote
     */
    public static function saveVote($restID, $userID, $vote){
        global $dbh;
        if(!in_array($vote, ['0', '1']) || !is_int($restID) || !is_int($userID)){
            debug('insufficient data');
            return false;
        }
        if(!USER::getUserNameByID($userID) || !RESTAURANTS::getRestaurantByID($restID)){
            return false;
        }
        $vote = ($vote == '1');
        $sql = "SELECT 1 FROM votes WHERE user_id = ? and restaurant_id=?";
        $sth = $dbh->prepare($sql);
        $sth->execute([$userID, $restID]);
        $hasvote = $sth->fetch();
        if($hasvote){
            $sql = "UPDATE votes SET vote=? WHERE user_id = ? and restaurant_id=?";
            $sth = $dbh->prepare($sql);
            $sth->execute([$vote, $userID, $restID]);
        }
        else{
            $sql = "INSERT INTO votes(user_id, restaurant_id, vote) values(?,?,?)";
            $sth = $dbh->prepare($sql);
            $sth->execute([$userID, $restID, $vote]);
        }
    }
    
}