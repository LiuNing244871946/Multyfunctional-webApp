<?php
namespace Home\Controller;
use Think\Controller;
class  WmqbController extends Controller { //"外卖页全部"下拉列表
    public function index(){
        $arr=json_decode(file_get_contents('php://input'));
        $qb=$arr->qb;
       $qb='as';   //测试数据
      $s=D('shop');
      $z =D('stype');
      if(isset($qb)){
          $row=$s->query("select stypeid,count(*) num from shop group by stypeid");//全部下拉列表中的分类
              foreach($row as $k=>$v){
                $roww =$z->where('id='.$v['stypeid'])->select()[0];
                $row[$k]['stypeid'] = $roww['name'];
                  
              }
         }
  
        //dump($row);
         //$row['roww'] = $roww;
        echo json_encode($row);
       
    }

 }   
