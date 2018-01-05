<?php
namespace Home\Controller;
use Think\Controller;
class KeywordsController extends Controller {  //搜索-关键字
    public function index(){ 
        $m = D('m_shop');
        $s = D('shop');
        $g = D('g_shop');
        $h = D('history');
        
        $arr=json_decode(file_get_contents('php://input'));
        $address=$arr->address; //地址
        $keyword=$arr->keyword; //关键字
        $num=$arr->num;        //点击加载数量
      // cookie('id',37219238);
        /*$address="北京"; //测试数据
        $keyword='小赵信';//测试数据
        $num=0;*/
        $id=usersId();
        //$id=1;

       if(isset($address)){
           if(isset($keyword)){       //如果存在地址并且存在关键词
               $row=$s->query("(select s.id,s.stypeid,s.headpic,s.name,s.sming,s.price,s.ping,s.xl from shop as s,food as f where (f.cainame like '%{$keyword}%' or s.name like '%{$keyword}%') and s.id=f.sid and s.address like '%{$address}%' and s.state=1 and  f.state=1 limit {$num},6) union (select id,stypeid,headpic,name,sming,ping,gogo,xl from m_shop where name LIKE '%{$keyword}%' and address LIKE '%{$address}%' and state=1 limit {$num},6) union (select id,stypeid,headpic,name,sming,price,ping,xl from g_shop where name LIKE '%{$keyword}%' and address LIKE '%{$address}%' and state=1 limit {$num},6 )"); 

                $roww=$h->where("cook_id=$id")->select();
                foreach($roww as $k=>$v){
                  $nr[]=$v['nr'];
                }
                //dump($nr);
                //echo $keyword;
               $data['cook_id'] = usersId();
               $data['nr']=$keyword;
              
                         if(isset($data['cook_id'])){ //如果存在cookid就把关键字插入到历史记录中
                                  if(!in_array($keyword,$nr)){
                                  $h->add($data);
                                    // echo 666;
                                }
                         }
              }

            }
          echo json_encode($row);
            // dump($row);

        }
       
     
          
      
    }
     

       

     

/*$roww=$s->query("select distinct s.name,s.* from shop as s,food as f where (f.cainame like '%{$keyword}%' or s.name like '%{$keyword}%') and s.address like '%{$address}%' and s.id=f.sid and s.state=1 and f.state=1 limit 0,6 ");*/