<?php
class CartController extends Controller{
    
    public function indexAction(){
        
        $uno = getUno();
        if( $uno != null ){
            list($page,$start) = getPage(PER_PAGE_COUNT);
            $Query = Query::init()->from('user_cart_info')->leftJoin('goods_info','uci_gno=gi_no');
            $Query->andWhere('uci_uno=?',[$uno]);
            $Query->limit(PER_PAGE_COUNT)->offset($start);
            $carts = $Query->all();
            $count = $Query->count();
            $Page = new Page($count);
            $this->assign('page',$Page->fpage());
            $this->assign('carts',$carts);
            
        }else{
            $carts = $_SESSION['cart'];
            $gnos = [];
            $counts = [];
            foreach($carts as $cart){
                $gnos[] = (int)$cart['gno'];
                $counts[$cart['gno']] = $cart['count'];
            }
            $db = DB::init();
            $goods = [];
            if( !empty($gnos) ){
                $goods = Query::init()->from('goods_info')->andWhere('gi_no in(' .implode(',',$gnos). ')')->limit(100)->all();
            }
            foreach($goods as $k=>$g){
                $goods[$k]['uci_count'] = $counts[$g['gi_no']];
            }
            $this->assign('carts',$goods);
            $this->assign('page','');
        }
        $this->display('site/cart.tpl');
        
    }
    
    public function addAction(){
        
        $gno = $type = $count = "";
        extract( safe_extract($_REQUEST) );
        $uno = getUno();
        
        if( !empty($_POST) ){
            
            if( $uno ){
                
                $db = DB::init();
                
                $cart = Query::init()->from('user_cart_info')->andWhere('uci_uno=? and uci_gno=?',[$uno,$gno])->one();
                if( !empty($cart) ){
                    $db->exec('update user_cart_info set uci_count=uci_count+? where uci_no=?',[$count,$cart['uci_no']]);
                    //$cno = $cart['uci_no'];
                }else{
                    $Record = new Record();
                    $Record->uci_uno = $uno;
                    $Record->uci_ctime = time();
                    $Record->uci_count = $count;
                    $Record->uci_gno = $gno;
                    $db->insert('user_cart_info',$Record);
                    //$cno = $db->connobj->lastInsertId();
                }
                
            }else{
                
                $status = 0;
                if( !empty($_SESSION['cart']) ){
                    foreach( $_SESSION['cart'] as $key=>$cart ){
                        if( $cart['gno'] == $gno ){
                            $_SESSION['cart'][$key]['count'] +=$count;
                            $status = 1;
                        }
                    }
                }
                if( $status == 0 ){
                    $_SESSION['cart'][] = [
                        'gno'=>$gno,
                        'count'=>$count
                    ];
                }
                
            }
            
            returnMsg(200,'加入购物车成功！');
        
        }else{
            
            $this->display('site/cart_add.tpl');
            
        }
        
    }
    
    public function delAction(){
        $cno = $gno = 0;
        extract( safe_extract($_POST) );
        $uno = getUno();
        if( $uno ){
            $db = DB::init();
            $db->exec('delete from user_cart_info where uci_no=? and uci_uno=?',[$cno,$uno]);
            returnMsg(200,' 删除成功！');
        }else{
            foreach( $_SESSION['cart'] as $k=>$cart ){
                if( $cart['gno'] == $gno ){
                    unset($_SESSION['cart'][$k]);
                }
            }
            returnMsg(200,' 删除成功！');
        }
    }
    
    public function modicountAction(){
        $count = $cno = $gno = $type = 0;
        extract( safe_extract($_POST) );
        
        $uno = getUno();
        
        $goods = Query::init()->from('goods_info')->andWhere('gi_no=?',$gno)->one();
        
        if( !empty($uno) ){
            $db = DB::init();
            $db->exec('update user_cart_info set uci_count=? where uci_no=? and uci_uno=?',[$count,$cno,$uno]);
        }else{
            foreach( $_SESSION['cart'] as $k=>$cart ){
                if( $cart['gno'] == $gno ){
                    $_SESSION['cart'][$k]['count'] = $count;
                }
            }
        }
        
        
        
        if( $goods['gi_count']<$count ){
            returnMsg(104,'增加数量失败！当前商品剩余数量为' . $goods['gi_count'] ,['count'=>$goods['gi_count']] );
        }else{
            returnMsg(200,' 修改数量成功！');
        }
        
    }
    
}