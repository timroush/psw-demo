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
    public static function add($name){
        global $dbh, $user;
        $sql = "SELECT id FROM restaurants WHERE name = ?";
        $sth = $dbh->prepare($sql);
        $sth->execute([$name]);
        $id = $sth->fetch();
        if(!$id){
            $sql = "INSERT INTO restaurants(name, suggestor) values(?, ?)";
            $sth = $dbh->prepare($sql);
            $sth->execute([$name, $user->userID()]);
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
        $sql = 'SELECT id, name, suggestor, modified FROM restaurants';
        $sth = $dbh->prepare($sql);
        $sth->execute();
        $results = $sth->fetchAll();
        foreach($results as $row){
            $ret[] = new RESTAURANT($row['id'], $row['name'], $row['suggestor']);
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
        $sql = "SELECT id, name, suggestor, modified FROM restaurants WHERE REPLACE(name, '''', '') = ? limit 1";
        $sth = $dbh->prepare($sql);
        $sth->execute([urldecode($slug)]);
        $results = $sth->fetch();
        if(!$results){
            return false;
        }
        return new RESTAURANT($results['id'], $results['name'], $results['suggestor']);
    }
}

