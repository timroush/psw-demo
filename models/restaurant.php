<?php
/**
 * Container class for functions pertaining to an instance of a restaurant
 */
class RESTAURANT{
	private $id = false;
    private $name = false;
    private $suggestorID = false;
    
    public function __construct($id, $name, $suggestorID){
        $this->id = $id;
        $this->name = $name;
        $this->suggestorID = $suggestorID;
    }
    
    //Basic getter functions
    public function name(){
        return $this->name;
    }
    
    public function rating(){
        return 'No ratings yet';
    }
    
    public function suggestor(){
        return USER::getUserNameByID($this->suggestorID);
    }
    
    public function url(){
        return urlencode(str_replace("'", '', $this->name));
    }

    
	
}

