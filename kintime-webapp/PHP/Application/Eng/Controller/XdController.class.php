<?php
namespace Eng\Controller;
use Think\Controller;
class XdController extends Controller { //下单
    public function index(){   //假设在这已经从购物车提交过来数据
          
        $m = D('ddan');
        $m1 = D('eng_ddan');
        $m2 = D('pipi_ddan');
       

        $arr=json_decode(file_get_contents('php://input'));
        $id=$arr->id;  //正常id
        $uid=$arr->uid; //该用户id
        $sid=$arr->sid;  //店铺名
        $time=$arr->time;  //订单时间
        $yuan=$arr->yuan;  //原价
        $you=$arr->you;  //优惠后价
        $ztai=$arr->ztai;  //订单状态
        $mai=$arr->mai;  //是否为外卖 1外卖2堂食
        $zhu=$arr->zhu;  //备注

       $data['id']=1; //测试数据
       $data['uid']=1; //测试数据
       $data['sid']=1; //测试数据
       $data['time']=date("Y-m-d H:i"); //测试数据
       $data['yuan']=210; //测试数据
       $data['you']=120; //测试数据
       $data['ztai']=1; //代付款
       $data['mai']=2; //堂食
       $data['zhu']="我马上到,给我留位子"; //堂食
        //$keyword='小'; //测试数据
        //$address='重庆'; //测试数据
      if($data['mai']==2)){
            $row = $m->add($data);//
            $row1 = $m1->add($data);//
            $row2 = $m2->add($data);//
      }
 
        echo json_encode($row);
       
    }

 }   
