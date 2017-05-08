<?php
class Ftpfile{
	private $fileInfos;
	private $type;
	private $keyname;
    public function __construct(){

    }
	public function  ftp($keyName='file',$path='upload',$filetype=1){
	   if(empty($_FILES[$keyName]['name'])){
			return 1;
			exit;
		}
		$type=$_FILES[$keyName]['type'];
		if($type!="image/jpeg" && $type!="image/png"){
			alertMSg("上传图片的格式不对","/user/index/setgen");
			exit;
		}
			
       $this->keyName=$keyName;
		$uploaddir ='./'.$path.'/';
		$pic=explode('.',$_FILES[$this->keyName]['name']);
		$type=$pic[1];
		$time=time();
		//echo $_FILES[$this->keyName]['tmp_name'];
	
        $uploadfile =$uploaddir.$_FILES[$this->keyName]['name'];
        
		
		if (move_uploaded_file($_FILES[$this->keyName]['tmp_name'], $uploadfile)) {
			return $uploadfile;//'/'.$path.'/'.$time.'.'.$type;
		} else {
			//echo "Possible file upload attack!\n";
			alertMSg("上传图片失败！","/user/index/setgen");
		}

;
	}
}
?>