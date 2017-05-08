<?php

/*网站根目录*/
define( 'WEB_ROOT',dirname(__Dir__) );
define('ROOT_DIR','http://127.0.0.1');
/*js、css、image 的根目录，和版本*/

define( 'JS_ROOT', '/res/js' );

define( 'CSS_ROOT','/res/css');

define( 'IMG_ROOT','/res/img');

define( 'JS_VERSION','0.1');

define( 'CSS_VERSION','0.1');

define( 'PER_NUM_COUNT',10);
/*网站url*/
define('WEB_URL','http://www.jimjic.cn');

/*pingpp支付的配置*/



/*数据库*/

define('DB_ROOT','your user');
define('DB_PWD','your password');
define('DB_HOST','127.0.0.1');
define('DB_NAME','news');

/*OSS*/
define('OSS_ACCESS_ID', 'Lmwjy5cybQePsFIP');
define('OSS_ACCESS_KEY', 'WQ3g98s3c07C4exGWQlHAj4FWA95Rv');
define('OSS_BMZJ_BUCKET', 'bmzj');
define('OSS_ENDPOINT','bmzj.oss-cn-hangzhou-internal.aliyuncs.com');
define('OSS_BMZJ_PUBLIC_DOMAIN','bmzj.oss-cn-hangzhou.aliyuncs.com');

/*邮件*/
define('EMAIL_FROM','lanyuguo.nan@foxmail.com');
define('EMAIL_STMP_ADDRESS','smtp.qq.com');
define('EMAIL_USER','lanyuguo.nan@foxmail.com');
define('EMAIL_PASS','lkpekbiuyqgefegh');
/*$emailConfig = [
    'emailFrom' => '2013814909@qq.com',
    'emailSmtpAddress' => 'smtp.qq.com',
    'emailUser'    => '2013814909@qq.com',
    'emailPassword'=>'wasd199312'    
];*/

/*权限*/

define('LOGIN_WEIGHT',1);
