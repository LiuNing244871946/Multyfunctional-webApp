<?php
namespace Home\Controller;
use Think\Controller;
class WmshopController extends Controller { //外卖页面下店铺的一个店铺里面
    public function index(){
          
       
      $m= D('m_shop');
      $f = D('food');
      $t = D('ftype');
      $h = D('hd');
        $arr=json_decode(file_get_contents('php://input'));
        $id=$arr->id;          //此店铺id

       $id=1;  //测试数据
  if(isset($id)){
        $hd='';
        $hdrow=$h->where("sid=$id")->select();
        foreach ($hdrow as $k => $v) {
        $hd .=("满".$v['tj']."减".$v['djin'].","); //此店下的满减活动
        
      }
     //$=explode(",",$hd); //如果用数组就解开它赋值
        $row=$m->query("select name,headpic from m_shop where id={$id}"); //此店名字及头像
        $roww=$f->query("select id,cainame,m_xl,price,headpic from food where sid={$id}"); //此店下所有菜
        $rowww=$t->query("select id,name from ftype where sid={$id}"); //此店里面的左侧菜分类
       
  }
 
  dump($hd);
        //$arr['1']=$hd;
        $arr['2']=$row;
        $arr['3']=$roww;
        $arr['4']=$rowww;
         $result = array_reduce($arr, 'array_merge', array());//转换为2维数组
       /* $result = array_reduce($arr, function ($result, $value) {
          return array_merge($result, array_values($value));
          }, array());*/
        dump($result);
        
       
    }

 }   
