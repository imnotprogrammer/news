<?php

/**
 * Template
 * 
 * @package   
 * @author lht
 * 
 */
class Template{
    
    static $smarty = "";
    static $isInit = 0;
    
    /**
     * Template::init()
     * 模版初始化
     * 
     * @return
     */
    public static function init(){
        
        if( !self::$isInit ){
            
            require_once( dirname(__FILE__) . '/smarty/Smarty.class.php');
            $smarty=new Smarty();
            $smarty->setTemplateDir( WEB_ROOT . '/template' )
                   ->setConfigDir( WEB_ROOT . '/common/config' )
                   ->setCompileDir( WEB_ROOT . '/../complie' )
                   ->setCacheDir( WEB_ROOT .'/../cache' )
                   ->addPluginsDir( WEB_ROOT .'/common/myplug' );
            $smarty->left_delimiter='{';
            $smarty->right_delimiter='}';
            self::$smarty = $smarty;
            self::$isInit = 1;
            
        }
        
        return self::$smarty;
        
    }
    
    /**
     * Template::assign()
     * 模版传递变量到视图
     * 
     * @param mixed $name
     * @param mixed $var
     * @return
     */
    public static function assign($name,$var){
         
         if( !self::$isInit ){
            $smarty = self::init();
         }
         self::$smarty->assign($name,$var); 
         
    }
    
    /**
     * Template::display()
     * 模版显示
     * 
     * @param mixed $file
     * @return
     */
    public static function display($file){
        
        if( !self::$isInit ){
            self::init();
        }
        self::$smarty->display($file);
         
    }
    
}