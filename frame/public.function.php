<?php

/**
 * html_escape()
 * 
 * html转义
 * 
 * @param mixed $str  待转义字符串  |  待转义数组 转义数组中的每一个元素
 * @return 转义后字符串 或者数组
 */
function html_escape($str){
    
    if( is_array($str) ){
        return array_map( "html_escape",$str);
    }elseif( is_numeric($str) ){
        
        return $str;
        
    }elseif( is_string($str) ){
        return htmlspecialchars($str);
    }
    return $str;
    
}


/**
 * json_html_escape()
 * 
 * @param mixed $str
 * @return
 */
function json_html_escape($str){
    $arr = json_decode($str,true);
    $arr = html_escape($arr);
    return json_encode($arr);
}


/**
 * safe_extract()
 * 
 * @param mixed $arr
 * @return
 */
function safe_extract($arr){
    return $arr;
    $superGlobal = array('_SESSION','_GET','_POST','_ENV','_COOKIE','PHPSESSIONID','_FILES','GLOBALS');
    foreach( $_REQUEST as $key=>$value ){
        if( in_array($key,$superGlobal) ){
            unset($arr[$key]);
        }
    }
    return $arr;
}

/**
 * getPage()
 * 
 * @param mixed $pageNum
 * @return
 */
function getPage($pageNum){
    $page = !empty($_GET['page'])?$_GET['page']:1;
   	$start = ($page-1)*$pageNum;
    return [$page,$start];
}

/**
 * getSession()
 * 
 * @return
 */
function getSession(){
    
    
}

/**
 * currentActionIn()
 * 
 * @param mixed $actions
 * @return
 */
function currentActionIn($actions){
    
    if( Dispatch::$init == 0 ){
        return false;
    }
    $path = Dispatch::$path;
    $controller = Dispatch::$controller;
    $action = Dispatch::$action;
    
    if(  $path == "" ){
        $currenAction = sprintf('/%s/%s',$controller,$action);
    }else{
        $currenAction = sprintf('/%s/%s/%s',$path,$controller,$action);
    }
    
    foreach( $actions  as $action ){
        if($currenAction == $action){
            return true;
        }
    }
    return false;
    
}

/**
 * returnMsg()
 * 
 * 输出json字符串消息
 * 
 * @param int $result_code  消息码
 * @param string $result_desc 消息内容
 * @param mixed $arr 消息扩展内容
 * @return json消息字符串
 */
function returnMsg($result_code,$result_desc="",$arr = array() ){
    
    if( !headers_sent() ){
        header("Content-type:text/html;charset=utf-8");
    }
    
    if( is_numeric($result_code) ){   
        
        $array = [
                    'result_code'=>$result_code,
                    'result_desc'=>$result_desc
                 ];
                 
        $array = array_merge($array,$arr);
       
        exit(json_encode( $array,JSON_UNESCAPED_UNICODE ));
        
    }else{
        
        $msg = $result_code;
        
        exit( $msg );
        
    }
    
}