<?php
class ShopController extends Controller{
    
    public function modifyAction(){
        
        $Shop = new Shop();
        
        $uno = getUno();
        
        if( !empty($_FILES) ){
            $UploadFile = new UploadFile('logo');
            $urls = $UploadFile->uploadALIOSS();
            if( $urls ){
                
                $Shop->modifyShop($uno,$urls[0]);
                header('location:/shanghu/shop/modify');
                exit;
            }else{
                $this->assign('msg',$UploadFile->msg);
            }
        }
        
        $shopInfo = $Shop->getShop($uno);
        
        $this->assign('shopInfo',$shopInfo);
        
        $this->display('shanghu/shop_modify.tpl');
        
    }
    
}