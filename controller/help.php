<?php
class HelpController extends Controller{
    
    public function indexAction(){
        
        $this->display('site/help.tpl');  
        
    }
}