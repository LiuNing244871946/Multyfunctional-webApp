<?php
namespace Eng\Controller;
use Think\Controller;
class  QbController extends Controller { //美食页面下"全部"下拉列表
    public function index(){
      $s=D('eng_shop');
      $z =D('eng_stype');
        $arr=json_decode(file_get_contents('php://input'));
        $qb=$arr->qb;
      if(isset($qb)){
         $row=$s->query("select stypeid,count(*) num from eng_shop group by stypeid");//全部下拉列表中的分类
            foreach($row as $k=>$v){
                $roww =$z->where('id='.$v['stypeid'])->select()[0];
                $row[$k]['stypeid'] = $roww['name'];
                
            }
           
        
         //$row['roww'] = $roww;
        echo json_encode($row);
       
    }

 }   
