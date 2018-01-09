<?php
namespace Home\Controller;
use Think\Controller;
class AddtcController extends Controller {   //添加套餐
  public function index(){ 
        $m = D('tc');
        $s = D('tc_x');
         

        
        $arr=json_decode(file_get_contents('php://input'));
       /* $data["tcname"]=$arr->tcname;          //套餐名
        $data["headpic"]=$arr->headpic;       //套餐头像                    
        $data["stock"]=$arr->stock ;           //套餐库存
        $data["oldprice"]=$arr->array_sum($sum);       // 传过来一个价钱的数组,   $a=array(5,15,25);echo array_sum($a);
        $data["tcprice"]=$arr->tcprice;       //套餐价
        $data["sid"]    =$arr->id            //这个是店铺id

        $datb["cainame"]=$arr->cainame     //存菜的名字的数组
        $datb["caipic"]=$arr->caipic     //存菜的图片的数组
        $datb["cainum"]=$arr->cainum     //存菜的数量的数组
        $datb["caiprice"]=$arr->cainum     //存菜的价格的数组*/

        //下面是测试数据
        $sum=array(10,20,30);
        //$data[""]
         $data["tcname"] = "超级无敌小礼包"; //套餐名
         $data["headpic"] = "kintime/Uploads/tc.jpg"; //图片
         $data["stock"]   =20; //库存
         $data["oldprice"]=array_sum($sum);   //原价
         $data["tcprice"]=50;              //套餐价
         $data["sid"]=2;

         $a=array('cainame'=>'黄瓜','caipic'=>'kintime/Uploads/5a27ca04a6568.jpg','cainum'=>2,'caiprice'=>77);
         $b=array('cainame'=>'茄子','caipic'=>'kintime/Uploads/u=3685916847,4037079366&fm=58.png','cainum'=>3,'caiprice'=>88);
         $c=array('cainame'=>'萝卜','caipic'=>'kintime/Uploads/5a27ca04a6568.jpg','cainum'=>4,'caiprice'=>99);

         $arr=array($a,$b,$c);
        
        $upload = new \Think\Upload();// 实例化上传类    
        $upload->maxSize   =     3145728 ;// 设置附件上传大小    
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型    
        $upload->savePath  =      './'; // 设置附件上传目录  
        $upload->autoSub = false;  
        //上传文件 
        $info   =   $upload->upload();
        foreach($info as $file){   
            $data["headpic"]=  "kintime/Uploads/".$file['savename'];
        }
        
      
       $row= $m->add($data); //插入套餐
       //echo $row;  //这个可以返回id
       //dump($arr);
       foreach($arr as $k=>$v){
          $v['tcid'] = $row;
        $roww= $s->add($v);   //插入套餐详情
       }
       
     
       $arr[1]=$row;
       $arr[2]=$roww;
       //dump($arr);
        echo json_encode($arr);
       
      // echo "<script>alert('添加成功!');</script>";
    
       
    }
     
}
