<?php
require __DIR__ . '/config/config.inc.php';

require WEB_ROOT . '/frame/frame.php';

require WEB_ROOT . '/common/spl_autoload.php';

require WEB_ROOT . '/common/public.function.php';

session_start();

 //login_test();
$Dispatch = new Dispatch();

$Dispatch->exec();
 
 