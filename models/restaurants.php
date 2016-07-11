<?php
/**
 * Container class for functions pertaining to restaurants as a collection
 */
class RESTAURANTS{
	
	/**
	 * Adds a restaurant to the database
	 * If it already exists, a message will be returned
	 * @return: Boolean True if a record was added, String if there was an error
	 */
    public static function add($name, $address){
        global $dbh, $user;
        $sql = "SELECT id FROM restaurants WHERE name = ?";
        $sth = $dbh->prepare($sql);
        $sth->execute([$name]);
        $id = $sth->fetch();
        if(!$id){
            $sql = "INSERT INTO restaurants(name, suggestor, address) values(?, ?, ?)";
            $sth = $dbh->prepare($sql);
            $sth->execute([$name, $user->userID(), $address]);
            if($dbh->lastInsertId()){
                return true;
            }
            else{
                return 'There was an error. Please try again.';
            }
        }
        else{
            return 'An entry for this restaurant already exists.';
        }
    }
    
    /**
     * Loads all restaurants
     * @return: Array of instances of RESTAURANT
     */
    public static function getAll(){
        global $dbh;
        $ret = [];
        $sql = 'SELECT id, name, suggestor, modified, address FROM restaurants';
        $sth = $dbh->prepare($sql);
        $sth->execute();
        $results = $sth->fetchAll();
        foreach($results as $row){
            $ret[] = new RESTAURANT($row['id'], $row['name'], $row['suggestor'], $row['modified'], $row['address']);
        }
        return $ret;
    }
    
    /**
     * Gets a restaurant object based on the URL slug (which is a version of the name)
     * @slug: the URL value of the restaurant's name
     * @return: Instance of RESTAURANT or False
     */
    public static function getRestaurantByURLSlug($slug){
        global $dbh;
        $sql = "SELECT id, name, suggestor, modified, address FROM restaurants WHERE REPLACE(name, '''', '') = ? limit 1";
        $sth = $dbh->prepare($sql);
        $sth->execute([urldecode($slug)]);
        $results = $sth->fetch();
        if(!$results){
            return false;
        }
        return new RESTAURANT($results['id'], $results['name'], $results['suggestor'], $results['modified'], $results['address']);
    }
    
    /**
     * Gets a restaurant object based on the ID
     * @id: the ID of the restaurant
     * @return: Instance of RESTAURANT or False
     */
    public static function getRestaurantByID($id){
        global $dbh;
        $sql = "SELECT id, name, suggestor, modified, address FROM restaurants WHERE id=? limit 1";
        $sth = $dbh->prepare($sql);
        $sth->execute([$id]);
        $results = $sth->fetch();
        if(!$results){
            return false;
        }
        return new RESTAURANT($results['id'], $results['name'], $results['suggestor'], $results['modified'], $results['address']);
    }
    
    /**
     * Look up all votes for a restaurant based on ID
     * @return: Array of arrays with values of how many up votes, down votes and total votes there are
     */
    public static function getVotesForRestaurant($id){
        global $dbh;
        $ret = ['up' => 0, 'down' => 0, 'total' => 0];
        $sql = "SELECT vote, count(*) as total FROM votes WHERE restaurant_id = ? group by vote";
        $sth = $dbh->prepare($sql);
        $sth->execute([$id]);
        $results = $sth->fetchAll();
        if(!$results){
            return $ret;
        }
        foreach($results as $row){
            if($row['vote'] == '0'){
                $ret['down'] = $row['total'];
            }
            else{
                $ret['up'] = $row['total'];
            }
        }
        $ret['total'] = $ret['up'] + $ret['down'];
        return $ret;
    }
    
    public static function addComment($restID, $userID, $comment){
        global $dbh;
        $sql = "INSERT INTO comments(user_id, restaurant_id, comment) values (?,?,?)";
        $sth = $dbh->prepare($sql);
        $sth->execute([$userID, $restID, $comment]);
    }
}

