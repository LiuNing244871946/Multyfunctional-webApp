<?php
namespace Home\Controller;
use Think\Controller;
class MsController extends Controller { //美食下的页面
    public function index(){
          
        $m = D('stype');
        $s = D('shop');
      

        $arr=json_decode(file_get_contents('php://input'));
        $address=$arr->address;  //地址
        $num=$arr->num; //加载数量
        $id=$arr->id;          //美食大类的id

      /*  $id=1;  //测试数据
        $num=0;
        $address='北京'; //测试数据*/
      if(isset($id)){
            $row = $m->where("pid = $id")->limit(0,8)->select();//查询美食下的分类(就传美食的id=1)
            $roww=$s->query("select id,stypeid,headpic,name,sming,price,ping,xl from shop where address LIKE '%{$address}%' and state=1 limit {$num},6") ; //美食下的店铺
      }
     
           
        $arr['1']=$row;
        $arr['2']=$roww;
        $result = array_reduce($arr, 'array_merge', array());//转换为2维数组
        // dump($result);
        echo json_encode($result);
        
       
    }

 }   
