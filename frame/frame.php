<?php
$currentDir = dirname(__FILE__);

include $currentDir . '/Controller.class.php';

include $currentDir . '/Dispatch.class.php'; 

include $currentDir . '/Template.class.php';

include $currentDir . '/perana.php'; 

/*自动加载*/
function frame_auto_load($className){
    
    $currentDir = dirname(__FILE__);
    
    if( in_array($className,['Csql','DB','Record','Query']) ){
        
        include_once $currentDir . '/db/' . $className . '.class.php';
           
    }elseif( $className == 'Db_Instance' ){
        
        include_once $currentDir . '/db/DB.class.php';
        
    }elseif( in_array($className,['CurlBase','Page','ValidateCode','PHPMailer','Smtp']) ){
        
        include_once $currentDir . '/extensions/' . $className . '.class.php' ;
        
    }elseif( $className == "Memcached_Action"){
        
        include_once $currentDir . '/extensions/Memcached.class.php';
        
    }elseif( $className == "Smarty" ){
        
        include_once $currentDir . '/smarty/Smarty.class.php';
        
    }elseif( $className == "AliyunOSSClient" ){
        
        include_once $currentDir . '/extensions/ALIOSS/AliyunOSSClient.class.php';
        
    }elseif( $className == "Debug" ){
        
        include_once $currentDir . '/Debug.class.php';
        
    }elseif( $className == 'ALIOSS' ){
        
        include $currentDir . '/extensions/oss/ALIOSS.class.php';
        
    }else{
        
        return false;
        
    }
    
    return true;
    
}

spl_autoload_register('frame_auto_load');

function aliossclassLoader($class){

    if( preg_match('/OSS/',$class) ){
        $class =str_replace('\\','/',$class);
        $file = __DIR__ . '/extensions/' . $class .  '.php';
        if (file_exists($file)) {
            require_once $file;
        }
    }
    
}

spl_autoload_register('aliossclassLoader');