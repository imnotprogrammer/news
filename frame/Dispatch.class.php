<?php

class Dispatch{
    
    public static $path = "";
    
    public static $action = 'index';
    
    public static $controller = 'index';
    
    public static $init = 0;
    
    /**
     * Dispatch::__construct()
     * 
     * @return
     */
    public function __construct($configs = []){
        
        self::$init = 1;
        $this->parseUrl();
        
    }
    
    /**
     * Dispatch::parseUrl()
     * 解析url
     * url的例子
     * www.example.com               
     * www.example.com/index
     * www.example.com/index/list
     * 
     * @return
     */
    public function parseUrl(){
    
        $param = $_SERVER['REQUEST_URI'];
        $urls = parse_url($param);
        
        if( $urls['path'] == '/' ){
            
            $action = [
                'model'=>'index',
                'action'=>'index'
            ];
            
        }elseif( $urls['path'] == '/favicon.ico' ){
            
            exit(0);
            
        }else{
            
            $urls['path'] = substr($urls['path'],1);
            $paths = explode('/',$urls['path']);
            $count = count($paths);
            
            if( $count == 1 || $paths[1] =="" ){
                
                self::$controller = $paths[0];
                
            }elseif( $count  == 2 ){
                
                self::$controller = $paths[0];
                self::$action = $paths[1];
                
            }elseif( $count >= 3 ){
                
                self::$path = $paths[0];
                self::$controller = $paths[1];
                self::$action = $paths[2];
                
            }
        
        }
        
        
    }
    
    /**
     * Dispatch::exec()
     * 加载文件，调用controller 执行action
     * @return
     */
    public function exec(){

        $path = self::$path;
        $controller = self::$controller;
        $action = self::$action;
        
        
        
        if( $path ){
            
            $path = 'controller/' . $path . '/' . $controller . '.php';
            
        }else{
            
            $path =  'controller/' . $controller . '.php';
            
        }
        
        if( is_file($path) ){
            
            require $path;
            
        }else{
            
            header("location:/index/error");
           // echo 'NOT FOUND';
            exit;
            
        }
        
        $controller = $controller.'Controller';
        
        $class = new $controller() ;
        
        if( method_exists($class,$action . 'Action') ){
            
            call_user_func([$class,$action . 'Action'],[]);
            
        }else{
            
            header("HTTP/1.0 404 Not Found");
            echo 'NOT FOUND';
            exit;
            
        }
        
    }
    
    
}