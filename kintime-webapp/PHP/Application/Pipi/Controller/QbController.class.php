<?php
namespace Pipi\Controller;
use Think\Controller;
class  QbController extends Controller { //美食页面下"全部"下拉列表
    public function index(){
      $s=D('pipi_shop');
      $z =D('pipi_stype');
        $arr=json_decode(file_get_contents('php://input'));
        $qb=$arr->qb;
      if(isset($qb)){
         $row=$s->query("select stypeid,count(*) num from pipi_shop group by stypeid");//全部下拉列表中的分类
            foreach($row as $k=>$v){
                $roww =$z->where('id='.$v['stypeid'])->select()[0];
                $row[$k]['stypeid'] = $roww['name'];
                
            }
           
        
         //$row['roww'] = $roww;
        echo json_encode($row);
       
    }

 }   
