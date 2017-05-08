<?php
class VerCodeController extends Controller{
    
    /**
     * /vercode/index
     * 请求验证码
     * 
     */
    public function indexAction(){
        $ValidateCode = new ValidateCode();
        $ValidateCode->doimg();
        $code = $ValidateCode->getCode();
        $_SESSION['bmzj']['vercode'] = $code;
    }
    
}