<?php

class USER{
    const cookieName = 'demo_user_cookie';
    private $userName = false;
    private $userID = false;
    
    public function __construct(){
        if(isset($_COOKIE[self::cookieName])){
            $this->setUserName($_COOKIE[self::cookieName]);
        }
    }
    
    private function setUserName($userName){
        $this->userName = $userName;
    }
    
    public function isLoggedIn(){
        return $this->userName !== false;
    }
    
    public function login($userName){
        $this->setUserName($userName);
        $this->setUserID();
        self::createUserCookie($userName);
    }
    
    public static function logout(){
        setcookie(self::cookieName, '', time() - 1, '/');
    }
    
    public function userName(){
        return $this->userName;
    }
    
    
    public static function createUserCookie($userName){
        setcookie(self::cookieName, $userName, time() + 60*60*24, '/');
    }
    
    private function setUserID(){
        global $dbh;
        $sql = "SELECT id FROM users WHERE name = ?";
        $sth = $dbh->prepare($sql);
        $sth->execute([$this->userName]);
        $id = $sth->fetchAll();
        if(!$id){
            $sql = "INSERT INTO users(name) values(?)";
            $sth = $dbh->prepare($sql);
            $sth->execute([$this->userName]);
            $this->userID = $dbh->lastInsertId();
        }
        else{
            $this->userID = $id[0]['id'];
        }
    }
    
}