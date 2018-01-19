<?php
namespace Pipi\Controller;
use Think\Controller;
class MoneyController extends Controller {
	// 账户余额充值
    public function qian_add(){
        $arr=json_decode(file_get_contents('php://input'));
        $money_user = $arr->money_user;

        $name = $_cookie['id'];
        $q_money = D('pipi_yer');
        $q_money1 = D('yer');
    	$q_money2 = D('eng_yer');
        $q_users = D('pipi_users');
        $rrow = $q_users->where("name = {$name}")->find();
		$row = $q_money->order('time desc')->where('uid='.$rrow['id'])->find();
		$data['uid'] = $row['uid'];
		$data['yuan'] = $row['new'];
		$data['new'] = $row['new']+$money_user;
		$data['time'] = time();
		$data['sming'] = 1;
        $chong = $q_money->add($data);
        $chong1 = $q_money->add($data);
		$chong2 = $q_money->add($data);
		if($chong && $chong1 && $chong2){
			echo 1;
		}else{
			echo 2;
		}
    }
    //查询账户余额
    public function qian_yu(){
        // $name = $_cookie['id'];
        $id = usersId();
    	$q_money = D('pipi_yer');
        // $q_users = D('pipi_users');
        // $rrow = $q_users->where("name = {$name}")->find();
    	$row = $q_money->order('time desc')->where('uid='.$id)->find();
    	if($row){
    		$lal['jguo'] = 1;
    		$lal['qian'] = $row['new'];
    	}else{
    		$lal['jguo'] = 2;
    	}
    	echo json_encode($lal);
        // dump($lal);
    }

    // 账户提现次数
    public function qian_ti(){
        $id = usersId();
        $q_yer = D('pipi_yer');
        // $new = time();
        $new = date("Y-m-d",time());
        $jin= strtotime($new);
        $ming= strtotime($new)+(3600*24);

        $row = $q_yer->where("sming=2 and time>{$jin} and time<{$ming} and uid={$id}")->find();
        if($row)echo 1;
        else echo 2;

    }

    // 账户交易记录
    public function qian_ji(){
        $id = usersId();
        $q_yer = D('pipi_yer');
        $row = $q_yer->order("time desc")->where("sming!=3 and uid={$id}")->select();
        if($row){
            foreach ($row as $key => $value) {
                $row[$key]['time'] = date("Y-m-d H:i:s",$value['time']);
                unset($row[$key]['id']);
                unset($row[$key]['uid']);
            }
            // dump($row);
            echo json_encode($row);
        }else echo 2;
    }

}
