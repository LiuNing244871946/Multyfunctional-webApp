<?php
namespace Htai\Controller;
use Think\Controller;
class DdglController extends CommonController {
    public function max_show(){
        //echo(time());
        if(!empty($_GET['search'])){
            $map['id'] = array('like',"%{$_GET['search']}%");
        }
        $q_ddan = D('ddan');
        $q_user = D('users');
        $shop = D('shop');
        $count = $q_ddan->where($map)->count();
        $Page = new \Think\Page($count,I('get.pnum',10));
        $row = $q_ddan->order('id desc')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();
        foreach ($row as $k => $v) {
            if($v['see']== 1){
                $row[$k]['see']='可见';
            }elseif($v['see']== 2){
                $row[$k]['see']='隐藏';
            }
            switch ($v['ztai']) {
                case 1:
                    $row[$k]['ztai']='待付款';
                    break;
                case 2:
                    $row[$k]['ztai']='待使用';
                    break;
                case 3:
                    $row[$k]['ztai']='待评价';
                    break;
                case 4:
                    $row[$k]['ztai']='完成订单';
                    break;
                case 4:
                    $row[$k]['ztai']='退款/售后';
                    break;
            }
            $qu_row = $q_user->where('id='.$v['uid'])->select()[0];
            $row[$k]['uid'] = $qu_row['username'];
            $shop_row = $shop->where('id='.$v['sid'])->select()[0];
            $row[$k]['sid'] = $shop_row['name'];
            $row[$k]['time'] = date("Y-m-d H:i:s",$v['time']);
        }
        $show = $Page->show();// 分页显示输出
        $this->assign('show',$show);
        $this->assign('row',$row);
        $this->display();
    }
    public function kan_show(){

        $q_ddan = D('ddan');
        $q_user = D('users');
        $shop = D('shop');
        $ddshop = D('ddshop');
        $food = D('food');
        if(IS_GET){
            $row = $q_ddan->where('id='.$_GET['id'])->select()[0];
            //dump($row);
            $qu_row = $q_user->where('id='.$row['uid'])->select()[0];
            $row['uid'] = $qu_row['username'];
            $shop_row = $shop->where('id='.$row['sid'])->select()[0];
            $row['sid'] = $shop_row['name'];
            $row['time'] = date("Y-m-d H:i:s",$row['time']);
            $dds_row = $ddshop->where('ddid='.$row['id'])->select();
            foreach ($dds_row as $k => $v) {
                $fd_row = $food->where('id='.$v['sid'])->select()[0];
                // dump($fd_row);

            }



            //dump($dds_row);


            $this->assign('row',$row);
            $this->display();
        }else{
            $q_ddan->save($_POST);
            echo "<script>location.href='".U('max_show')."'</script>";







        }


        
    }
    















}