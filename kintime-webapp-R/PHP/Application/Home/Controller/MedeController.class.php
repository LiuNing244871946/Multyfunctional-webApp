<?php
namespace Home\Controller;
use Think\Controller;
class MedeController extends Controller {

    //  骑手状态
    public function qiqi(){

        $qid = 1;
        $state = 1;

        $q_tang = D('tang');
        $row = $q_tang->order("time desc")->where("qid = {$qid} and state = {$state}")->select();
        dump($row);
        // echo json_encode($row);
    }

    //  骑手确认接单
    public function ren(){
        $id = 1;
        $q_tang = D('tang');
        $s_ddan = D('s_ddan');
        $error = false;
        $row = $q_tang->where("id={$id}")->find();
        // dump($row);
        if($row['state']==1){
            $tan['id'] = $id;
            $tan['state'] = 2;
            $rowb = $q_tang->save($tan);
            $data['id'] = $row['did'];
            $data['ztai'] = 2;
            // dump($data);
            $rowa = $s_ddan->save($data);
            if($rowb && $rowa) $error = true;
        }
        if($error) echo 1;
        else echo 2;
    }


    //  骑手在商家取餐
    public function qu(){
        $id = 1;
        $q_tang = D('tang');
        $s_ddan = D('s_ddan');
        $error = false;
        $row = $q_tang->where("id={$id}")->find();
        // dump($row);
        if($row['state']==2){
            $tan['id'] = $id;
            $tan['state'] = 3;
            $rowb = $q_tang->save($tan);
            $data['id'] = $row['did'];
            $data['ztai'] = 3;
            // dump($data);
            $rowa = $s_ddan->save($data);
            if($rowb && $rowa) $error = true;
        }
        if($error) echo 1;
        else echo 2;
    }

    //  骑手送达
    public function dao(){
        $id = 1;
        $q_tang = D('tang');
        $s_ddan = D('s_ddan');
        $q_ddan = D('ddan');
        $qs_user = D('qs_user');
        $error = false;
        $row = $q_tang->where("id={$id}")->find();
        $s_row = $s_ddan->where("id={$row['did']}")->find();
        $qs_row = $qs_user->where("id={$row['qid']}")->find();
        // dump($qs_row);
        if($row['state']==3 && $s_row['ztai']==2){
            // 骑手订单状态改为骑手已送达
            $tan['id'] = $id;
            $tan['state'] = 4;
            $rowb = $q_tang->save($tan);
            //用户订单状态改为起手已送达
            $data['id'] = $s_row['did'];
            $data['ztai'] = 6;
            //dump($data);
            $rowa = $q_ddan->save($data);
            //增加骑手销量
            $q_data['id'] = $qs_row['id'];
            $q_data['num'] = $qs_row['num']+1;
            $rowc = $qs_user->save($q_data);

            if($rowb && $rowa && $rowc) $error = true;
        }
        if($error) echo 1;
        else echo 2;
    }





    
}
