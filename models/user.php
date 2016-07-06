<?php
/*
Object for user-based functions
*/

class USER{
    const cookieName = 'demo_user_cookie';
    private $userName = false;
    private $userID = false;
    
    public function __construct(){
        if(isset($_COOKIE[self::cookieName])){
            $this->setUserName($_COOKIE[self::cookieName]);
            $this->userID = self::getUserIDByName($_COOKIE[self::cookieName]);
        }
    }
    
    /**
     * Sets userName property to value
     * @userName: value to set property to
     * @return: None
     */
    private function setUserName($userName){
        $this->userName = $userName;
    }
    
    /**
     * Determines if user is logged in
     * @return: Boolean representing logged-in state
     */
    public function isLoggedIn(){
        return $this->userName !== false;
    }
    
    public function getUserVoteForRestaurant($restID){
        global $dbh;
        $sql = "SELECT vote FROM votes WHERE user_id = ? and restaurant_id=?";
        $sth = $dbh->prepare($sql);
        $sth->execute([$this->userID, $restID]);
        $vote = $sth->fetch();
        if(!$vote){
            return null;
        }
        return ($vote['vote'] == 1);
    }
    
    /**
     * Performs tasks for logging user in
     * @userName: name of user logging in
     * @return: None
     */
    public function login($userName){
        $this->setUserName($userName);
        $this->setUserID();
        self::createUserCookie($userName);
    }
    
    /**
     * Performs tasks for logging user out
     * @return: None
     */
    public static function logout(){
        setcookie(self::cookieName, '', time() - 1, '/');
    }
    
    public function userName(){
        return $this->userName;
    }

    public function userID(){
        return $this->userID;
    }
    
    /**
     * Establishes user cookie
     * @userName: name of user to log in
     * @return: None
     */
    public static function createUserCookie($userName){
        setcookie(self::cookieName, $userName, time() + 60*60*24, '/');
    }
    
    /**
     * Sets the userID property based on the current userName
     * If the userName does not exist in the database, a record will be made
     * @return: None
     */
    private function setUserID(){
        global $dbh;
        $id = self::getUserIDByName($this->userName);
        if(!$id){
            $sql = "INSERT INTO users(name) values(?)";
            $sth = $dbh->prepare($sql);
            $sth->execute([$this->userName]);
            $this->userID = $dbh->lastInsertId();
        }
        else{
            $this->userID = $id;
        }
    }
    
    /**
     * Pass in an ID, get the name of the user in the DB
     * @id: ID of the user to look up
     * @return: String name of user, False if none exists
     */
    public static function getUserNameByID($id){
        global $dbh;
        $sql = "SELECT name FROM users WHERE id = ?";
        $sth = $dbh->prepare($sql);
        $sth->execute([$id]);
        $user = $sth->fetch();
        if(!$user){
            return false;
        }
        return $user['name'];
    }

    /**
     * Pass in a name, get the ID of the user in the DB
     * @name: ID of the user to look up
     * @return: String name of user, False if none exists
     */
    public static function getUserIDByName($name){
        global $dbh;
        $sql = "SELECT id FROM users WHERE name = ?";
        $sth = $dbh->prepare($sql);
        $sth->execute([$name]);
        $user = $sth->fetch();
        if($user){
            return $user['id'];
        }
        return false;
    }
    
}