<?php
class SendEmail{
    
   static function send($qmail,$code,$type=1){
	   require_once WEB_ROOT.'/phpemailer/class.phpmailer.php';
	   require_once WEB_ROOT.'/phpemailer/class.smtp.php';
            if($type == 1){
				
				     $subject =  "找回密码";
					 $body    =  '重置密码:'.$code.'&nbsp;&nbsp<a href="http://xxxx.xxx/index/login">去验证</a>';
				  $returnStr  =   "密码已经发送至用户邮箱";
					 
			}else{
				
				     $subject =  "验证码";
					 $body    =  '注册用户验证码:'.$code.'<p style="color:red;">请不要将此验证吗透露给别人!</p>';
				  $returnStr  =   "验证码已经发送至用户邮箱";
			}
  
			$mail             = new PHPMailer(); 

			//设置smtp参数 
			$mail->IsSMTP(); 
			$mail->SMTPAuth   = true; 
			$mail->SMTPKeepAlive = true; 
			$mail->SMTPSecure = "ssl"; 
			$mail->Host       = "smtp.qq.com"; 
			$mail->Port       = 465; 
			//填写你的gmail账号和密码 
			$mail->Username   = EMAIL_USER; 
			$mail->Password   = EMAIL_PASS; 
			//设置发送方，最好不要伪造地址 
			$mail->From       = EMAIL_FROM; 
			$mail->FromName   = "新闻之家"; 
			$mail->Subject    = $subject; 
			$mail->Body       = $body;
			$mail->AltBody    = ""; 
			$mail->WordWrap   = 50; // set word wrap 
			$mail->AddAddress($qmail,"FirstName LastName"); 
			//使用HTML格式发送邮件 
			$mail->IsHTML(true); 
			//通过Send方法发送邮件 
			//根据发送结果做相应处理 
			if(!$mail->Send()) { 
			  return [201,"Mailer Error: " . $mail->ErrorInfo]; 
			} else { 
			  
			  return [200,$returnStr]; 
			}

    }
   
}