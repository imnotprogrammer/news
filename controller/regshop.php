<?php
class RegShopController extends Controller{
    
    public function indexAction(){
        
        if( $_POST ){
            $phone = $code = $verkey = $reg_upass = $reg_upass_two = $reg_phone = "";
            $pno = $classno = $contact = $contact_phone = $prov = $city = $area = $addr = $shop_name = "";
            extract( safe_extract($_POST) );
            
            $sess_code = $_SESSION['bmzj']['phonecode'][$phone];
        
            if( !$sess_code || $sess_code != $code ){
                alertMsg('验证码不正确！');
            }
            
            if( $reg_upass != $reg_upass_two ){
                alertMsg('两次密码不一致！');
            }
            
            if( strlen($reg_upass)<6 || strlen($reg_upass)>16 ){
                alertMsg('密码不正确，长度为6到16位！');
            }
            
            if( !$classno ){
                alertMsg('请选择分类');
            }
            
            if( !$shop_name ){
                alertMsg('商铺名称不能为空！');
            }
            
            if( !$contact || !$contact_phone || !$prov || !$city || !$area || !$addr ){
                alertMsg('参数不正确！');
            }
            
            $user = Query::init()->select('*')->from('user_info')->andWhere('ui_phone=?',$phone)->one();
            
            if( $user ){
                alertMsg('该手机号码已被注册');
            }
            
            $UploadFile[0] = new UploadFile('shop_logo');
            $UploadFile[1] = new UploadFile('user_id_img');
            $UploadFile[2] = new UploadFile('shop_id_img');
            
            if( !$UploadFile[0]->validateFile() ){
                alertMsg($UploadFile[0]->msg);
            }
            if( !$UploadFile[1]->validateFile() ){
                alertMsg($UploadFile[1]->msg);
            }
            if( !$UploadFile[2]->validateFile() ){
                alertMsg($UploadFile[2]->msg);
            }
            
            
            $db = DB::init();
            $db->beginTransaction();
            
            $Record = new Record();
            $ui_no = rand(111111111,999999999);
           
            $Record->ui_no = $ui_no;
            $Record->ui_name = $ui_no;
            $Record->ui_pass = md5_encrypt($reg_upass);
            $Record->ui_phone = $phone;
            $Record->ui_sex = 0;
            $Record->ui_type = 2;
            $Record->ui_power = 1;
            
            $status = $db->insert('user_info',$Record); 
            
            if( !$status ){
                alertMsg('网络错误！');
            }
            
            $Record = new Record();
            $si_no = rand(1111,9999) . rand(11111,99999);
            
            $shop_logo = $UploadFile[0]->uploadALIOSS();
            $user_id_img = $UploadFile[1]->uploadALIOSS();
            $shop_id_img = $UploadFile[2]->uploadALIOSS();
            
            $Record->si_no = $si_no;
            $Record->si_uno = $ui_no;
            $Record->si_one_level = $pno;
            $Record->si_two_level = $classno;
            $Record->si_pro = $prov;
            $Record->si_city = $city;
            $Record->si_area = $area;
            $Record->si_name = $shop_name;
            $Record->si_address = $addr;
            $Record->si_contact = $contact;
            $Record->si_phone = $contact_phone;
            $Record->si_logo = $shop_logo[0];
            $Record->si_id_image = $user_id_img[0];
            $Record->si_license_image = $shop_id_img[0];
            $Record->si_status = 1;
            $Record->si_total_score = 0;
            $Record->si_ctime = time();
            $Record->si_other = '{}';
            $Record->si_collect = 0;
            
            $status = $db->insert('shoper_info',$Record);
            if( $status ){
                $db->commit();
                $Record = new Record();
                $Record->umi_title = '提交商铺申请';
                $Record->umi_body = '~亲，你已提交商铺的申请，请耐心等待审核！';
                $Record->umi_ctime = time();
                $Record->umi_status = 1;
                $Record->umi_uno = $si_no;
                $db->insert('user_message_info',$Record);
                
                alertMsg('添加商铺成功；请等待审核；请先登录！','/login?url=/shanghu/index/info');
                exit;
            }else{
                $db->rollback();
                alertMsg('网络错误！');
            }
            
        }else{
            $categorys = ClassInfo::getCacheMenus();
            $this->assign('categorys',$categorys);
            $this->display('site/regshop.tpl');  
        }
        
    }
}