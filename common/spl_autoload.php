<?php

function bmzj_sql_autoload($className){
    
    $maps = [
        'SMS'=> WEB_ROOT . '/common/SMS.class.php',
        'SendEmail'=> WEB_ROOT . '/common/SendEmail.class.php',
        'UploadFile'=> WEB_ROOT . '/common/UploadFile.class.php',
        'User'=>WEB_ROOT . '/model/User.class.php',
        'UserAddr'=>WEB_ROOT . '/model/UserAddr.class.php',
        'UserMessage'=>WEB_ROOT . '/model/UserMessage.class.php',
        'UserCollect'=>WEB_ROOT . '/model/UserCollect.class.php',
        'UserInfo'=>WEB_ROOT . '/model/UserInfo.class.php',
        'Orders'=>WEB_ROOT . '/model/Orders.class.php',
        'Job'=>WEB_ROOT . '/model/Job.class.php',
        'Shop'=>WEB_ROOT . '/model/Shop.class.php',
        'ClassInfo'=>WEB_ROOT . '/model/ClassInfo.class.php',
        'Areas'=>WEB_ROOT . '/model/Areas.class.php',
	    'Ftpfile'=> WEB_ROOT . '/common/Ftpfile.class.php',
		'NewClass'=> WEB_ROOT . '/model/NewClass.class.php'

    ];
    
    if( isset($maps[$className]) ){
        require $maps[$className];
        return true;
    }else{
        return false;
    }
}

spl_autoload_register('bmzj_sql_autoload');