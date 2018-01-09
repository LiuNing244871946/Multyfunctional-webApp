<?php
namespace Home\Controller;
use Think\Controller;
class AddgoodController extends Controller {   //添加商品
  public function index(){ 
        $m = D('food');
        $s = D('ggetype');
        $z = D('ftype');
        
        $arr=json_decode(file_get_contents('php://input'));
      $data["cainame"]=$arr->name;          //商品名
      $data["headpic"]=$arr->headpic;       //头像
      $data["stock"]=$arr->stock;           //库存 
      $data["price"]=$arr->price;          //价格  
      $data["typeid"]=$arr->typeid;        //商品分类
      $data["pliao"]=$arr->pliao;           //商品说明(配料)
      $data["id"]=$arr->id;           //此商铺id
        //$address='北京';
         $data["cainame"] = "小乌龟"; //测试数据
         $data["headpic"] = "kintime/Uploads/tc.jpg"; //测试数据
         $data["stock"] =20; //测试数据
         $data["price"] =100; //测试数据
         $data["typeid"] =1; //测试数据
         $data["pliao"] ='葱姜蒜'; //测试数据
         $datab["name"] ='温度度';  //规格
         $datab["name"] ='酸辣辣';  //规格--------到时候传数组进行遍历一步一步插入!!!!!

         $row_s=$z->where("id=$sid")->select();  //查询分类


        $upload = new \Think\Upload();// 实例化上传类    
        $upload->maxSize   =     3145728 ;// 设置附件上传大小    
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型    
        $upload->savePath  =     './../../static/Img/'; // 设置附件上传目录  
        $upload->autoSub = false;  
        //上传文件 
        $info   =   $upload->upload();
        foreach($info as $file){   
            $data["headpic"]= "./../../static/Img/".$file['savename'];
        }
        
      
       $row= $m->add($data); //插入菜品信息
       $roww=$s->add($datab)  //插入规格
       //echo $row;  //这个可以返回id
        $arr['1']=$row_s;
        $arr['2']=$row;
        $arr['3']=$roww;

        echo json_encode($arr);
        //echo "<script>location.href='".U('index#about')."'</script>";
       // echo "<script>alert('添加成功!');</script>";
    
       
    }
     
}
