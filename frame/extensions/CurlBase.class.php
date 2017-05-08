<?php
/**
 * CurlBase
 * 
 * @package   
 * 
 */
class CurlBase{
    
    const WEB_CURL_DEBUG = 1;
    
    /**
     * CurlBase::curl()
     * 
     * 发起一个curl模拟的http请求
     * 
     * @param string $url  url地址
     * @param mixed $post  POST的数据 false | array()
     * @param bool $https 是否是https安全连接
     * @param mixed $cookie false 不发送cookie | 发送cookie的字符串
     * @return
     */
    static function curl($url, $post = FALSE,$https = FALSE,$cookie=false){
    	ob_start();
    	$ch = curl_init($url);
    	curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    	if ($post){
    		curl_setopt($ch, CURLOPT_POST, true);
    		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post) );
    	}
        if($https){
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		}
        if($cookie){
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        }
        if( self::WEB_CURL_DEBUG ){
            
            $curlCmd = 'curl %s --data "%s"';
            $data = http_build_query($post);
            $curlCmd = sprintf($curlCmd , $url , $data );
            error_log(urldecode($curlCmd) );
            
        }
    	curl_exec($ch);
    	curl_close($ch);
    	$_str = ob_get_contents();
    	ob_end_clean();
    	return $_str;
    }
    
    /**
     * CurlBase::multiCurl()
     * 并发多个相同url地址的http请求
     * 
     * @param mixed $datas 数据
     * @param mixed $url url地址
     * @return
     */
    static function multiCurl($datas,$url){
    
        $mh = curl_multi_init();
        $handles = array();
        
        foreach( $datas as $key=>$data ){
            $handles[$key] = curl_init($url);
            curl_setopt($handles[$key], CURLOPT_TIMEOUT, 30);
            curl_setopt($handles[$key], CURLOPT_POST, true);
            curl_setopt($handles[$key], CURLOPT_POSTFIELDS, http_build_query($data) );
            curl_setopt($handles[$key], CURLOPT_RETURNTRANSFER,1);
            curl_multi_add_handle($mh,$handles[$key]);
            if( self::WEB_CURL_DEBUG ){
            
                $curlCmd = 'curl %s --data "%s"';
                $data = http_build_query($data);
                $curlCmd = sprintf($curlCmd , $url , $data );
                error_log($curlCmd);
            
            }
        }
        $runing = "";
        do {
            
            $mrc = curl_multi_exec($mh, $runing);
            
        } while ($runing>0);
        
        $datas = array();
        
        foreach( $handles as $key=>$ch ){
            
            $datas[$key] = curl_multi_getcontent($ch);
            curl_multi_remove_handle($mh, $ch);
            
        }
        
        curl_multi_close($mh);
        return $datas;
        
    }
}
