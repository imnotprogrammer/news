<?php
exit;
$auto = 0; //不自动清楚bom

function checkdir($basedir){
    if($dh=opendir($basedir)){
        while (($file=readdir($dh)) !== false){
            if($file != '.' && $file != '..'){
                if(!is_dir($basedir.'/'.$file)){
                    if( $str = checkBOM($basedir.'/'.$file) ){
                        echo '文件: '.$basedir.'/'.$file .checkBOM($basedir.'/'.$file).' <br>';
                    }
                }else{
                    $dirname=$basedir.'/'.$file;
                    checkdir($dirname);
                }
            }
        }
        closedir($dh);
    }
}

function checkBOM($filename){
    global $auto;
    $contents=file_get_contents($filename);
    $charset[1]=substr($contents,0,1);
    $charset[2]=substr($contents,1,1);
    $charset[3]=substr($contents,2,1);
    if(ord($charset[1])==239 && ord($charset[2])==187 && ord($charset[3])==191){
        if($auto==1){
            $rest=substr($contents,3);
            rewrite($filename,$rest);
            return (' <font color=red>找到BOM并已自动去除</font>');
        }else{
            return (' <font color=red>找到BOM</font>');
        }
    }else{
        return false;
        return (' 没有找到BOM');
    }
}

function rewrite($filename,$data){
    
    if( is_file($filename) ){
        file_put_contents($filename,$data);
    }
    
}