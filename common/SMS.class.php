<?php

class SMS{
    
    var $appkey;//您申请的APPKEY
    var $mobile;//接受短信的用户手机号码
    var $tplid;//您申请的短信模板ID，根据实际情况修改
    var $tplvalue;//您设置的模板变量，根据实际情况修改
    var $sendUrl = 'http://v.juhe.cn/sms/send'; //短信接口的URL


function sendsms($appkey,$mobile,$tplid,$tplvalue){

    $this->appkey = $appkey;
    $this->mobile = $mobile;
    $this->tplid = $tplid;
    $this->tplvalue = $tplvalue;
    
    $smsConf = array(
        'key'       => $this->appkey, //您申请的APPKEY
        'mobile'    => $this->mobile, //接受短信的用户手机号码
        'tpl_id'    => $this->tplid, //您申请的短信模板ID，根据实际情况修改
        'tpl_value' => $this->tplvalue //您设置的模板变量，根据实际情况修改
    );//post方式
    //$smsConf2 = 'key='.$this->appkey.'&mobile='.$this->mobile.'&tpl_id='.$this->tplid.'&tpl_value='.$this->tplvalue;  get方式
    
    //$content = $this->juhecurl($this->sendUrl,$smsConf,1); //请求发送短信
    return json_encode(array('error_code'=>0));
}
   
/**
 * 请求接口返回内容
 * @param  string $url [请求的URL地址]
 * @param  string $params [请求的参数]
 * @param  int $ipost [是否采用POST形式]
 * @return  string
 */
function juhecurl($url,$params=false,$ispost=0){
    $httpInfo = array();
    $ch = curl_init();
 
    curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
    curl_setopt( $ch, CURLOPT_USERAGENT , 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22' );
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 30 );
    curl_setopt( $ch, CURLOPT_TIMEOUT , 30);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
    if( $ispost )
    {
        curl_setopt( $ch , CURLOPT_POST , true );
        curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
        curl_setopt( $ch , CURLOPT_URL , $url );
    }else{
        if($params){
            curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
        }else{
            curl_setopt( $ch , CURLOPT_URL , $url);
        }
    }
    $response = curl_exec( $ch );
    if ($response === FALSE) {
        //echo "cURL Error: " . curl_error($ch);
        return false;
    }
    $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
    $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
    curl_close( $ch );
    return $response;
}    
    
}

 



 

