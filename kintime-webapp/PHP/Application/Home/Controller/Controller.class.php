<?php
namespace Home\Controller;
use Think\Controller;
class TypeController extends Controller {
    public function index(){ //查询总分类
        $map = array();
        if(isset($_POST['search'])){//搜索应该是全局搜索!!!!
            $map['name'] = array('like',"%{$_POST['search']}%");
           
        }
    	$m = D('stype');
        $s = D('shop');
        $row = $m->where('pid=0')->limit(0,8)->select(); 
        $roww=$s->where($map)->limit(0,6)->select();
        dump($row);
        dump($roww);
        echo json_encode($row);
        echo json_encode($roww);
        $this->assign('row',$row);
        $this->display();
    }
     public function stype(){ //查询二级分类
        $_POST['id'] =1;
        $m = D('stype');
        $s = D('shop');
        $z =D('stype');
         $map = array();
        if(isset($_POST['search'])){//搜索应该是全局搜索!!!!
            $map['name'] = array('like',"%{$_POST['search']}%");
           
        }
        
         if(isset($_POST['id'])){
            $row = $m->where("pid = {$_POST['id']}")->limit(0,8)->select();//查询二级分类
            $roww=$s->where($map)->limit(0,6)->select();//查询二级分类页面下所有商品
            $row_s=$s->query("select stypeid,count(*) num from shop group by stypeid");//全部下拉列表中的分类
            foreach($row_s as $k=>$v){
                $rowww =$z->where('id='.$v['stypeid'])->select()[0];
                $row_s[$k]['stypeid'] = $rowww['name'];
                
            }
            $row_h=$s->query("select * from shop order by ping desc limit 0,6");//智能排序下的好评优先
           $row_x=$s->query("select * from shop order by xiaoliang desc limit 0,6");//智能排序下的人气最高*/
            //dump($row_h);
            
            dump($row_s);
         }
        //echo json_encode($row_h);
        //echo json_encode($roww);
        echo json_encode($row_x);
         

        $this->assign('row',$row);
        $this->display();
    }
     

}