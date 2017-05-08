<?php

abstract class Controller{
      
    /**
     * Controller::assign()
     * 
     * 类似于smarty的assign方法，传递参数
     * 
     * @param string $name 变量名称
     * @param string $var 值
     * @return
     */
    public function assign($name,$var){
        Template::assign($name,$var);
    }
    
    /**
     * Controller::display()
     * 
     * 调用那个模版
     * 
     * @param string $file 模版文件名
     * 
     * @return
     */
    public function display($file){
        Template::display($file);
    }
    
    /**
     * Controller::getParams()
     * 
     * 获取参数
     * 
     * @return
     */
    public function getParams(){
        return [
            'path'=>Dispatch::$path,
            'action'=>Dispatch::$action,
            'controller'=>Dispatch::$controller,
        ];
    }
    
}