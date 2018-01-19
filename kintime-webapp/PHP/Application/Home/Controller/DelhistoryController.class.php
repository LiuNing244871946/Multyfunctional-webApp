<?php
namespace Home\Controller;
use Think\Controller;
class DelhistoryController extends Controller {  //点击删除历史记录
    public function index(){ 
        $h = D('history');
        $h1 = D('history');
        $h2 = D('history');
        
        $arr=json_decode(file_get_contents('php://input'));
        
        $id=usersId();//cook下的id
       
             $rrow =$h->where("cook_id=$id")->select();
             if($rrow){
                // 点击"删除记录",就删除此id下所有历史记录
                $row=$h->where("cook_id=$id")->delete();
                $row1=$h1->where("cook_id=$id")->delete();
                $row2=$h2->where("cook_id=$id")->delete();
                if($row&&$$row1&&$row2) echo 1;
                else echo 2;
             }else echo 1;
               
                  

               // }
            
        
       
    
     // dump($row);
      
          // echo json_encode($row);
      
    }
     

       
}
     
