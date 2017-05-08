<?php
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

function login_test(){
	
	$_SESSION['news']['uno']='10000';
	$_SESSION['news']['uname']='又一轮明月';
	$_SESSION['news']['qq']='1441360095';
    $_SESSION['news']['sno']='111111';
    $_SESSION['news']['utype']=1;
    $_SESSION['news']['uphone']="18113219503";
	$_SESSION['news']['email']="18113219503@qq.com";
	
}

function json_html_escape($str){
    $arr = json_decode($str,true);
    $arr = html_escape($arr);
    return json_encode($arr);
}


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

function getPage($pageNum){
    $page = !empty($_GET['page'])?$_GET['page']:1;
   	$start = ($page-1)*$pageNum;
    return [$page,$start];
}

function getSession(){
    
    return [$uid,$ukey,$uname,$level];
    
}

function checkPrivilege($privilegeWeight,$type=0){
    $uweight = $_SESSION['news']['upower'];
    if( $privilegeWeight & $uweight ){
        return true;
    }else{
        if( $type == 1 ){
            returnMsg(300,'没有权限！');
        }
        return false;
    }
}

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
 
function userType($n){
	if($_SESSION['news']['utype']==$n){
		return true;
	}else{
		return false;
	}
}
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

function sendEmail($to,$subject,$body,$type = ""){
    global $emailConfig;
    $emailFrom = $emailSmtpAddress = $emailUser = $emailPassword = "";
    
    extract($emailConfig);
    $Smtp =new Smtp($emailSmtpAddress,25,true,$emailUser,$emailPassword);
    return $Smtp->sendmail($to,$emailFrom,$subject,$body,$type);
}

function getIpAddress(){
    $url = 'http://opendata.baidu.com/api.php?query=1.85.35.131&co=&resource_id=6006&t=1329357746681&ie=utf8&oe=utf8&cb=bd__cbs__9slgza&format=json&tn=baidu';
}

function getVerPhoneCode(){
    return $_SESSION['news']['ver_phonecode'];
}

function getUno(){
    return $_SESSION['news']['uno'];
}

function getUphone(){
    return $_SESSION['news']['uphone'];
}

function getSno(){
    return $_SESSION['news']['sno'];
}

function isShopUser(){
    if( $_SESSION['news']['utype'] ==2 ){
        return true;
    }else{
        return false;
    }
}

function isUser(){
    if( $_SESSION['news']['utype'] ==1 ){
        return true;
    }else{
        return false;
    }
}

function isAdmin(){
    if( $_SESSION['news']['utype'] == 3 ){
        return true;
    }else{
        return false;
    }
}

function getPoundage($money){
    return 0;
}

function isLogin(){
    if( !empty($_SESSION['news']['uno']) ){
        return true;
    }else{
        header('location:/index/login');
        exit;
    }
}

function md5_encrypt($str){
    return md5(md5($str));
}

function calScore($total,$count){
    if( $count ){
        return $total/$count;
    }else{
        return 4;
    }
}

function scoreImg($total,$count){
    $count = calScore($total,$count);
    $imgs = [];
    for( $i=0;$i<=$count;$i++ ){
        $imgs[] = '<img src="/res/img/yellow_star.png">';
    }
    echo implode('',$imgs);
}

function alertMsg($msg,$url=""){
    if( empty($url) ){
        echo '<script type="text/javascript">alert("' .str_replace('"','\'',$msg) . '");history.go(-1);</script>';
    }else{
        echo '<script type="text/javascript">alert("' .str_replace('"','\'',$msg) . '");window.location.href="' . $url . '"</script>';
    }
    exit;
}

function produceVerPhoneCode(){
    $_SESSION['news']['codekey'] = md5(time().rand(1000,10000));
    return $_SESSION['news']['codekey'];
}
function produceVerkey(){
    $_SESSION['form']['key'] = md5(time().rand(1000,10000));
    return $_SESSION['form']['key'];
}
function verFormKey($key){
    return isset($_SESSION['form']['key']) && $key==$_SESSION['form']['key'];
}

function getUserArea(){
    return $_SESSION['userarea'];
}

