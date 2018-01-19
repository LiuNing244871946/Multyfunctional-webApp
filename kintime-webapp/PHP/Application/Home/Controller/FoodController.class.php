<?php
namespace Home\Controller;
use Think\Controller;
class FoodController extends Controller { //美食下分类的所有商品
    public function all(){
        $_POST['id'] =1;
            $m = D('food');
            $s = D('shop');
            $f = D('ftype');
            $z = D('stype');
         if(isset($_POST['id'])){
            $row = $m->where("stypeid = {$_POST['id']}")->select();
           
         }
          foreach ($row as $k => $v) {
            if($v['state']== 1){
                $row[$k]['state']='上架';
            }elseif($v['state']== 2){
                $row[$k]['state']='下架';
            }
            if($v['rx']==1){
                 $row[$k]['rx']='是热销';
            }elseif($v['rx']==2){
               $row[$k]['rx']='不是热销'; 
            }
             if($v['wmstate']== 1){
                $row[$k]['wmstate']='支持外卖';
            }elseif($v['wmstate']== 2){
                $row[$k]['wmstate']='不支持外卖';
            }
            //商铺名
            $st_row = $s->where('id='.$v['sid'])->select()[0];
            $row[$k]['sid'] = $st_row['name'];
            //菜品类名
            $roww =$f->where('id='.$v['typeid'])->select()[0];
             $row[$k]['typeid'] = $roww['name'];
          //种类名
              $rowww =$z->where('id='.$v['stypeid'])->select()[0];
             $row[$k]['stypeid'] = $rowww['name'];
             $id=$v['id'];
        }
        //dump($row);
        $this->assign('row',$row);
        $this->display();
    }


}