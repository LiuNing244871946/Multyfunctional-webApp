<?php
namespace Home\Controller;
use Think\Controller;
class LunboController extends Controller {  //所有轮播图
    public function index(){ 
        $s = D('lunbo');

        $arr=json_decode(file_get_contents('php://input'));
       $type=$arr->type;
       
        
        //$type=1;
      

      $row=$s->query("select * from lunbo where type={$type}") ; 
       

       //dump($row);

      echo json_encode($row);


      }

}     

  







     

