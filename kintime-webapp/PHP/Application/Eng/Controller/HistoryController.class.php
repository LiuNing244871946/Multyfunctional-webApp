<?php
namespace Eng\Controller;
use Think\Controller;
class HistoryController extends Controller {  //聚焦搜索框,显示此用户历史记录
    public function index(){ 
        $h = D('eng_history');
        
        $arr=json_decode(file_get_contents('php://input'));
        $id=usersId();//cook下的id
       //$id=1;
             
              if(isset($id)){ //如果存在cookid就查询当前id下的历史记录
               
                $row=$h->query("select nr from eng_history where cook_id={$id}"); 
               }

        
       
    
     // dump($row);
      
          echo json_encode($row);
      
    }
     

       
}
     
