<?php
/**
 * Container class for functions pertaining to an instance of a restaurant
 */
class RESTAURANT{
	private $id = false;
    private $name = false;
    private $modified = false;
    private $suggestorID = false;
    private $ratingScore = 0;
    
    public function __construct($id, $name, $suggestorID, $modified){
        $this->id = $id;
        $this->name = $name;
        $this->suggestorID = $suggestorID;
        $this->modified = $modified;
        $this->ratingScore = $this->calculateRatingScore();
    }
    
    //Basic getter functions
    public function name(){
        return $this->name;
    }

    public function id(){
        return $this->id;
    }

    public function modified(){
        return $this->modified;
    }

    public function ratingScore(){
        return $this->ratingScore;
    }
    
    public function rating(){
        $ratings = RESTAURANTS::getVotesForRestaurant($this->id);
        if($ratings['total'] == 0){
            return 'No ratings yet';
        }
        return $ratings['total'] . ' ratings, '.$this->ratingScore() . '% positive';
    }
    
    private function calculateRatingScore($ratings=false){
        $ratings = $ratings ?: RESTAURANTS::getVotesForRestaurant($this->id);
        if($ratings['total'] == 0){
            return 0;
        }
        return (100 * round($ratings['up'] / $ratings['total'], 2));
    }
    
    public function suggestor(){
        return USER::getUserNameByID($this->suggestorID);
    }
    
    public static function url($name){
        return urlencode(str_replace("'", '', $name));
    }
    
    public function getVotesBreakdown(){
        global $dbh;
        $sql = "SELECT votes.*, users.name 
                FROM `votes` 
                INNER JOIN users 
                ON votes.user_id = users.id 
                WHERE restaurant_id = ?
                ORDER BY votes.date_added desc";
        $sth = $dbh->prepare($sql);
        $sth->execute([$this->id]);
        return $sth->fetchAll();        
    }

    
	
}

