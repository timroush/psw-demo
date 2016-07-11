<?php
/**
 * Container class for functions pertaining to an instance of a restaurant
 */
class RESTAURANT{
	private $id = false;
    private $name = false;
    private $modified = false;
    private $address = false;
    private $suggestorID = false;
    private $ratingScore = 0;
    
    public function __construct($id, $name, $suggestorID, $modified, $address){
        $this->id = $id;
        $this->name = $name;
        $this->suggestorID = $suggestorID;
        $this->modified = $modified;
        $this->address = $address;
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

    public function address(){
        return $this->address;
    }

    public function ratingScore(){
        return $this->ratingScore;
    }
    
    /**
     * If there exists a rating, return the rating string. Otherwise return the default message
     * @return: String representation of restaurant rating
     */
    public function rating(){
        $ratings = RESTAURANTS::getVotesForRestaurant($this->id);
        if($ratings['total'] == 0){
            return 'No ratings yet';
        }
        return $ratings['total'] . ' ratings, '.$this->ratingScore() . '% positive';
    }
    
    /**
     * Looks up votes for this restaurant, formulates that into a percentage
     * @return: Int value of percentage rating
     */
    private function calculateRatingScore($ratings=false){
        $ratings = $ratings ?: RESTAURANTS::getVotesForRestaurant($this->id);
        if($ratings['total'] == 0){
            return 0;
        }
        return (100 * round($ratings['up'] / $ratings['total'], 2));
    }
    
    /**
     * Look up user who suggested this restaurant
     * @return: String name of user who suggested this restaurant
     */
    public function suggestor(){
        return USER::getUserNameByID($this->suggestorID);
    }
    
    /**
     * Take the name of this restaurant, return the URL representation
     * @return: String URL encoded version of the name
     */
    public static function url($name){
        return urlencode(str_replace("'", '', $name));
    }
    
    /**
     * Look up who voted for this restaurant and how
     * @return: Array of votes and user information, empty if no rows exist
     */
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
    
    public function loadComments(){
        global $dbh;
        $sql = "SELECT comments.*, users.name 
                FROM comments 
                INNER JOIN users
                    ON comments.user_id = users.id
                WHERE comments.restaurant_id = ? 
                ORDER BY comments.date desc";
        $sth = $dbh->prepare($sql);
        $sth->execute([$this->id]);
        return $sth->fetchAll();
    }
}