function getUserAreaByIp(){
    if( empty($_SESSION['userarea']) ){
        $info = file_get_contents( 'http://ip.taobao.com/service/getIpInfo.php?ip=' . $_SERVER['REMOTE_ADDR'] );
        $areaInfo = json_decode($info,true);
        
        if( $areaInfo['code'] == 0 ){
            $_SESSION['userarea'] = [
                'time'=>time(),
                'provId'=>0,
                'cityId'=>0,
                'countyId'=>0,
                'cityName'=>'-'
            ];
            
            $prov = Query::init()
                    ->from('prov_city_area_info')
                    ->andWhere('pcai_name=?',$areaInfo['data']['region'])
                    ->one();
                    
             if( !empty($prov) ){
                $_SESSION['userarea']['provId'] = $prov['pcai_no'];
                
                $city = Query::init()
                        ->from('prov_city_area_info')
                        ->andWhere('pcai_name=? and pcai_pno=?',[$areaInfo['data']['city'],$prov['pcai_no'] ])
                        ->one();
                        
                if( !empty($city) ){
                    
                    $_SESSION['userarea']['cityId'] = $city['pcai_no'];
                    $_SESSION['userarea']['cityName'] = $city['pcai_name'];
                    $county = Query::init()
                                ->from('prov_city_area_info')
                                ->andWhere('pcai_name=? and pcai_pno=?',[$areaInfo['data']['county'],$city['pcai_no']])
                                ->one();
                                
                    if (!empty($county) ){
                        $_SESSION['userarea']['countyId'] = $city['pcai_no'];
                    }
                    
                }
                
            }
        }
    }else{
        //var_dump($_SESSION['userIpArea']);
    }
}
function unicode_encode($name)
{
    //$name = iconv('UTF-8', 'UCS-2', $name);
    $len = strlen($name);
    $str = '';
    for ($i = 0; $i < $len - 1; $i = $i + 2)
    {
        $c = $name[$i];
        $c2 = $name[$i + 1];
        if (ord($c) > 0)
        {   //两个字节的文字
            $str .= '\u'.base_convert(ord($c), 10, 16).str_pad(base_convert(ord($c2), 10, 16), 2, 0, STR_PAD_LEFT);
        }
        else
        {
            $str .= $c2;
        }
    }
    return $str;
}

//将UNICODE编码后的内容进行解码
function unicode_decode($name)
{
    //转换编码，将Unicode编码转换成可以浏览的utf-8编码
    $pattern = '/([\w]+)|(\\\u([\w]{4}))/i';
    preg_match_all($pattern, $name, $matches);
    if (!empty($matches))
    {
        $name = '';
        for ($j = 0; $j < count($matches[0]); $j++)
        {
            $str = $matches[0][$j];
            if (strpos($str, '\\u') === 0)
            {
                $code = base_convert(substr($str, 2, 2), 16, 10);
                $code2 = base_convert(substr($str, 4), 16, 10);
                $c = chr($code).chr($code2);
                $c = iconv('UCS-2', 'UTF-8', $c);
                $name .= $c;
            }
            else
            {
                $name .= $str;
            }
        }
    }
    return $name;
}

function getUnicodeFromOneUTF8($word) {
		//获取其字符的内部数组表示，所以本文件应用utf-8编码!
		if (is_array( $word))
		$arr = $word;
		else
		$arr = str_split($word);
		//此时，$arr应类似array(228, 189, 160)
		//定义一个空字符串存储
		$bin_str = '';
		//转成数字再转成二进制字符串，最后联合起来。
		foreach ($arr as $value)
		$bin_str .= decbin(ord($value));
		//此时，$bin_str应类似111001001011110110100000,如果是汉字"你"
		//正则截取
		$bin_str = preg_replace('/^.{4}(.{4}).{2}(.{6}).{2}(.{6})$/','$1$2$3', $bin_str);
		//此时， $bin_str应类似0100111101100000,如果是汉字"你"
		//return bindec($bin_str);
		//返回类似20320， 汉字"你"
		return dechex(bindec($bin_str));
		//如想返回十六进制4f60，用这句
}