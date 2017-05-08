<?php
class Record{
    
    public function __set($key,$value){
        $this->$key = $value;    
    }
    
    public function __get($key){
        return $this->$key;
    }
    
}