<?php
class ActiveRecord{
    
    public $db;
    
    public $params;
    
    public function __construct(){
        $this->db = DB::init();
    }
    
    public function __set($key,$value){
        $this->params[$key] = $value;
    }
    
    public function save(){
        
    }
    
}