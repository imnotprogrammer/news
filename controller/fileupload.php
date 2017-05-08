<?php
   class FileuploadController extends Controller{
      public function indexAction(){
		  $upfileobj=new Ftpfile();
		  $imgurl=$upfileobj->ftp('file','img-news',2);
		  $fp = fopen('./img-news/'.getUno().'.txt','a');
		  fwrite($fp,"http://localhost".$imgurl.',');
		  //('./img-news/1.txt',$imgurl);
		  echo json_encode(array("jsonrpc"=>"2.0","result"=>$imgurl,"id"=>"id"));
		  //die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
    }
   }
?>