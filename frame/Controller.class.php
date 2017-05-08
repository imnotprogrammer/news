<?php

abstract class Controller{
      
    /**
     * Controller::assign()
     * 
     * ������smarty��assign���������ݲ���
     * 
     * @param string $name ��������
     * @param string $var ֵ
     * @return
     */
    public function assign($name,$var){
        Template::assign($name,$var);
    }
    
    /**
     * Controller::display()
     * 
     * �����Ǹ�ģ��
     * 
     * @param string $file ģ���ļ���
     * 
     * @return
     */
    public function display($file){
        Template::display($file);
    }
    
    /**
     * Controller::getParams()
     * 
     * ��ȡ����
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