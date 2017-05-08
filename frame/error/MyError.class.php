<?php
/*
set_error_handler(["MyError","myErrorHandler"]); //请在代码里面加入这一行
*/
class MyError{
    
     static function myErrorHandler($errno, $errstr, $errfile, $errline ){

        if (!(error_reporting() & $errno)) {
           
            return false;
        }
        
        switch ($errno) {
            
            case E_USER_ERROR:
            
                echo "Access error!";
                
                self::error_log("user error",$errstr,$errfile,$errline);
                
                exit;
                
                break;
        
            case E_USER_WARNING:
            
                self::error_log("user warning",$errstr,$errfile,$errline);
                
                break;
        
            case E_USER_NOTICE:
                
                self::error_log("user notice",$errstr,$errfile,$errline);
                
                break;
            
            case E_WARNING:
            
                self::error_log("warning",$errstr,$errfile,$errline);
                
                return ;
                
                break;
                
            default:
            
                self::error_log("default",$errstr,$errfile,$errline);
                
                break;
                
        }
    
        /* Don't execute PHP internal error handler */
        return true;
    }
    
    static function error_log($errnoStr,$errstr,$errfile,$errline){
        
        if( $errnoStr == "warning"){
            $str = 'PHP ' . $errnoStr . ': ' . $errstr ;
        }else{
            $str = 'PHP ' . $errnoStr . ': ' . $errstr . 'in '.$errfile .' on line '.$errfile;
        }
        
        error_log($str);
        
    }
    
}
