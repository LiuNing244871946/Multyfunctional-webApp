<?php
namespace Htai\Controller;
use Think\Controller;
class JuanController extends CommonController {
    public function juanzi(){
        //echo(strtotime("2017-12-31 24:00:00")-1);
        // echo(date("Y-m-d","1514736000"));
        if(!empty($_GET['search'])){
            $map['id'] = array('like',"%{$_GET['search']}%");
        }

        $juan_cc = D('cc');
        $juan_shop = D('shop');
        $juan_users = D('users');

        $count = $juan_cc->where($map)->count();
        $Page = new \Think\Page($count,I('get.pnum',10));
        $row = $juan_cc->order('id desc')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();
        foreach ($row as $k => $v) {
            if($v['sid']== 0){
                $row[$k]['sid']='所有商家';
            }else{
                $shop_row = $juan_shop->where("id=".$v['sid'])->select()[0];
                $row[$k]['sid']=$shop_row['name'];
            }

            $user_row = $juan_users->where("id=".$v['uid'])->select()[0];
            $row[$k]['uid']=$user_row['name'];
            //dump($user_row);
            switch ($v['name']) {
                case 1:
                    $row[$k]['name']='商家优惠券';
                    break;
                case 2:
                    $row[$k]['name']='内部优惠券';
                    break;
            }
            $row[$k]['stop']=date("Y-m-d H:i:s","{$v['stop']}");



        }
        $show = $Page->show();// 分页显示输出
        $this->assign('show',$show);

        $this->assign('row',$row);
        $this->display();
    }

    















}