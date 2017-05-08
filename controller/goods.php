<?php
class GoodsController extends Controller{
    public function indexAction(){
        $gno = $_GET['gno'];
        
        $Query = Query::init();
        $Query->from('goods_info')->leftJoin('shoper_info','gi_sno=si_no');
        $Query->select('goods_info.*,shoper_info.si_name,shoper_info.si_no,shoper_info.si_logo');
        $Query->andWhere('gi_status=2 and gi_no=?',$gno);
        $goods = $Query->one();
        $goods['imglist'] = explode(',',$goods['imglist']);
        
        $Query =Query::init();
        $Query->from('goods_info');
        $Query->andWhere('gi_status=2 and gi_sno=? and gi_no!=?',[$goods['gi_sno'],$gno]);
        $Query->orderby('gi_collect desc,gi_ctime desc');
        $otherGoods = $Query->limit(5)->all();
        
        
        $Query = Query::init();
        $Query->from('goods_comments_info')->leftJoin('user_info','gci_uno=ui_no');
        $Query->select('goods_comments_info.*,user_info.ui_name');
        $Query->andWhere('gci_gno=? and gci_status=1',$gno);
        $Query->orderby('gci_ctime desc');
        $goodsComments = $Query->limit(100)->all();
        
        $this->assign('goodsComments',$goodsComments);
        $this->assign('otherGoods',$otherGoods);
        $this->assign('goods',$goods);
        $this->display('site/goods.tpl');
    }
}