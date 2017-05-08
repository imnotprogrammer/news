<?php



require WEB_ROOT . '/frame/extensions/OSS/OssClient.php';

use OSS\OssClient;
use OSS\Core\OssException;

class UploadFile{
    
    public $msg = '';
    
    public $fileTypes = ['png','x-png','pjpeg','jpg','jpeg','bmp'];
    
    public $extTypes = ['png'=>'png','x-png'=>'png','pjpeg'=>'pjpeg','jpg'=>'jpg','jpeg'=>'jpeg','bmp'=>'bmp'];
    
    public $fileInfos = [];
    
    public $errorFileInfo = [];
    
    public $tmpDir = '/tmp';
    
    public $type;//mustSelectFile,noSelectFile
    
    public function __construct($keyName='file',$type="mustSelectFile"){
       if( is_string($_FILES[$keyName]['name']) ){
            $files[] = $_FILES[$keyName];
        }else{
            foreach( $_FILES[$keyName]['name'] as $key=>$name){
                $files[$key] = [
                    'name'=>$_FILES[$keyName]['name'][$key],
                    'type'=>$_FILES[$keyName]['type'][$key],
                    'tmp_name'=>$_FILES[$keyName]['tmp_name'][$key],
                    'error'=>$_FILES[$keyName]['error'][$key],
                    'size'=>$_FILES[$keyName]['size'][$key]
                ];
            }
        }
        $this->fileInfos = $files;
        $this->type = $type;
    }
    
    public function validateFile(){
        
        $files = $this->fileInfos;
        
        foreach( $files as $key=>$file){
            
            if( $file['error'] == 4){
                
                if( $this->type == 'noSelectFile' ){
                    continue;
                }else{
                    $this->msg = '请选择文件！';
                    return false;
                }
                
            }elseif( $file['error'] != '0' ){
                $this->msg = '上传错误';
                $this->errorFileInfo = $file;
                return false;
            }
            
            $exts = explode('/',$file['type']);
            $ext = end($exts);
            
            $files[$key]['ext'] = $ext;
            
            if( !in_array(strtolower($ext),$this->fileTypes) ){
                $this->msg = '上传文件类型不正确！';
                $this->errorFileInfo = $file;
                return false;
            }
            
            if( $file['size'] > 1024*1024 ){
                $this->msg = '图片的大小不能超过1M';
                $this->errorFileInfo = $file;
                return false;
            }
            
            if( dirname($file['tmp_name']) != $this->tmpDir ){
                $this->msg = '未知错误！';
                $this->errorFileInfo = $file;
                return false;
            }
            
        }
        return true;
    }

    public function uploadALIOSS(){
        
        $files = $this->fileInfos;
        
        foreach( $files as $key=>$file){
            
            if( $file['error'] == 4){
                
                if( $this->type == 'noSelectFile' ){
                    continue;
                }else{
                    $this->msg = '请选择文件！';
                    return false;
                }
                
            }elseif( $file['error'] != '0' ){
                $this->msg = '上传错误';
                $this->errorFileInfo = $file;
                return false;
            }
            
            $exts = explode('/',$file['type']);
            $ext = end($exts);
            
            $files[$key]['ext'] = $ext;
            
            if( !in_array(strtolower($ext),$this->fileTypes) ){
                $this->msg = '上传文件类型不正确！';
                $this->errorFileInfo = $file;
                return false;
            }
            
            if( $file['size'] > 1024*1024 ){
                $this->msg = '图片的大小不能超过1M';
                $this->errorFileInfo = $file;
                return false;
            }
            
            if( dirname($file['tmp_name']) != $this->tmpDir ){
                $this->msg = '未知错误！';
                $this->errorFileInfo = $file;
                return false;
            }
            
        }
        
        $returnFiles = [];
        
        try {
            $ossClient = new OssClient(OSS_ACCESS_ID, OSS_ACCESS_KEY, OSS_ENDPOINT, true);
        } catch (OssException $e) {
            Debug::log( $e->getMessage() );
        }

        foreach( $files as $key=>$file ){
            
            if( $this->type == "noSelectFile" && $file['error'] == 4 ){
                continue;
            }
            
            for( $i=0;$i<3;$i++ ){
                $rfile = md5('bmzj/' . time() .rand(100000,1000000) ) . '.' . $this->extTypes[$ext];
                try{
                    $options = [
                        ALIOSS::OSS_HEADERS=>[
                            'Content-Type'=>$file['type']
                        ]
                    ];
                    $ossClient->uploadFile(OSS_BMZJ_BUCKET, $rfile, $file['tmp_name'],$options);
                    $status = 1;
                    break;
                }catch( OssException $e ){
                    
                }
            }
            
            if( $status ){
                $returnFiles[] = 'http://' . OSS_BMZJ_PUBLIC_DOMAIN . '/' . $rfile;
            }else{
                $this->msg = '网络错误！';
                $this->errorFileInfo = $file;
                return false;
            }
            
        }
        
        return $returnFiles;
        
    }
    
    public function isUploadFiles(){
        
        $files = $this->fileInfos;
        foreach( $files as $key=>$file){
            
        }
    }
    
}
