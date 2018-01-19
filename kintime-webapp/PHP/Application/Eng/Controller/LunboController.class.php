<?php
namespace Eng\Controller;
use Think\Controller;
class LunboController extends Controller {  //所有轮播图
    public function index(){ 
        $s = D('eng_lunbo');

        $arr=json_decode(file_get_contents('php://input'));
       $type=$arr->type;
       
        
        //$type=1;
      

      $row=$s->query("select * from eng_lunbo where type={$type}") ; 
       

       //dump($row);

      echo json_encode($row);


      }

}     

  







     

