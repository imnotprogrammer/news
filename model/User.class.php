<?php
class User{
  public $db;
  public function __construct(){
    $this->db = DB::init();     
  }
  //用户注册
  public function regUser($email,$pwd,$key){
    $uname = 'xwzj_'.rand(10000,20000);
    //$phone = $phone ? $phone : 0;
    $email = $email ? $email : "null";
    $ui_no = rand(111111,999999999);
    $sql = 'insert into user_info values(?,?,?,?,?,?,?,?,?,?,?,?,?,?);';
    $params = [$uname,'',$ui_no,$email,'',1,1,md5($pwd),time(),'',1,'','',md5($key)];             
    return $this->db->exec($sql,$params,100);  
  }  
    public function getUserByEmailOrPhone($emailOrPhone){
        
            $sql = 'select * from user_info where ui_phone=? or ui_email=? limit 1';
            $param = [$emailOrPhone,$emailOrPhone];
            return $this->db->exec($sql,$param,102);
            
    }
    public function getUserList($uno){
        
        $sql = 'select ui_no,ui_name,ui_qq,ui_sex from user_info where ui_no=? limit 1';
        $param = [$uno];
        return $this->db->exec($sql,$param,102);    
    }
  /*
    修改用户的密码为某个值
  */
  public function resetpas($uname,$upass){
    $sql = 'update user_info set ui_pass=?,ui_lastlog_time=? where ui_phone=? or ui_email=? limit 1';
    $param = [$upass,time(),$uname,$uname];
    return $this->db->exec($sql,$param);   
  }
  /*
    修改用户的基本信息
  */
  public function setUserOne($uname,$uqq,$uwx,$usex,$uno){
    $sql = 'update user_info set ui_name=?,ui_qq=?,ui_weixin=?,ui_sex=? where ui_no=? limit 1';
    $param = [$uname,$uqq,$uwx,$usex,$uno];
    return $this->db->exec($sql,$param);   
  }
  /* 
    查询手机、邮箱是否重复
  */
  public function getUserPhoneEmail($value,$type){
    $sql='select ui_no from user_info where ';
    if($type=='phone'){
      $sql.='ui_phone=?';        
    }elseif($type=='email'){
      $sql.= 'ui_email=?';      
    }else{
      return true;        
    }
    $param=[$value];
    $list=$this->db->exec($sql.' limit 1',$param,102); 
    if(!empty($list)){
      return true;    
    }else{
      return false;      
    }        
  }
  /*
    通过用户密码和登录密码查询某个用户是否存在
  */
  public function bypasscheckexist($uno,$upass){
    $sql='select ui_no from user_info where ui_no=? and ui_pass=? limit 1';
    $param=[$uno,$upass];
    $list=$this->db->exec($sql,$param,102);
    if(!empty($list)){
      return true;    
    }else{
      return false;      
    }
  }
  /*
    修改手机号码
  */
  public function updateUserPhone($uphone,$uno){
    $sql='update user_info set ui_phone=? where ui_no=? limit 1';
    $param=[$uphone,$uno];
    return $this->db->exec($sql,$param);
  }
  /*
    修改支付密码
  */
  public function updateUserPayPass($paypass,$uno){
    $sql='update user_info set ui_pay_pass=? where ui_no=? limit 1';
    $param=[$paypass,$uno];
    return $this->db->exec($sql,$param);         
  }
  /*
    修改提现密码
  */
  public function updateUserWithdrawPass($withdrawpass,$uno){
    $sql='update user_info set ui_withdraw_pass=? where ui_no=? limit 1';
    $param=[$withdrawpass,$uno];
    return $this->db->exec($sql,$param);         
  }
  /*
    修改邮箱
  */
  public function updateUserEmail($uemail,$uno){
    $sql = 'update user_info set ui_email=? where ui_no=? limit 1';
    $param = [$uemail,$uno];
    return $this->db->exec($sql,$param);        
  }
  /*
    修改密码
  */
  public function updateUserPass($upass,$uno){
    $sql='update user_info set ui_pass=? where ui_no=? limit 1';
    $param=[$upass,$uno];
    return $this->db->exec($sql,$param);    
  }
  public function getTabNews(){
	  $newsql = "select * from news_info where ni_status=? order by ni_ctime desc limit 10";
	  $hotsql = "select * from news_info where ni_status=? order by ni_browser desc limit 10";
	  $data['news']['title'] = '最新';
	  $data['news']['list'] = $this->db->exec($newsql,[2],103);
	  $data['hot']['title'] = '最热';
	  $data['hot']['list'] = $this->db->exec($hotsql,[2],103);
	  return $data;
  }
  public function getTypeNews($type,$start,$num=PER_NUM_COUNT){
		  $sql = "select * from news_info  where ni_status=2 and ni_type=? order by ni_ctime desc limit %s,%s ";
		  $sql =sprintf($sql,$start,$num);
		  $sql2 = "select count(*) from news_info  where ni_status=2 and ni_type=? ";
		  //$sql2 =sprintf($sql,$start,$num);
		  $data['list'] = $this->db->exec($sql,[$type],103);
		  $data['count'] = $this->db->exec($sql2,[$type],101);
		  //echo $data['count'];
		  return $data;
	  }
	  public function getFavoNews($uno,$start,$num=PER_NUM_COUNT){
		  $favo = Query::init()->select('ui_favo')->from("user_info")->andWhere('ui_no=?',[$uno])->one();
           //echo $favo['ui_favo'];
		   //print_r($favo);
		   //return null;
		   //print_r($favo['ui_favo']);
          		   
		  $favos = json_decode($favo['ui_favo'],true);
		 // print_r($favos);
		 if(empty($favos)){
			 
			  return null;
			  
			  //exit;
		  }
		  $sql = "select * from news_info where ni_status=2 and  ";
		  foreach($favos as $k=>$v){
			  if($k==count($favos)-1){
			     $sql.="ni_type =? ";
			  }else{
				  $sql.="ni_type =? or "; 
			  }	   
		  }
		  $sql2=$sql;
		  $sql.=" order by ni_ctime desc limit %s,%s ";
		  $sql1 =sprintf($sql,$start,$num);
		 // $data['list'] = $this->db->exec($sql2,[$type],103);
		  $data['list'] = $this->db->exec($sql1,$favos,103);
		  $data['count'] = $this->db->exec($sql2,$favos,101);
		  return $data;
	  }
	public function getComment($no,$start){
		$sql = 'select ui_header,ui_name,ci_body,ci_ctime from comment_info inner join user_info on ui_no=ci_uno where ci_nno=?  order by ci_ctime desc limit %d,10';
		//$sql1 = "select count(*) from comment_info where ci_nno=? order by ci_ctime desc ";
		$sql = sprintf($sql,$start);
		//echo $sql;
		 $data = $this->db->exec($sql,[$no],103);
		 file_put_contents('ss.txt',$sql);
		return $data;
	}
	public function getIndexNews(){
		$alltype = $this->db->exec("select * from news_type_info",['order by nti_ctime desc'],103);
		
		foreach($alltype as $type){
			$data['list'] = $this->db->exec('select ni_title,ni_no,ni_if_img_text from news_info where ni_status=2 and ni_type=? order by ni_ctime desc limit 10',[$type['nti_no']],103);
			$data['name'] = $type['nti_name'];
			$data['type'] = $type['nti_no'];
			$rs[] = $data;
		}
		//print_r($rs);
		return $rs;
		//$query =  new Query();
		
	}
	public function searchData($key,$start){
		//$key=unicode_decode($key);
		//echo $key;
		//$key = iconv('utf8','gbk',$key);
		//$key= json_encode($key);
		//$key = str_replace('\u','_',$key);
	   //file_put_contents('ss.txt',$key);
		/*$sql = 'select * from news_info where ni_status=2 order by ni_ctime desc limit '.$start.',10';
	    $sql1 = 'select * from news_info where ni_status=? and ni_title like  %'.$key
		       .'% ';
			 // file_put_contents('ss.txt',$sql);
		$data['list'] = $this->db->query($sql,103);*/
		
		$query = new Query();
		$data['list'] = $query->select('ni_title,ni_no,ni_if_img_text,ni_ctime')
		                              ->from('news_info')
		                              ->andWhere('ni_status=?',[2])
									  ->like('ni_title',$key)
									  ->orderby('ni_ctime desc')
									  ->all();
		$data['count'] = $query->count();							  //print_r($data['list']);
		if(empty($data['list'])){
			return false;
		}
		
		foreach($data['list'] as $list){
			$rs = $list;
			
			$rs['ni_title'] = str_replace($key,'<small style="color:red;">'.$key.'</small>',$list['ni_title']);
            
			$rs['ni_title'] = strip_tags($rs['ni_title'],'<small>');
			$lastrs['list'][] = $rs;
			//echo $rs['ni_title'];	
            $rs ='';			
		}
		$lastrs['count'] = $data['count'];
		//print_r($lastrs);
		//$data['count'] = $this->db->exec($sql1,[2],101);
		return $lastrs;
	}
	public function getPicNews(){
		$data = Query::init()->from('news_info')->andWhere('ni_status=2 and ni_if_img_text=1')->orderby('ni_ctime desc')->limit(5)->all();
		return $data;
	}  
	public function getOnePic($no){
		$pic = Query::init()->from('news_info')->andWhere('ni_no=?',[$no])->one();
		if($pic){
			$piclist = explode(',',$pic['ni_img_news']);
			$count = count($piclist);
			//echo $count;
			$arrdesc = explode('。',$pic['ni_body']);
			$count2 = count($arrdesc);
			if($count>$count2-1){
				for($i=($count2-2);$i<$count-$count2;$i++){
					$arrdesc[$i] = '此图为当时场景情况。';
				}
			}
			/*if($count<$count2-1)){
				for($i=($count-1);$i<$count-(count($arrdesc)-1);$i++){
					$pic[$i] = '此图为当时场景情况。';
				}
			}*/
		    $count = $count>($count2-1)?$count:($count2-1);
			//echo $count;
			//exit;
			for($i=0;$i<$count-1;$i++){
				$data['pic'] = $piclist[$i];
				$data['desc']  = $arrdesc[$i];
				//echo $arrdesc[$i];
				//echo $piclist[$i];
				$rs[] = $data;
			}
			//print_r(count($arrdesc));
			return $rs;
		}
	}
}