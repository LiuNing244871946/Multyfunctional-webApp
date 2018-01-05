<?php
namespace Home\Controller;
use Think\Controller;
class WmfoodController extends Controller { //美食下分类的所有商品
    public function wmindex(){
      $_POST['id'] =1;
            $m = D('food');
            $s = D('shop');
          
            $z = D('stype');
         if(isset($_POST['id'])){
            $row = $s->where("stypeid = {$_POST['id']}")->select();

           
         }

          foreach ($row as $k => $v) {
            if($v['state']== 1){
                $row[$k]['state']='上架';
            }elseif($v['state']== 2){
                $row[$k]['state']='下架';
            }
        
             if($v['wmstate']== 1){
                $row[$k]['wmstate']='支持外卖';
            }elseif($v['wmstate']== 2){
                $row[$k]['wmstate']='不支持外卖';
            }
          
              $rowww =$z->where('id='.$v['stypeid'])->select()[0];
             $row[$k]['stypeid'] = $rowww['name'];
            
        }
        
    }

      public function wmshow(){
        $_POST['id'] =1;
            $m = D('shop');
         if(isset($_POST['id'])){
            $row = $m->where("stypeid = {$_POST['id']}")->select();

           
         }

          foreach ($row as $k => $v) {
            if($v['state']== 1){
                $row[$k]['state']='上架';
            }elseif($v['state']== 2){
                $row[$k]['state']='下架';
            }
        
             if($v['wmstate']== 1){
                $row[$k]['wmstate']='支持外卖';
            }elseif($v['wmstate']== 2){
                $row[$k]['wmstate']='不支持外卖';
            }
        }
        
      
    }


}