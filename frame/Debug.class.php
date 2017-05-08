<?php
/**
 * 调试助手类
 * 
 * Debug
 * 
 */
class Debug{
    
    /*存放的日志文件*/
    static $file = WEB_ROOT.'/log_bmzj/logsdfadsk123.log';
    
    static $mark = 0;
    
    /*json数据格式,0是规范的格式,1则没有格式*/
    static $json_format = 0;
    

    /**
     * Debug::log($var[,$var1,$var2,...])
     * 
     * @param mixed $var 数据信息
     * 
     * 记录信息
     * @return
     */
    static function log($var){
        
        $args = func_get_args();
        
        $file = self::$file;
        
        foreach( $args as $arg ){
            
            $var = $arg;
            
            if( !is_file($file) ){
                touch($file);
            }
            
            if( is_array($var)  ){
                if( self::$json_format == 0 ){
                    $var = jsonFormat($var);
                }elseif( self::$json_format == 1 ){
                    $var = json_encode($var);
                }
            }
            
            if( self::$mark ){
                $str = $var . PHP_EOL . PHP_EOL;
            }else{
                $str = date('Y-m-d H:i:s',time()) . ' ' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . PHP_EOL . $var . PHP_EOL . PHP_EOL; 
                self::$mark = 1;
            }
            
            error_log($str,3,$file);
            
        }
        
    }
    
    /**
     * Debug::trace()
     * 
     * 记录当前的堆栈信息
     * @param integer $print   是否打印
     * @param string $msg  需要记录的附加信息
     * @param integer $start 起始于第几层
     * @param integer $length 长度
     * @return
     */
    static function trace($print=0,$msg="",$start=0,$length=5){
        
        $infos = debug_backtrace();
        
        $count = count($infos);
        
        $start = $start + 1;
        
        if( $count < $length ){
            $length = $count-$start;
        }
        $infos = array_slice($infos,$start,$length);
        
        $format_infos = [];
        
        foreach( $infos as $info ){
            if( empty($info['file']) ){
                break;
            }
            $str = $info['file'] . ' in line ' . $info['line'] . ':';
            
            if( isset($info['class']) ){
                $str .= $info['class'] . $info['type'] . $info['function'];
            }
            
            foreach( $info['args'] as $key=>$arg ){
                if( is_numeric($arg) ){
                    
                }elseif( is_string($arg) ){
                    
                    if( strlen($arg) >30 ){
                        $arg = substr($arg,0,30) . '...';
                    }
                    $info['args'][$key] = "'" . $arg . "'";
                    
                }elseif( is_array($arg) || is_object($arg) ){
                    
                    $arg = json_encode($arg,JSON_UNESCAPED_UNICODE);
                    
                     if( strlen($arg) >30 ){
                        $arg = substr($arg,0,30) . '...';
                    }
                    $info['args'][$key] = "'" . $arg . "'";
                    
                }
            }
            
            $format_infos[] = $str . '(' . implode(',',$info['args']) . ')';
            
        }
        
        if( is_string($msg) ){
            
            if( strlen($msg) >500 ){
                $msg = substr($msg,0,500);
            }
            $format_infos[] = $msg;
                
        }else{
            
            foreach( $msg as $key=>$m ){
                $msg[$key] = substr($msg[$key],0,500);
            }
            $format_infos = array_merge($format_infos,$msg);
        }
        
        $str = implode(PHP_EOL,$format_infos);
        
        if( $print ){
            $echoHtml = '';
            foreach($format_infos as $format_info ){
                $echoHtml .= '<p>' . $format_info . '</p>';
            }
            echo $echoHtml;
        }
        
        
        Debug::log($str);
        
        error_log( implode(',',$format_infos) );
        
    }
    
}


/** Json数据格式化
* @param  Mixed  $data   数据
* @param  String $indent 缩进字符，默认4个空格
* @return JSON
*/
function jsonFormat($data, $indent=null){

    // 对数组中每个元素递归进行urlencode操作，保护中文字符
    array_walk_recursive($data, 'jsonFormatProtect');

    // json encode
    $data = json_encode($data);

    // 将urlencode的内容进行urldecode
    $data = urldecode($data);

    // 缩进处理
    $ret = '';
    $pos = 0;
    $length = strlen($data);
    $indent = isset($indent)? $indent : '    ';
    $newline = "\n";
    $prevchar = '';
    $outofquotes = true;

    for($i=0; $i<=$length; $i++){

        $char = substr($data, $i, 1);

        if($char=='"' && $prevchar!='\\'){
            $outofquotes = !$outofquotes;
        }elseif(($char=='}' || $char==']') && $outofquotes){
            $ret .= $newline;
            $pos --;
            for($j=0; $j<$pos; $j++){
                $ret .= $indent;
            }
        }

        $ret .= $char;
        
        if(($char==',' || $char=='{' || $char=='[') && $outofquotes){
            $ret .= $newline;
            if($char=='{' || $char=='['){
                $pos ++;
            }

            for($j=0; $j<$pos; $j++){
                $ret .= $indent;
            }
        }

        $prevchar = $char;
    }

    return $ret;
}

/**
 * jsonFormatProtect()
 * 
 * @param mixed $val
 * @return
 */
function jsonFormatProtect(&$val){  
    if($val!==true && $val!==false && $val!==null){  
        $val = urlencode($val);  
    }  
}