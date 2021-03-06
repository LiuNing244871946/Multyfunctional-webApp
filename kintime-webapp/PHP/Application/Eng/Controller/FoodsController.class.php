<?php
namespace Eng\Controller;
use Think\Controller;
use Aliyun\Core\Config; 
use Aliyun\Core\Profile\DefaultProfile; 
use Aliyun\Core\DefaultAcsClient; 
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;
class FoodsController extends CommonController {
	// 店铺首页
    public function index(){
        $id = $_COOKIE['4373433CA7C70528'];
        $q_dian = D('eng_shop');
        $q_tc = D('eng_tc');
        $q_shop = D('eng_m_shop');
      	$q_shoppic = D('eng_shoppic');

      	$dian_row = $q_dian->field('id,uid,address,headpic,jingdu,weidu,name,p_num,phone,hao,ping,price,xiaddress')->where('id='.$id)->find();
        $dian_row['wmstate'] = 0;  //默认0
        $rrow = $q_shop->where('uid='.$dian_row['uid'])->find();
        if($rrow){
            $time = date("Hi",time());
            if($rrow['hi_b']<$time && $rrow['hi_o']>$time) $dian_row['wmstate']=1;
            else $dian_row['wmstate']=2;
        }
      	$dian_row['pic'] = $dian_pic = $q_shoppic->where('sid='.$id)->count();
      	//dump($dian_pic);
      	//套餐信息
        $food_row = $q_tc->field('id,headpic,jiejia,momo,oldprice,ping,tcname,tcprice,xl,yue')->where("sid={$id} and tftype=0")->select();
      	/*$food_row = $q_food->where("sid = {$dian_row['id']} AND typeid = 9 AND state = 1")->select();*/
        $dian_row['food']=$food_row;
      	// dump($food_row); // 二维数组

        //好评率
        $lv = $dian_row['hao']/$dian_row['p_num']*100;
        $lv = floor($lv);
        $lv.="%";
    		
        $dian_row['lv'] = $lv;

        $q_row = $q_dian->order("ping asc")->where("p_num != 0")->select();
        $count = count($q_row);
        // echo $count;

        // dump($q_row);
        foreach ($q_row as $k => $v) {
          if($v['id'] == $id ) $ci = $k;
        }
        $ci ++;
        $jib = $ci/$count*100;
        $jib = floor($jib);
        $jib.="%";
        $dian_row['jib'] = $jib;

        unset($dian_row['uid']);
        // dump($dian_row);  // 店铺的总信息
        echo json_encode($dian_row);
    }

    // 堂食店铺图片
    public function tpic(){
        $id = $_COOKIE['4373433CA7C70528'];
        // $id= 1;
        $q_shoppic = D('eng_shoppic');
        $row = $q_shoppic->field('picname')->where('sid='.$id)->select();
        echo json_encode($row);

    }
    // 套餐的详情
    public function tcan(){
        // $tcan = $_POST['tcan'] = 1;
        $arr=json_decode(file_get_contents('php://input'));
        $tcan = $arr->tcan;
        // $tcan = 1;
        $q_model = D();
        $q_tc = D('eng_tc');
        $q_tcx = D('eng_tc_x');
        $q_gze = D('eng_gze');
        // $row = $q_tc->where("id={$tcan}")->find();/
        $row = $q_model->query("select t.*,s.name from eng_tc t,eng_shop s where s.id=t.sid and t.id={$tcan} and tftype=0")[0];
        $sid = $row['sid'];
        $aid = $row['id'];
        $rrow = $q_tc->field('id,tcname')->where("sid = {$sid} and id!=$aid")->select();
        // dump($rrow);
        $row['other'] = $rrow;
        $c_row = $q_tcx->where("tcid={$tcan}")->select();
        unset($c_row['tcid']);
        // dump($c_row);
        $row['cai'] = $c_row;
        $g_row = $q_gze->field('gz')->where("fid={$tcan}")->select();
        $row['gze'] = $g_row;

        $row['ymd_k'] = substr($row['ymd_k'],0,4).'/'.substr($row['ymd_k'],4,2).'/'.substr($row['ymd_k'],6,2);
        $row['ymd_t'] = substr($row['ymd_t'],0,4).'/'.substr($row['ymd_t'],4,2).'/'.substr($row['ymd_t'],6,2);
        $row['his_k'] = substr($row['his_k'],0,2).':'.substr($row['his_k'],2,2);
        $row['his_t'] = substr($row['his_t'],0,2).':'.substr($row['his_t'],2,2);

        // dump($row);
        echo json_encode($row);
    }

    // 外卖店铺详情
    public function mai(){
      $id = $_COOKIE['C057DF743DCFDA2C'];

      $m_shop = D('eng_m_shop');
    	$q_food = D('eng_food');
    	$q_hd = D('eng_hd');
      $q_ftype = D('eng_ftype');
    	$mai_row = $m_shop->field('stypeid,ping,hao,p_num,name,phone,address,xiaddress,headpic,pic,hi_b,hi_o,sming,song,gogo')->where('id='.$id)->find();
    	//dump($mai_row);
    	$hd_row = $q_hd->order("tj asc")->where('sid='.$id)->select();
    	// dump($hd_row);
    	$aa = '';
    	foreach ($hd_row as $k => $v) {
    		$aa .=("满".$v['tj']."减".$v['djin'].",");
    	}
    	//echo count($hd_row);
    	// echo trim($aa,",");  // 满减活动
      $mai_row['jian'] = trim($aa,",");
    	$ftype_row = $q_ftype->field('id,name')->where("sid = {$id}")->select();
      foreach ($ftype_row as $key => $value) {
        $typeid = $value['id'];
        $ftype_row[$key]['food'] = $q_food->field('id,cainame,guige,zhekou,pliao,headpic,m_xl,time')->where("typeid={$typeid}")->select();
        foreach ($ftype_row[$key]['food'] as $kk => $vv) {
          $xin = time() - $vv['time'];
          if($xin<604800) $ftype_row[$key]['food'][$kk]['type'] =1;
          else $ftype_row[$key]['food'][$kk]['type'] =2;
          unset($ftype_row[$key]['food'][$kk]['time']);
        }
      }



      $mai_row['lei'] = $ftype_row;
      $mai_row['hi_b'] = substr($mai_row['hi_b'],0,2).':'.substr($mai_row['hi_b'],2,2);
      $mai_row['hi_o'] = substr($mai_row['hi_o'],0,2).':'.substr($mai_row['hi_o'],2,2);
      // dump($mai_row);

      // 外卖商家的评论的评分
        //好评率
        $lv = $mai_row['hao']/$mai_row['p_num']*100;
        $lv = floor($lv);
        $lv .= "%";
        $mai_row['lv'] = $lv;

        $q_row = $m_shop->order("ping asc")->where("p_num != 0")->select();
        $count = count($q_row);

        foreach ($q_row as $k => $v) {
            if($v['id'] == $id ) $ci = $k;
        }
        $ci++;
        $jib = $ci/$count*100;
        $jib = floor($jib); 
        $jib.="%";
        $mai_row['jib'] = $jib;

        unset($mai_row['hao']);
        unset($mai_row['p_num']);
        // dump($mai_row);
        echo json_encode($mai_row);
    }

    // 规格
    public function mai_gg(){
      $arr=json_decode(file_get_contents('php://input'));
      $id = $arr->id; //菜id

      // $id = 1;
      $q_ggetype = D('eng_ggetype');
      $row= $q_ggetype->field('name,id')->where("pid=0 AND fid={$id}")->select();
      foreach ($row as $key => $value) {
        $rid = $value['id'];
        $row[$key]['lei'] = $q_ggetype->field('name,id,price')->where("pid={$rid}")->select();
        // unset($row[$key]['id']);
      }
      // dump($row);
      echo json_encode($row);
    }


    //外卖店铺详细信息
    public function xxi(){
      $id = $_COOKIE['C057DF743DCFDA2C'];
      $m_shoppic = D('eng_m_shoppic');
      $m_wspic = D('eng_wspic');
      echo time();


    }

    


    // 外卖商家的评论内容
    public function mai_ping(){
        $arr=json_decode(file_get_contents('php://input'));
        $num = $arr->num;
        $type = $arr->type;
        $id = $_COOKIE['C057DF743DCFDA2C'];
/*$id=1;
$num=0;
$type=1;*/
        $q_model = D();
        $q_pjpic = D('eng_pjpic');
        if($type==1) $xin = "ORDER BY p.dj desc";
        if($type==2) $xin = "ORDER BY p.ptime desc";
        if($type==3) $tu = "AND p.pics = 2 ORDER BY p.ptime desc";
        if($type==4) $xin = "ORDER BY p.dj asc";
        $pl = $q_model->query("select p.id,p.dj,p.pics,p.ptime,p.nrong,u.headpic,u.username from eng_pj p,eng_users u,eng_ddan d where p.did = d.id and d.sid = {$id} and p.uid = u.id and d.ztai = 4 AND p.type=1 {$tu} {$xin} limit {$num},6");
        
        foreach ($pl as $k => $v) {
          $pl[$k]['ptime'] = date("Y-m-d H:i",$v['ptime']);
          //dump($name_row);
            if($v['pics']==2){ //有图片
              $q_pics = $q_pjpic->where("pjid=".$v['id'])->select();
              $pl[$k]['pic']=$q_pics;
            }
            unset($pl[$k]['id']);
            unset($pl[$k]['pics']);
        }
        // dump($pl);
        echo json_encode($pl);
    }

    //堂食店铺评价
    public function tang_ping(){
        $arr=json_decode(file_get_contents('php://input'));
        $num = $arr->num;
        $type = $arr->type;
        $id = $_COOKIE['4373433CA7C70528'];

/*$num = 0;
$type = 1;
$id=3;*/
        $q_model = D();
        $q_pjpic = D('eng_pjpic');
        $xin='';
        $tu ='';
        if($type==1) $xin = "ORDER BY p.dj desc";
        elseif($type==2) $xin = "ORDER BY p.ptime desc";
        elseif($type==3) $tu = "AND p.pics = 2 ORDER BY p.ptime desc";
        elseif($type==4) $xin = "ORDER BY p.dj asc";
        $pl = $q_model->query("(select p.id,p.dj,p.pics,p.ptime,p.nrong,u.headpic,u.username from eng_pj p,eng_users u,eng_dz_ddan d where p.did = d.id and d.sid = {$id} and p.uid = u.id and d.ztai = 2 AND p.type = 3 {$tu} {$xin} limit {$num},6) union (select p.id,p.dj,p.pics,p.ptime,p.nrong,u.headpic,u.username from eng_pj peng_,users u,eng_t_ddan d where p.did = d.id and d.sid = {$id} and p.uid = u.id and d.ztai = 2 AND p.type = 2 {$tu} {$xin} limit {$num},6)");
        
        foreach ($pl as $k => $v) {
          $pl[$k]['ptime'] = date("Y-m-d H:i",$v['ptime']);
          //dump($name_row);
            if($v['pics']==2){ //有图片
              $q_pics = $q_pjpic->field('picname')->where("pjid=".$v['id'])->select();
              $pl[$k]['pic']=$q_pics;
            }
            unset($pl[$k]['id']);
            unset($pl[$k]['pics']);
        }
        // dump($pl);
        echo json_encode($pl);
    }





    // 登录
    public function dengl(){
      $arr=json_decode(file_get_contents('php://input'));
      $name = $arr->account;
      $pass = $arr->pass;

    	$pass = md5($pass);
      $q_users = D('eng_users');
       $row = $q_users->where("name = '{$name}' or phone = '{$name}' ")->find();
          
       if(!empty($row)){
          if($row['state'] == 1){
              if($row['pass'] == $pass){
                  $name = $row['name'];
                  cookie('id',$name);
                  echo 1;
              }else echo 2 ;
          }else echo 3;
       }else  echo 4;
    }

    // 外卖菜详情
    public function details(){
        $arr=json_decode(file_get_contents('php://input'));
        $id = $arr->cai;
        $uid = usersId();
        $sid = $_COOKIE['C057DF743DCFDA2C'];

        /*$id = 1;
        $uid = 27;
        $sid = 1;*/
        $q_food = D('eng_food');
        $model = D('eng_');
        $row = $q_food->field('cainame,headpic,m_xl,zhekou,guige,pliao,m_ping')->where("id={$id}")->find();

        $roww = $model->query("select s.num,s.fid from eng_shopcar c,eng_sgoods s where c.uid={$uid} AND c.sid={$sid} AND c.id=s.carid");
        $row['num'] = 0;
        $row['count'] = 0;
        foreach ($roww as $key => $value) {
          $row['count']+=$value['num'];
          if($value['fid'] == $id) $row['num'] += $value['num'];
        }
        // dump($row);
        echo json_encode($row);
    }

    // 电子菜单菜详情
    public function dz_details(){
        $arr=json_decode(file_get_contents('php://input'));
        $id = $arr->cai;
        $uid = usersId();
        $sid = $_COOKIE['C057DF743DCFDA2C'];

        /*$id = 1;
        $uid = 27;
        $sid = 1;*/
        $q_food = D('eng_dzcd');
        $model = D('eng_');
        $row = $q_food->field('cainame,headpic,m_xl,zhekou,guige,pliao,m_ping')->where("id={$id}")->find();

        $roww = $model->query("select s.num,s.fid from eng_dz_shopcar c,eng_dz_sgoods s where c.uid={$uid} AND c.sid={$sid} AND c.id=s.carid");
        $row['num'] = 0;
        $row['count'] = 0;
        foreach ($roww as $key => $value) {
          $row['count']+=$value['num'];
          if($value['fid'] == $id) $row['num'] += $value['num'];
        }
        // dump($row);
        echo json_encode($row);
    }
      // 个人中心收货地址
    public function address(){
        $q_shdz = D('eng_shdz');
        $users = D('eng_users');
        $name = $_COOKIE['id'];
        $row = $users->field('id,dzid')->where("name = {$name}")->find();
        $shdz_row = $q_shdz->where("uid=".$row['id'])->select();
        $shdz_row['dzid'] = $row['dzid'];

        echo json_encode($shdz_row);
    }

      // 外卖购物车收货地址
    public function m_address(){
        $q_shdz = D('eng_shdz');
        $shopcar = D('eng_shopcar');
        $id=usersId(); 
        $uid = $_COOKIE['C057DF743DCFDA2C'];

        $row = $shopcar->field('id,dzid')->where("uid={$id} AND sid={$uid}")->find();
        $shdz_row = $q_shdz->where("uid=".$id)->select();
        $shdz_row['dzid'] = $row['dzid'];
        // dump($shdz_row);
        echo json_encode($shdz_row);
    }

     // 添加银行卡
    public function add_card(){
        //???

    }

     // 查看一个地址详细
    public function add_kan(){
        $arr=json_decode(file_get_contents('php://input'));
        $id = $arr->id;
        $q_address = D('eng_shdz');
        $row = $q_address->where("id={$id}")->find();
        echo json_encode($row);
    }

    //修改地址
    public function add_change(){
        
        $arr=json_decode(file_get_contents('php://input'));
        $id = $arr->id;
        $linkman = $arr->name;
        $sex = $arr->sex;
        $phone = $arr->phone;
        $address = $arr->address;
        $jing = $arr->jing;
        $wei = $arr->wei;
        $xiaddress = $arr->xiaddress;

        $phone = ltrim($phone,"中国+");
        $phone = ltrim($phone,"老挝+");
        $q_address = D('eng_shdz');
        $q_address1 = D('shdz');
        $q_address2 = D('pipi_shdz');
        $data['linkman'] = $linkman;
        $data['sex'] = $sex;
        $data['phone'] = $phone;
        $data['address'] = $address;
        $data['xiaddress'] = $xiaddress;
        $data['jing'] = $jing;
        $data['wei'] = $wei;
        if($id==0){ //添加
            $uid = usersId();
            $data['uid'] = $uid;
            $row = $q_address->add($data);
            $row1 = $q_address1->add($data);
            $row2 = $q_address2->add($data);
        }else{      //修改
          $rrow = $q_address->where("id={$id}")->find();
          if($rrow['linkman']==$linkman && $rrow['sex']==$sex && $rrow['phone']==$phone && $rrow['address && ']==$address && $rrow['jing']==$jing && $rrow['wei']==$wei && $rrow['xiaddress']==$xiaddress) die('1');
            $data['id'] = $id;
            $row = $q_address->save($data);
            $row1 = $q_address1->save($data);
            $row2 = $q_address2->save($data);
        }
        if($row&&$row1&&$row2) echo '1';
        else echo '2';
    }

    // 验证原密码密码
    public function change_password(){
        $name = $_COOKIE['id'];
        $arr=json_decode(file_get_contents('php://input'));
        $password = $arr->pass;
        $pass = md5($password);
        $q_users = D('eng_users');
        $row = $q_users->where('name='.$name)->find();
        //dump($row);
        if($pass == $row['pass']) echo 1;
        else echo 2;
    }

    //修改密码
    public function change_password2(){
        $name = $_COOKIE['id'];
        $arr=json_decode(file_get_contents('php://input'));
        $password = $arr->pass;
        $data['pass'] = md5($password);
        $q_user = D('eng_users');
        $q_user1 = D('users');
        $q_user2 = D('pipi_users');
        $row = $q_user->where("name={$name}")->save($data);
        $row1 = $q_user1->where("name={$name}")->save($data);
        $row2 = $q_user2->where("name={$name}")->save($data);
        if($row&&$row1&&$row2){
            cookie('id',null);
            echo 1;
        }else{
            echo 2;
        }
    }
    //会员中心
    public function me(){
        $user_id = $_COOKIE['id'];
        $q_user = D('eng_users');
        $row = $q_user->where('name='.$user_id)->find();
        if(!$row){
          echo 1;
          die();
        }
        unset($row['pass']);
        unset($row['email']);
        unset($row['state']);
        unset($row['id']);
        unset($row['dlu']);
        $phone = $row['phone'];
        $nphone = substr($phone,0,5).'****'.substr($phone,9,4);
        $row['phone']=$nphone;
        // dump($row);
        echo json_encode($row);
        
    }


    //个人中心 查看红包
    public function takeaway_pay(){
        $id = usersId();
        $q_cc = D('eng_cc');
        // $id = 27;
        $row = $q_cc->field('id,stop,tj,djin,name')->where("uid = {$id} AND yong= 1")->select();
        foreach ($row as $k => $v) {
          switch ($v['name']) {
            case 1:
              $v['name'] = '外卖商家优惠券';
              break;
            case 2:
              $v['name'] = '外卖通用优惠券';
              break;
            
          }
            $v['time'] = date("Y-m-d",$v['stop']);
            if($v['stop']<time()){
                //超过使用期限
              unset($v['stop']);
              $rrow['mei'][]=$v;
            }else{
                // 能用的
              unset($v['stop']);
              $rrow['hao'][]=$v;
            }
        }
        // dump($rrow);
        echo json_encode($rrow);
    }

    //外卖下单放 查看红包
    public function takeaway(){
      $uid = usersId();
      $sid = $_COOKIE['C057DF743DCFDA2C'];

      $q_cc = D('eng_cc');
      $time = time();
      $row = $q_cc->field('id,tj,stop,djin,sid,name')->where("uid={$uid} AND stop>{$time} AND yong= 1")->select();
      foreach ($row as $k => $v) {
          switch ($v['name']) {
            case 1:
              $v['name'] = '外卖商家优惠券';
              break;
            case 2:
              $v['name'] = '外卖通用优惠券';
              break;
            
          }
            $v['time'] = date("Y-m-d",$v['stop']);
            if($v['sid']!=$sid){
                //超过使用期限
              unset($v['sid']);
              unset($v['stop']);
              $rrow['mei'][]=$v;
            }else{
                // 能用的
              unset($v['sid']);
              unset($v['stop']);
              $rrow['hao'][]=$v;
            }

        }
      echo json_encode($rrow);
      // dump($rrow);

    }
    //发送短信
    public function fasong(){

      $arr=json_decode(file_get_contents('php://input'));
      $phone = $arr->phone;
      $type = $arr->type;
      $typee = $arr->typee;

      if($typee == 2){ //修改手机
          $q_users = D('eng_users');
          $name = $_COOKIE['id'];
          $roww = $q_users->where("name = {$name}")->find();
          $phone = $roww['phone'];
      }


      if($type===0){  //中国手机
        require_once  './Api/api_sdk/vendor/autoload.php';
        Config::load();
        $accessKeyId = "LTAIajjkaPaLPoyh"; // AccessKeyId
        $accessKeySecret = "LMtXx3enS9lal4gziQmFSLkIRPxMfY"; // AccessKeySecret
        $templateCode = 'SMS_116560511';
        $product = "Dysmsapi";
        $domain = "dysmsapi.aliyuncs.com";
        $region = "cn-hangzhou";
        $endPointName = "cn-hangzhou";
        $profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);
        DefaultProfile::addEndpoint($endPointName, $region, $product, $domain);
        $acsClient = new DefaultAcsClient($profile);
        $request = new SendSmsRequest();


        $phone = ltrim($phone,"中国+");
        $ma = rand(000000,999999);
        if(strlen($ma)!=6){
            $ma = str_pad($ma,6,"0",STR_PAD_LEFT);
        }
        $q_pma = D('eng_pma');
        $q_pma1 = D('pma');
        $q_pma2 = D('pipi_pma');
        $data['ma'] = $ma;
        $data['time'] = time();
        $row = $q_pma->where("phone=".$phone)->find();
        if($row){
          // $data['id'] = $row['id'];
          $cun = $q_pma->where("phone = {$phone}")->save($data);
          $cun1 = $q_pma1->where("phone = {$phone}")->save($data);
          $cun2 = $q_pma2->where("phone = {$phone}")->save($data);
        }else{
          $data['phone'] = $phone;
          $cun = $q_pma->add($data);
          $cun1 = $q_pma1->add($data);
          $cun2 = $q_pma2->add($data);
        }
        $phone = ltrim($phone,"86");
        $request->setPhoneNumbers($phone);
        $request->setSignName("刘思邈");
        $request->setTemplateCode("SMS_116560511");
        $request->setTemplateParam(json_encode(Array(  // 短信模板中字段的值
            "code"=>"{$ma}",
            "product"=>"dsd"
        )));
        $acsResponse = $acsClient->getAcsResponse($request);
        $result = json_decode(json_encode($acsResponse), true);
        return $result;

      }
      if($type ===1){  //老挝手机







      }
      
    }

    //修改手机号
    public function gaip(){
      $arr=json_decode(file_get_contents('php://input'));
      $ma = $arr->ma;
      $phone = $arr->phone;
      $phone = ltrim($phone,"中国+");
      $q_pma = D('eng_pma');
      $q_users = D('eng_users');
      $q_users1 = D('users');
      $q_users2 = D('pipi_users');

      $row = $q_pma->where("phone = {$phone} AND ma = {$ma}")->find();
        if($row){
            $aa = time()-$row['time'];
            if($aa<300){
               $rowk = $q_users->where("phone = {$n_phone}")->find();
                if($rowk) echo 3;  //新电话存在
                else{
                  $name = $_COOKIE['id'];
                  $data['phone'] = $phone;
                  $q_row = $q_users->where('name='.$name)->save($data);
                  $q_row1 = $q_users1->where('name='.$name)->save($data);
                  $q_row2 = $q_users2->where('name='.$name)->save($data);
                  if($q_row && $q_row1 && $q_row2) echo 1;  //修改成功
                  else echo 4;  //修改失败
                }
            }else echo 5; //验证时间大于5分钟 验证码失效
        }else echo 2;  //验证码错误

    }
    
    // 验证原手机号
    public function yuanp(){
      $arr=json_decode(file_get_contents('php://input'));
      $ma = $arr->ma;

      $q_pma = D('eng_pma');
      $q_users = D('eng_users');
      $name = $_COOKIE['id'];
      $rrow = $q_users->where("name = {$name}")->find();
      $phone = $rrow['phone'];
      $row = $q_pma->where("phone = {$phone} AND ma = {$ma}")->find();
      if($row){
          $aa = time()-$row['time'];
          if($aa<300) echo 1;  //验证成功
          else echo 3;  //验证时间大于5分钟 验证码失效
      }else echo 2;  //验证码错误
    }

    


    // 外卖套餐电子订单 评价
    public function tcan_ping(){

        $arr=json_decode(file_get_contents('php://input'));
        $num = $arr->num;
        $type = $arr->type;
        $id = $arr->id;
        $mai = $arr->mai;

/*$num=0;
$type=1;
$id=1;
$mai=3;*/
        $q_model = D();
        $q_pjpic = D('eng_pjpic');

        if($type==1) $xin = "ORDER BY p.dj desc";
        elseif($type==2) $xin = "ORDER BY p.ptime desc";
        elseif($type==3) $tu = "AND p.pics = 2 ORDER BY p.ptime desc";
        elseif($type==4) $xin = "ORDER BY p.dj asc";   
        if($mai==1) $pl = $q_model->query("select p.id,p.dj,p.pics,p.ptime,p.nrong,u.headpic,u.username from eng_eng_eng_ddshop dd,eng_eng_eng_pj p,eng_eng_eng_users u where dd.ddid = p.did and p.uid = u.id and dd.sid = {$id} and p.type = 1 {$tu} {$xin} limit {$num},6"); //外卖
        elseif($mai==2) $pl = $q_model->query("select p.id,p.dj,p.pics,p.ptime,p.nrong,u.headpic,u.username from eng_eng_t_ddan dd,eng_eng_pj p,eng_eng_users u where dd.id = p.did and p.uid = u.id and dd.fid = {$id} and p.type = 2 {$tu} {$xin} limit {$num},6");  //套餐
        elseif($mai==3) $pl = $q_model->query("select p.id,p.dj,p.pics,p.ptime,p.nrong,u.headpic,u.username from eng_dzddshop dzdd,eng_pj p,eng_users u where dzdd.dzddid = p.did and p.uid = u.id and dzdd.sid = {$id} and p.type = 3 {$tu} {$xin} limit {$num},6");  //电子订单
        
        foreach ($pl as $k => $v) {
          $pl[$k]['ptime'] = date("Y-m-d H:i",$v['ptime']);
            if($v['pics']==2){ //有图片
              $q_pics = $q_pjpic->field('picname')->where("pjid=".$v['id'])->select();
              $pl[$k]['pic']=$q_pics;
            }
            unset($pl[$k]['id']);
            unset($pl[$k]['pics']);
        }

        // dump($pl);
        echo json_encode($pl);
    }

    //外卖满减
    public function mjian(){
        $id= 1;

        $q_hd = D('eng_hd');
        $row = $q_hd->where("sid = {$id}")->select();
        // dump($row);
        echo json_encode($row);
    }
    //再查看订单
    public function kandd(){
        $arr=json_decode(file_get_contents('php://input'));
        $id = $arr->id;
        $q_model = D();
        $row = $q_model->query("select t.tcname,t.oldprice,t.tcprice,s.name from eng_shop s,eng_tc t where t.id={$id} and s.id=t.sid")[0];
        echo json_encode($row);
    }
    //堂食生成订单
    public function tjiao(){
        // $user_id = 10;
        $user_id = usersId();  //用户id
        $shop_id = $_COOKIE['4373433CA7C70528']; // 堂食店的id
        $arr=json_decode(file_get_contents('php://input'));
        $id = $arr->id;
        $num = $arr->num;

        $q_ddan = D('eng_ddan');
        $q_ddan1 = D('ddan');
        $q_ddan2 = D('pipi_ddan');
        $q_ddshop = D('eng_ddshop');
        $q_ddshop1 = D('ddshop');
        $q_ddshop2 = D('pipi_ddshop');
        $q_tc = D('eng_tc');
        $q_tc1 = D('tc');
        $q_tc2 = D('pipi_tc');
        $show_tc = $q_tc->where("id={$id}")->find();
        $yu = $show_tc['stock']-$num;
        if($yu<0) die('3');  //库存不足
        // ddan订单表添加数据
        $data['uid'] = $user_id;
        $data['sid'] = $shop_id;
        $data['time'] = time();
        $data['yuan'] = $show_tc['oldprice'];
        $data['you'] = $show_tc['tcprice'];
        $data['mai'] = 2;
        $row = $q_ddan->add($data);
        $row1 = $q_ddan1->add($data);
        $row2 = $q_ddan2->add($data);
        // ddshop表添加数据
        if(!$row || !$row1 || !$row2) die('2');
        $ddta['sid'] = $id;
        $ddta['ddid'] = $row;
        $ddta['num'] = $num;
        $ddta['money'] = $show_tc['tcprice']*$num;
        $ddta['name'] = $show_tc['tcname'];
        $rrow = $q_ddshop->add($ddta);
        $rrow1 = $q_ddshop1->add($ddta);
        $rrow2 = $q_ddshop2->add($ddta);
        if(!$rrow || !$rrow1 || !$rrow2) die('2');
        //减库存
        $datt['stock'] = $yu;
        $datt['id'] = $id;
        $ok = $q_tc->save($datt);
        $ok1 = $q_tc1->save($datt);
        $ok2 = $q_tc2->save($datt);
        if(!$ok || !$ok1 || !$ok2) die('2');
        echo $row;
    }


    // 买家确认外卖收货
    public function shou(){
        $id = 4;
        $q_ddan = D('eng_ddan');
        $q_ddan1 = D('ddan');
        $q_ddan2 = D('pipi_ddan');
        $s_ddan = D('eng_s_ddan');
        $s_ddan1 = D('s_ddan');
        $s_ddan2 = D('pipi_s_ddan');
        $row = $q_ddan->where("id={$id}")->find();
        // dump($row);
        $error = true;
        if($row['ztai'] ==6){
          $data['id'] = $id;
          $data['ztai'] = 3;
          $rowa = $q_ddan->save($data);
          $rowa1 = $q_ddan1->save($data);
          $rowa2 = $q_ddan2->save($data);
          if(!$rowa || !$rowa1 || !$rowa2) $error = false;

          $dataa['ztai'] = 4;
          $rowaa = $s_ddan->where("did={$id}")->save($dataa);
          $rowaa1 = $s_ddan1->where("did={$id}")->save($dataa);
          $rowaa2 = $s_ddan2->where("did={$id}")->save($dataa);
          if(!$rowaa || !$rowaa1 || !$rowaa2) $error = false;
        }
        if($error) echo 1;
        else echo 2;
    }


    // 待评价  待使用时买家退款
    public function tui(){
        $arr=json_decode(file_get_contents('php://input'));
        $id = $arr->id;
        $type = $arr->type;
        $why = $arr->why;

        $q_ddan = D('eng_ddan');
        $q_ddan1 = D('ddan');
        $q_ddan2 = D('pipi_ddan');
        $s_ddan = D('eng_s_ddan');
        $s_ddan1 = D('s_ddan');
        $s_ddan2 = D('pipi_s_ddan');
        $row = $q_ddan->where("id={$id}")->find();
        // dump($row);
        $error = true;
        if($row['ztai'] ==3 || $row['ztai'] ==2){
            $data['id'] = $id;
            $data['ztai'] = 5;
            $data['type'] = $type;
            $data['why'] = $why;
            $rowa = $q_ddan->save($data);
            $rowa1 = $q_ddan1->save($data);
            $rowa2 = $q_ddan2->save($data);
            if(!$rowa || !$rowa1 || !$rowa2) $error = false;

            $dataa['ztai'] = 6;
            $rowaa = $s_ddan->where("did={$id}")->save($dataa);
            $rowaa1 = $s_ddan1->where("did={$id}")->save($dataa);
            $rowaa2 = $s_ddan2->where("did={$id}")->save($dataa);
            if(!$rowaa || !$rowaa1 || !$rowaa2) $error = false;
        }else $error = false;
        if($error) echo 1;
        else echo 2;
    }

    // 堂食付款前
    public function fuq(){
      $arr=json_decode(file_get_contents('php://input'));
      $id = $arr->id;  //待付款的订单id
      $user_id = usersId();  //用户id
      $shop_id = $_COOKIE['4373433CA7C70528']; // 堂食店的id

      $ddan = D('eng_ddan');
      $model = D();
      $row = $ddan->where("id={$id}")->find();
      if($row['uid']!=$user_id || $row['sid']!=$shop_id) die('2');  //不匹配
      $rrow = $model->query("select s.headpic,d.time,t.tcprice from eng_ddan d,eng_ddshop dd,eng_tc t,eng_shop s where d.id={$id} AND d.sid=s.id AND dd.ddid=d.id AND dd.sid=t.id")[0];
      
      $rrow['id']=$row['time'].$row['id'];
      $rrow['time'] = date("Y-m-d H:i:s",$rrow['time']);
      echo json_encode($rrow);
    }


    // 堂食付款成功  生成二维码
    public function mama(){
        $id = 10; //ddid 的 id


        $q_mama = D('eng_mama');
        $q_mama1 = D('mama');
        $q_mama2 = D('pipi_mama');
        $q_ddan = D('eng_ddan');
        $q_ddan1 = D('ddan');
        $q_ddan2 = D('pipi_ddan');
        $t_ddan = D('eng_t_ddan');
        $t_ddan1 = D('t_ddan');
        $t_ddan2 = D('pipi_t_ddan');
        $kan = $q_ddan->where("id={$id}")->find();
        if($kan['ztai'] !=1 ){
          echo 3;
          die();
        }

        // 生成堂食商家订单详情
        $qrow = $q_ddan->where("id={$id}")->find();

        $aha['uid'] = $qrow['uid'];
        $aha['time'] = time();
        $aha['yuan'] = $qrow['you'];
        $aha['did'] = $qrow['id'];
        $aha['ztai'] = 1;
        $aha['sjid'] = $qrow['sid'];
        $rr = $t_ddan->add($aha);
        $rr1 = $t_ddan1->add($aha);
        $rr2 = $t_ddan2->add($aha);

        // 生成二维码
        $rowq = $q_mama->select();
        foreach ($rowq as $k => $v) {
            $namea[] = $v['ma'];
        }
        do{
          $ma = rand(00000000,99999999);
            if(strlen($ma)!=8){
              $ma = str_pad($ma,8,"0",STR_PAD_LEFT);
            }
        }while (in_array($ma,$namea));
        
        $aa['id'] = $id;
        $aa['ztai'] = 2;
        $ztt = $q_ddan->save($aa);
        $ztt1 = $q_ddan1->save($aa);
        $ztt2 = $q_ddan2->save($aa);
        if($ztt && $ztt1 && $ztt2 && $rr && $rr1 && $rr2){
            $url = "www.kintime.in/kintime-webapp/PHP/home/foods/sao?ma={$ma}";
            // $url="www.jadfafdaa13.com";
            $level=3;
            $size=4;
	          $PNG_TEMP_DIR = './../../temp/';
	          if (!file_exists($PNG_TEMP_DIR)){
			            mkdir($PNG_TEMP_DIR);
			      }
			      $filename = $PNG_TEMP_DIR.md5($url).'kintime.png';
			      if (file_exists($filename)){
			        echo 5;
			        die();
			      }
			      Vendor('phpqrcode.phpqrcodea');
			      $errorCorrectionLevel =intval($level) ;//容错级别
			      $matrixPointSize = intval($size);//生成图片大小
			       //生成二维码图片
			      $object = new \QRcode();
			      $object->png($url, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
			        // echo $filename;

			      $mp['pic'] = $PNG_TEMP_DIR.md5($url);
				      $mp['ma'] = $ma;
				      $mp['ddid'] = $id;
                      $row = $q_mama->add($mp);
                      $row1 = $q_mama1->add($mp);
				      $row2 = $q_mama2->add($mp);
			      if($row && $row1 && $row2) echo 1;
        		else echo 4; 
        }else echo 2;
       
    }

    

    // 注册
    public function zhu(){
        /*$phone = $_POST['phone'] = 17624086614;
        $ma = $_POST['ma'] = 835723;
        $pass = $_POST['pass'] = 123456;*/
        
        $arr=json_decode(file_get_contents('php://input'));
        $phone = $arr->phone;
        $ma = $arr->ma;
        $pass = $arr->pass;

        $phone = ltrim($phone,"中国+");
        $phone = ltrim($phone,"老挝+");
        $q_pma = D('eng_pma');
        $q_users = D('eng_users');
        $q_users1 = D('users');
        $q_users2 = D('pipi_users');
        $q_yer = D('eng_yer');
        $q_yer1 = D('yer');
        $q_yer2 = D('pipi_yer');

        $rowq = $q_users->where("phone = {$phone}")->find();
        if($rowq){
          echo 2; //手机号已经存在
          die();
        }
        $row = $q_pma->where("phone = {$phone} and ma = {$ma}")->find();
        if($row){
          if((time()-$row['time'])<30000){
              //生成 会员号
              $rowqq = $q_users->select();
              foreach ($rowqq as $k => $v) {
                  $namea[] = $v['name'];
              }
              do {
                $name = rand(00000000,99999999);
                  if(strlen($name)!=8){
                    $name = str_pad($name,8,"0",STR_PAD_LEFT);
                }
              } while(in_array($name,$namea));

              $username = createRandomStr(10);
              $data['phone'] = $phone;
              $pass = md5($pass);
              $data['pass'] = $pass;
              $data['name'] = $name;
              $data['state'] = 1;
              $data['username'] =$username;
              $ab = $q_users->add($data);
              $ab1 = $q_users1->add($data);
              $ab2 = $q_users2->add($data);
              // 余额表生成信息
              $yer['uid'] = $ab;
              $yer['yuan'] = 0;
              $yer['new'] = 0;
              $yer['time'] = time();
              $yer['sming'] = 3;
              $abc = $q_yer->add($yer);
              $abc1 = $q_yer1->add($yer);
              $abc2 = $q_yer2->add($yer);
              if($ab && $abc && $ab1 && $abc1 && $ab2 && $abc2) echo 1;
              else echo 5;  // 注册失败
          }else echo 4; //验证码超时
        }else echo 3; //验证码不正确
          // echo time();
    }

  // 用户头像上传
  public function upic(){
      $arr=json_decode(file_get_contents('php://input'));
      $img = $arr->img;

      $q_users = D('eng_users');
      $q_users1 = D('eng_users');
      $q_users2 = D('eng_users');
      // cookie('id',37219238);
      $name = $_COOKIE['id'];
      $row = $q_users->where("name={$name}")->find();
      // dump($row);
      if($row){
          unlink($row['headpic']); //删除原图片
          //base64 图片保存 //
          //  $base_img是获取到前端传递的src里面的值，也就是我们的数据流文件
          $base_img = str_replace('data:image/jpg;base64,', '', $img);
          //  设置文件路径和文件前缀名称
          $path = "../STATIC/img/";
          $prefix='hd_';
          $output_file = $prefix.time().rand(100,999).'.jpg';
          $path = $path.$output_file;
          //  创建将数据流文件写入我们创建的文件内容中
          $ifp = fopen( $path, "wb" );
          // 第一种方式
          fwrite( $ifp, base64_decode( $base_img) );//打开文件写内容
          // 第二种方式
          // file_put_contents($path, base64_decode($base_img));
          fclose( $ifp );//写完内容 关文件
          // 输出文件
          // echo($output_file);
          //base64 图片保存 //
          // 修改数据库
          $data['headpic'] = $path;
          $rrow = $q_users->where("name={$name}")->save($data);
          $rrow1 = $q_users1->where("name={$name}")->save($data);
          $rrow2 = $q_users2->where("name={$name}")->save($data);
          if($rrow && $rrow1 && $rrow2) echo 1;  //修改成功
          else echo 2;  //修改失败
      }else echo 3; //登录超超时
      
  }


  // 用户修改性别  昵称
  public function sex(){
      $arr=json_decode(file_get_contents('php://input'));
      $type = $arr->type;
      $zhi = $arr->zhi;

      $q_users = D('eng_users');
      $q_users1 = D('users');
      $q_users2 = D('pipi_users');
      $name = $_COOKIE['id'];

       $rrow = $q_users->where("name={$name}")->find();
      if($type == 1){ //改性别
        if($rrow['sex']!=$zhi){
          $data['sex'] = $zhi;
          $row = $q_users->where("name={$name}")->save($data);
          $row1 = $q_users1->where("name={$name}")->save($data);
          $row2 = $q_users2->where("name={$name}")->save($data);
          if($row) echo 1;
          else echo 2;
        }else echo 1;
      }else{          // 改昵称
         if($rrow['name']!=$zhi){
          $data['username'] = $zhi;
          $row = $q_users->where("name={$name}")->save($data);
          $row1 = $q_users1->where("name={$name}")->save($data);
          $row2 = $q_users2->where("name={$name}")->save($data);
          if($row && $row1 && $row2) echo 1;
          else echo 2;
        }else echo 1;
      }
      
  }

  //查看有规格的外卖价格
  public function gg_money(){
    $user_id = usersId();  //用户id
    $shop_id = $_COOKIE['C057DF743DCFDA2C']; // 外卖店的id
    $arr=json_decode(file_get_contents('php://input'));
    $cai = $arr->cai;
    $gge = $arr->gge;

    // $cai = 1;
    // $gge =  '4,9,11';
    $gge = rtrim($gge,',');

    $ggetype = D('eng_ggetype');
    $food = D('eng_food');
    $gge_row = explode(',', $gge);
    //基础价
    $jichu = $food->where("id={$cai}")->find()['zhekou'];
    foreach ($gge_row as $key => $value) {
      $jia = $ggetype->where("id={$value}")->find()['price'];
      $jichu+=$jia;
    }
    echo $jichu;

  }


  //查看外卖购物车  小车
  public function kgwc(){
    $user_id = usersId();  //用户id
    $shop_id = $_COOKIE['C057DF743DCFDA2C']; // 外卖店的id

    $q_model = D();
    $row = $q_model->query("select g.num,f.cainame,g.fid,f.zhekou,g.gge from eng_shopcar c,eng_sgoods g,eng_food f where c.uid={$user_id} AND c.sid={$shop_id} AND c.id=g.carid AND g.fid=f.id");

    $all = 0;
    foreach ($row as $key => $value) {
      if($value['gge']!=0){ // 有规格的价格不一样

        $gge = rtrim($value['gge'],',');

        $ggetype = D('eng_ggetype');
        $food = D('eng_food');
        $gge_row = explode(',', $gge);

        foreach ($gge_row as $k => $v) {
          $type_row = $ggetype->where("id={$v}")->find();
          $jia = $type_row['price'];
          $value['zhekou'] += $jia;
          $lei = $type_row['name'];
          $row[$key]['cainame'] .= "[".$lei."]";
        }
      }

      $row[$key]['ji'] = $value['num']*$value['zhekou'];
      $all += $row[$key]['ji'];
      unset($row[$key]['zhekou']);
    }
    $row['all'] =$all;
    // dump($row);
    echo json_encode($row);
  }

  //查看外卖购物车  大车
  public function dgwc(){
    $user_id = usersId();  //用户id
    $shop_id = $_COOKIE['C057DF743DCFDA2C']; // 外卖店的id

    $q_model = D();
    $q_users = D('eng_users');
    $ggetype = D('eng_ggetype');
    $shopcar = D('eng_shopcar');
    $shopcar1 = D('shopcar');
    $shopcar2 = D('pipi_shopcar');
    $q_cc = D('eng_cc');
    $q_shdz = D('eng_shdz');
    $q_hd = D('eng_hd');
    $m_shop = D('eng_m_shop');
    // $m_shop = D('eng_m_shop');
    $rarow = $m_shop->field('name,song,gogo,headpic')->where("id={$shop_id}")->find();
    $row['name'] = $rarow['name'];
    $row['song'] = $rarow['song'];
    $gogo = $rarow['gogo'];

    $row['food'] = $q_model->query("select g.num,f.cainame,f.zhekou,g.gge from eng_shopcar c,eng_sgoods g,eng_food f where c.uid={$user_id} AND c.sid={$shop_id} AND c.id=g.carid AND g.fid=f.id");
    
    $all = 0;
    foreach ($row['food'] as $key => $value) {
      if($value['gge']!=0){ // 有规格的价格不一样
        $gge = rtrim($value['gge'],',');
        $gge_row = explode(',', $gge);
        foreach ($gge_row as $k => $v) {
          $type_row = $ggetype->where("id={$v}")->find();
          $jia = $type_row['price'];
          $value['zhekou'] += $jia;
          $lei = $type_row['name'];
          $row['food'][$key]['cainame'] .= "[".$lei."]";
        }
      }
      $row['food'][$key]['ji'] = $value['num']*$value['zhekou'];
      $all += $row['food'][$key]['ji'];
      unset($row['food'][$key]['zhekou']);
    }
    // 判断够不够起送价
    $all+=$row['song'];
    if($all<$gogo) die('1');

    $roow = $shopcar->where("uid={$user_id} AND sid={$shop_id}")->find();
    // dump($roow);
    if($roow['ccid']==0){
      //优惠券
      $time= time();
      $row['cc'] = $q_cc->where("((uid={$user_id} AND name=1) or name=2) AND yong=1 AND stop>{$time} AND sid={$shop_id}")->count();
    }else{
      $cc_id = $roow['ccid'];
      $row['yh'] = $q_cc->where("id={$cc_id}")->find()['djin'];
      $all-=$row['yh'];
    }

    //满减
    $hd_row = $q_hd->order("tj desc")->where("sid={$shop_id} AND $all>=tj")->find();
    if($hd_row) $row['djin'] = $hd_row['djin'];
    else $row['djin'] = 0;
    $all-=$row['djin'];
    //收货地址
    $dz_id = $roow['dzid'];
    $dz_row = $q_shdz->where("id={$dz_id}")->find();
    $linkman = $dz_row['linkman'];
    $row['phone'] = $dz_row['phone'];
    $row['address'] = $dz_row['address'];
    $row['xiaddress'] = $dz_row['xiaddress'];
    $sex = $dz_row['sex'];
    if($sex==1) $row['linkman'] = $linkman."(先生)";
    else $row['linkman'] = $linkman."(女士)";
    $row['jing'] = $dz_row['jing'];
    $row['wei'] = $dz_row['wei'];
    // 实际付款
    
    $row['all'] =$all;
    $ddata['zong'] = $all;
    $ddata['id'] = $roow['id'];
    $shopcar->save($ddata);
    $shopcar1->save($ddata);
    $shopcar2->save($ddata);
    // dump($row);

    $newid = time().$roow['id'];
    $newtime = (date("Y-m-d H:i:s",time()));
    // $headpic = $food->field('headpic')->where("id={$shop_id}")->find()['headpic'];
    $row['ok'] = [
      'newid' => $newid,
      'money' => $all,
      'time' => $newtime,
      'headpic' => $rarow['headpic'],
    ];
    // echo json_encode($ok);
    echo json_encode($row);
  }


  //修改外卖购物车
  public function ggwc(){
    $user_id = usersId();  //用户id
    $shop_id = $_COOKIE['C057DF743DCFDA2C']; // 外卖店的id

    $arr=json_decode(file_get_contents('php://input'));
    $type = $arr->num;  //1加 2减
    $cai = $arr->cai;
    $gge = $arr->gge;

    $q_shopcar = D('eng_shopcar');
    $q_shopcar1 = D('shopcar');
    $q_shopcar2 = D('pipi_shopcar');
    $q_sgoods = D('eng_sgoods');
    $q_sgoods1 = D('sgoods');
    $q_sgoods2 = D('pipi_sgoods');
    $q_users = D('eng_users');
    $row= $q_shopcar->where("uid={$user_id} AND sid={$shop_id}")->find();
    $carid= $row['id']; 
    $error = true;
    if($row){  //有这个店铺 
      $raow = $q_sgoods->where("fid={$cai} AND carid={$carid} AND gge='{$gge}'")->find();  //有没有这道菜
      if($raow){  //有这道菜
        if($type==2 && $raow['num']==1){//数量为0 删掉这个菜
          $a1 = $q_sgoods->where("fid={$cai} AND carid={$carid} AND gge='{$gge}'")->delete(); 
          $a2 = $q_sgoods1->where("fid={$cai} AND carid={$carid} AND gge='{$gge}'")->delete(); 
          $a3 = $q_sgoods2->where("fid={$cai} AND carid={$carid} AND gge='{$gge}'")->delete(); 
          if(!$a1 || !$a2 ||!$a3) $error = false;
        }else{
          // 菜有有规格
          $gg = $raow['gge'];
          if($gge==0 || $gge==$gg){  //没有规格的菜  或者 菜的规格有了  征程修改
            $num = $raow['num'];
            if($type==1) $num++;
            else $num--;
            $data['num'] = $num;
            $data['gge'] = $gge;
            $data['id'] = $raow['id'];
            $rbow = $q_sgoods->save($data);
            $rbow1 = $q_sgoods1->save($data);
            $rbow2 = $q_sgoods2->save($data);
            if(!$rbow || !$rbow1 ||!$rbow2) $error = false;
          }else{    //没有这个规格  添加菜
            $data['num'] = 1;
            $data['fid'] = $cai;
            $data['gge'] = $gge;
            $data['carid'] = $carid;
            $rbow = $q_sgoods->add($data);
            $rbow1 = $q_sgoods1->add($data);
            $rbow2 = $q_sgoods2->add($data);
            if(!$rbow || !$rbow1 ||!$rbow2) $error = false;
          }
        }
      }else{     //没有这道菜
        $data['num'] = 1;
        $data['fid'] = $cai;
        $data['gge'] = $gge;
        $data['carid'] = $carid;
        $rbow = $q_sgoods->add($data);
        $rbow1 = $q_sgoods1->add($data);
        $rbow2 = $q_sgoods2->add($data);
        if(!$rbow || !$rbow1 ||!$rbow2) $error = false;
      }
    }else{     //没有这个店铺 添加购物车店铺
      $data['uid'] = $user_id;
      $data['sid'] = $shop_id;
      $data['dzid'] = $q_users->where("id = {$user_id}")->find()['dzid'];
      $row = $q_shopcar->add($data);
      $row1 = $q_shopcar1->add($data);
      $row2 = $q_shopcar2->add($data);
      if($row && $row1 && $row2){  //添加菜
        $ddata['num'] = 1;
        $ddata['fid'] = $cai;
        $ddata['gge'] = $gge;
        $ddata['carid'] = $row;
        $rrow = $q_sgoods->add($ddata);
        $rrow1 = $q_sgoods1->add($ddata);
        $rrow2 = $q_sgoods2->add($ddata);
        if(!$rrow || !$rrow1 ||!$rrow2) $error = false;
      }else $error = false;
    }
    //判断返回
    if($error) echo 1;
    else echo 2;

  }

  //更换外卖购物车收货地址  优惠券
  public function dan_dz(){
    $user_id = usersId();  //用户id
    $shop_id = $_COOKIE['C057DF743DCFDA2C']; // 外卖店的id

    $arr=json_decode(file_get_contents('php://input'));
    $id = $arr->id;
    $type = $arr->type; //1地址  2优惠券
    $shopcar = D('eng_shopcar');
    $shopcar1 = D('shopcar');
    $shopcar2 = D('pipi_shopcar');
    $rrow = $shopcar->where("uid={$user_id} AND sid={$shop_id}")->find();
    if($type==1){
      if($rrow['dzid']==$id) die('1');
      $data['dzid'] = $id;
    }else{
      $data['ccid'] = $id;
      if($rrow['ccid']==$id) die('1');
    }
    $row = $shopcar->where("uid={$user_id} AND sid={$shop_id}")->save($data);
    $row1 = $shopcar1->where("uid={$user_id} AND sid={$shop_id}")->save($data);
    $row2 = $shopcar2->where("uid={$user_id} AND sid={$shop_id}")->save($data);
    if($row $$ $row1 $$ $row2) echo '1';
    else echo '2';
  }

  //清空购物车
  public function che_mei(){
    $user_id = usersId();  //用户id
    $shop_id = $_COOKIE['C057DF743DCFDA2C']; // 外卖店的id

    $shopcar = D('eng_shopcar');
    $shopcar1 = D('shopcar');
    $shopcar2 = D('pipi_shopcar');
    $sgoods = D('eng_sgoods');
    $sgoods1 = D('sgoods');
    $sgoods2 = D('pipi_sgoods');
    $id = $shopcar->where("uid={$user_id} AND sid={$shop_id}")->find()['id'];
    $a = $shopcar->where("id={$id}")->delete();
    $a1 = $shopcar1->where("id={$id}")->delete();
    $a2 = $shopcar2->where("id={$id}")->delete();

    $b = $sgoods->where("carid={$id}")->delete();
    $b1 = $sgoods1->where("carid={$id}")->delete();
    $b2 = $sgoods2->where("carid={$id}")->delete();
    if($a && $b && $a1 && $b1 && $a2 && $b2) echo 1;
    else  echo 2;
  }

  //外卖生成订单
public function dan(){
    $user_id = usersId();  //用户id
    $shop_id = $_COOKIE['C057DF743DCFDA2C']; // 外卖店的id

/*$user_id=27;
$shop_id=1;*/
    $q_shopcar = D('eng_shopcar');
    $q_shopcar1 = D('shopcar');
    $q_shopcar2 = D('pipi_shopcar');
    $q_sgoods = D('eng_sgoods');
    $q_sgoods1 = D('sgoods');
    $q_sgoods2 = D('pipi_sgoods');
    $ggetype = D('eng_ggetype');
    $shdz = D('eng_shdz');
    $dddz = D('eng_dddz');
    $dddz1 = D('dddz');
    $dddz2 = D('pipi_dddz');
    $ddan = D('eng_ddan');
    $ddan1 = D('ddan');
    $ddan2 = D('pipi_ddan');
    $ddshop = D('eng_ddshop');
    $ddshop1 = D('ddshop');
    $ddshop2 = D('pipi_ddshop');
    $cc = D('eng_cc');
    $cc1 = D('cc');
    $cc2 = D('pipi_cc');
    $q_model = D();

    $row= $q_shopcar->where("uid={$user_id} AND sid={$shop_id}")->find();
    $carid = $row['id'];
    $g_row = $q_model->query("select s.*,f.cainame,f.zhekou from eng_sgoods s,eng_food f where f.id=s.fid AND s.carid={$carid}");

    foreach ($g_row as $key => $value) {
      if($value['gge']!=0){
        $gge = rtrim($value['gge'],',');
        $gge_row = explode(',', $gge);
        foreach ($gge_row as $k => $v) {
          $type_row = $ggetype->where("id={$v}")->find();
          $lei = $type_row['name'];
          $g_row[$key]['cainame'] .= "[".$lei."]";
          $jia = $type_row['price'];
          $g_row[$key]['zhekou'] += $jia;
        }
      }
    }
    $dz_row = $shdz->field('linkman,sex,phone,address,jing,wei')->where("id={$row['dzid']}")->find();
    //添加外卖收货地址表
    $dz_add = $dddz->add($dz_row);
    $dz_add1 = $dddz1->add($dz_row);
    $dz_add2 = $dddz2->add($dz_row);
    if(!$dz_add || !$dz_add1 || !$dz_add2) die('2');

    $rowqq = $ddan->field('hao')->select();
    foreach ($rowqq as $k => $v) {
        $haoa[] = $v['hao'];
    }
    do {
      $hao = rand(000000000,999999999);
        if(strlen($hao)!=9){
          $hao = str_pad($hao,9,"0",STR_PAD_LEFT);
      }
    } while(in_array($hao,$haoa));
    //添加ddan
    $dd_data = [
      'uid' => $user_id,
      'sid' => $shop_id,
      'time' => time(),
      'you' => $row['zong'],
      'ztai' => 1,
      'see' => 1,
      'mai' => 1,
      'zhu' => $row['zhu'],
      'num' => $row['num'],
      'dzid' => $dz_add,
      'hao' => $hao,
    ];
    $dd_add = $ddan->add($dd_data);
    $dd_add1 = $ddan1->add($dd_data);
    $dd_add2 = $ddan2->add($dd_data);
    if(!$dd_add || !$dd_add1 || !$dd_add2) die('2');
    //添加ddshop
    foreach ($g_row as $k => $v) {
      $dds_data = [
        'sid' => $shop_id,
        'money' => $v['zhekou'],
        'ddid' => $dd_add,
        'num' => $v['num'],
        'name' => $v['cainame'],
      ];
      $dds_add = $ddshop->add($dds_data);
      $dds_add1 = $ddshop1->add($dds_data);
      $dds_add2 = $ddshop2->add($dds_data);
      if(!$dds_add || !$dds_add1 || !$dds_add2) die('2');
    }
    // 修改优惠券
    $adata['id'] = $row['ccid'];  
    $adata['yong'] = 2;
    $c = $cc->save($adata);
    $c1 = $cc1->save($adata);
    $c2 = $cc2->save($adata);
    if(!$c || !$c1 || !$c2) die('2');
    //清空购物车
    $a = $q_shopcar->where("id={$row['id']}")->delete();
    $a1 = $q_shopcar1->where("id={$row['id']}")->delete();
    $a2 = $q_shopcar2->where("id={$row['id']}")->delete();
    $b = $q_sgoods->where("carid={$row['id']}")->delete();
    $b1 = $q_sgoods1->where("carid={$row['id']}")->delete();
    $b2 = $q_sgoods2->where("carid={$row['id']}")->delete();
    if(!$a || !$a1 || !$a2 || !$b || !$b1 || !$b2) die('2');

    echo 1;
  }

  //用户退出
  public function utui(){
    cookie('id',null); 
  }

  //电子菜单首页
  public function dzcd(){
    $uid=usersId();    //用户id
    $sid = $_COOKIE['4373433CA7C70528'];  //堂食店铺

    $shop = D('eng_shop');
    $tftype = D('eng_tftype');
    $dzcd = D('eng_dzcd');
    $row=$shop->field('name,headpic,sming,pic')->where("id={$sid}")->find();
    //分类
    $rrow = $tftype->field('name,id')->where("sid={$sid}")->select();
    foreach ($rrow as $key => $value) {
      $rrow[$key]['food'] = $dzcd->field('id,cainame,pliao,xl,guige,price,headpic')->where("ftypeid={$value['id']}")->select();
      foreach ($rrow[$key]['food'] as $k => $v) {
        $xin = time()-$v['time'];
        if($xin<604800) $rrow[$key]['food'][$k]['type'] =1;
        else $rrow[$key]['food'][$k]['type'] =2;
      }
      unset($rrow[$key]['id']);
    }
    $row['lei'] = $rrow;
    //热销
    $row['rx'] = $dzcd->field('id,cainame,pliao,xl,guige,price,headpic')->where("sid={$sid} AND rx=1")->select();
    echo json_encode($row);
    // dump($row);
  }

  //查看电子订单 规格
  public function dz_gge(){
    $arr=json_decode(file_get_contents('php://input'));
    $ip = $arr->ip;  //菜的ip
    // $id= 2;
    $q_ggetype = D('eng_dz_gge');
    $row= $q_ggetype->field('name,id')->where("pid=0 AND fid={$id}")->select();
    foreach ($row as $key => $value) {
      $rid = $value['id'];
      $row[$key]['lei'] = $q_ggetype->field('name,id,price')->where("pid={$rid}")->select();
      // unset($row[$key]['id']);
    }
    // dump($row);
    echo json_encode($row);
  }

  //查看有规格的电子菜单价格
  public function dzgg_money(){
    $user_id = usersId();  //用户id
    $shop_id = $_COOKIE['4373433CA7C70528']; // 堂食店的id
    $arr=json_decode(file_get_contents('php://input'));
    $cai = $arr->cai;
    $gge = $arr->gge;

/*    $cai = 2;
    $gge =  '4,9,11';*/
    $gge = rtrim($gge,',');

    $ggetype = D('eng_dz_gge');
    $food = D('eng_food');
    $gge_row = explode(',', $gge);
    //基础价
    $jichu = $food->where("id={$cai}")->find()['price'];
    foreach ($gge_row as $key => $value) {
      $jia = $ggetype->where("id={$value}")->find()['price'];
      $jichu+=$jia;
    }
    echo $jichu;
  }


  //电子菜单修改购物车
  public function dz_ggwc(){
    $user_id = usersId();  //用户id
    $shop_id = $_COOKIE['4373433CA7C70528']; // 堂食店的id
    $zhuo_id = $_COOKIE['98D61E02E7D7EC35']; // 桌的id

    $arr=json_decode(file_get_contents('php://input'));
    $type = $arr->num;  //1加 2减
    $cai = $arr->cai;
    $gge = $arr->gge;

    $q_shopcar = D('eng_dz_shopcar');
    $q_shopcar1 = D('dz_shopcar');
    $q_shopcar2 = D('pipi_dz_shopcar');
    $q_sgoods = D('eng_dz_sgoods');
    $q_sgoods1 = D('dz_sgoods');
    $q_sgoods2 = D('pipi_dz_sgoods');
    $q_users = D('eng_users');
    $row= $q_shopcar->where("uid={$user_id} AND sid={$shop_id} AND zhuo={$zhuo_id}")->find();
    $carid= $row['id']; 
    $error = true;
    if($row){  //有这个店铺 且这个桌
      $raow = $q_sgoods->where("fid={$cai} AND carid={$carid} AND gge='{$gge}'")->find();  //有没有这道菜
      if($raow){  //有这道菜
        if($type==2 && $raow['num']==1){//数量为0 删掉这个菜
          $a = $q_sgoods->where("fid={$cai} AND carid={$carid} AND gge='{$gge}'")->delete(); 
          $a1 = $q_sgoods1->where("fid={$cai} AND carid={$carid} AND gge='{$gge}'")->delete(); 
          $a2 = $q_sgoods2->where("fid={$cai} AND carid={$carid} AND gge='{$gge}'")->delete(); 
          if(!$a1 || !$a2 || !$a) $error = false;
        }else{
          // 菜有有规格
          $gg = $raow['gge'];
          if($gge==0 || $gge==$gg){  //没有规格的菜  或者 菜的规格有了  征程修改
            $num = $raow['num'];
            if($type==1) $num++;
            else $num--;
            $data['num'] = $num;
            $data['gge'] = $gge;
            $data['id'] = $raow['id'];
            $rbow = $q_sgoods->save($data);
            $rbow1 = $q_sgoods1->save($data);
            $rbow2 = $q_sgoods2->save($data);
            if(!$rbow || !$rbow1 || !$rbow2) $error = false;
          }else{    //没有这个规格  添加菜
            $data['num'] = 1;
            $data['fid'] = $cai;
            $data['gge'] = $gge;
            $data['carid'] = $carid;
            $rbow = $q_sgoods->add($data);
            $rbow1 = $q_sgoods1->add($data);
            $rbow2 = $q_sgoods2->add($data);
            if(!$rbow || !$rbow1 || !$rbow2) $error = false;
          }
        }
      }else{     //没有这道菜
        $data['num'] = 1;
        $data['fid'] = $cai;
        $data['gge'] = $gge;
        $data['carid'] = $carid;
        $rbow = $q_sgoods->add($data);
        $rbow1 = $q_sgoods1->add($data);
        $rbow2 = $q_sgoods2->add($data);
        if(!$rbow || !$rbow1 || !$rbow2) $error = false;
      }
    }else{     //没有这个店铺 添加购物车店铺
      $data['uid'] = $user_id;
      $data['sid'] = $shop_id;
      $data['zhuo'] = $zhuo_id;
      $data['dzid'] = $q_users->where("id = {$user_id}")->find()['dzid'];
      $row = $q_shopcar->add($data);
      $row1 = $q_shopcar1->add($data);
      $row2 = $q_shopcar2->add($data);
      if($row && $row1 && $row2){  //添加菜
        $ddata['num'] = 1;
        $ddata['fid'] = $cai;
        $ddata['gge'] = $gge;
        $ddata['carid'] = $row;
        $rrow = $q_sgoods->add($ddata);
        $rrow1 = $q_sgoods1->add($ddata);
        $rrow2 = $q_sgoods2->add($ddata);
        if(!$rrow || !$rrow1 || !$rrow2) $error = false;
      }else $error = false;
    }
    //判断返回
    if($error) echo 1;
    else echo 2;
  }



  //电子订单查看购物车  小车
  public function dz_kgwc(){
    $user_id = usersId();  //用户id
    $shop_id = $_COOKIE['4373433CA7C70528']; // 堂食店的id
    $zhuo_id = $_COOKIE['98D61E02E7D7EC35']; // 桌的id

    $q_model = D();
    $row = $q_model->query("select g.num,dz.cainame,g.fid,dz.price,g.gge from eng_dz_shopcar c,eng_dz_sgoods g,eng_dzcd dz where c.uid={$user_id} AND c.sid={$shop_id} AND c.zhuo={$zhuo_id} AND c.id=g.carid AND g.fid=dz.id");

    $all = 0;
    foreach ($row as $key => $value) {
      if($value['gge']!=0){ // 有规格的价格不一样

        $gge = rtrim($value['gge'],',');

        $ggetype = D('eng_ggetype');
        $gge_row = explode(',', $gge);

        foreach ($gge_row as $k => $v) {
          $type_row = $ggetype->where("id={$v}")->find();
          $jia = $type_row['price'];
          $value['price'] += $jia;
          $lei = $type_row['name'];
          $row[$key]['cainame'] .= "[".$lei."]";
        }
      }

      $row[$key]['ji'] = $value['num']*$value['price'];
      $all += $row[$key]['ji'];
      unset($row[$key]['price']);
    }
    $row['all'] =$all;
    // dump($row);
    echo json_encode($row);
  }


  //电子菜单购物车  大车
  public function dz_dgwc(){
    $user_id = usersId();  //用户id
    $shop_id = $_COOKIE['4373433CA7C70528']; // 堂食店的id

    $q_model = D();
    $q_users = D('eng_users');
    $q_shdz = D('eng_shdz');
    $ggetype = D('eng_dz_gge');
    $shopcar = D('eng_dz_shopcar');
    $shopcar1 = D('dz_shopcar');
    $shopcar2 = D('pipi_dz_shopcar');
    /*$q_cc = D('eng_cc');
    $q_hd = D('eng_hd');*/
    $m_shop = D('eng_shop');
    // $m_shop = D('eng_m_shop');
    $rarow = $m_shop->field('name,headpic')->where("id={$shop_id}")->find();
    $row['name'] = $rarow['name'];
    $row['song'] = $rarow['song'];
    $gogo = $rarow['gogo'];

    $row['food'] = $q_model->query("select g.num,dz.cainame,g.fid,dz.price,g.gge from eng_dz_shopcar c,eng_dz_sgoods g,eng_dzcd dz where c.uid={$user_id} AND c.sid={$shop_id} AND c.zhuo={$zhuo_id} AND c.id=g.carid AND g.fid=dz.id");
    
    $all = 0;
    foreach ($row['food'] as $key => $value) {
      if($value['gge']!=0){ // 有规格的价格不一样
        $gge = rtrim($value['gge'],',');
        $gge_row = explode(',', $gge);
        foreach ($gge_row as $k => $v) {
          $type_row = $ggetype->where("id={$v}")->find();
          $jia = $type_row['price'];
          $value['price'] += $jia;
          $lei = $type_row['name'];
          $row['food'][$key]['cainame'] .= "[".$lei."]";
        }
      }
      $row['food'][$key]['ji'] = $value['num']*$value['price'];
      $all += $row['food'][$key]['ji'];
      unset($row['food'][$key]['price']);
    }
    
    
   
    // 实际付款
    $ddata['zong'] = $all;
    $ddata['id'] = $roow['id'];
    $shopcar->save($ddata);
    $shopcar1->save($ddata);
    $shopcar2->save($ddata);
    // dump($row);

    $newtime = (date("Y-m-d H:i:s",time()));
    // $headpic = $food->field('headpic')->where("id={$shop_id}")->find()['headpic'];
    $row['ok'] = [

      'money' => $all,
      'time' => $newtime,
      'headpic' => $rarow['headpic'],
    ];
    // echo json_encode($ok);
    echo json_encode($row);
  }








  // 删除地址
  public function del_address(){
    $user_id = usersId();  //用户id
    $arr=json_decode(file_get_contents('php://input'));
    $id = $arr->id;
    // $id =  '4,9,11,';
    $id = rtrim($id,',');

    $shdz = D('eng_shdz');
    $shdz1 = D('shdz');
    $shdz2 = D('pipi_shdz');
    $id_row = explode(',', $id);
    foreach ($id_row as $key => $value) {
      $error = $shdz->where("id={$value}")->delete();
      $error1 = $shdz1->where("id={$value}")->delete();
      $error2 = $shdz2->where("id={$value}")->delete();
      if(!$error || !$error1 || !$error2) die('2');
    }
    echo '1';
  }


















  //验证银行卡
  public function card(){
    require_once './API/curl.func.php';

/*    $arr=json_decode(file_get_contents('php://input'));
    $num = $arr->num;
    $type = $arr->type;
    $id = $_COOKIE['4373433CA7C70528'];*/

    $appcode = '1c28262f77684e9db881ee51536dcc44';//appcode
    $bankcard = '6230910199045742174';//银行卡
    $idcard = '211321199805108617';//身份证
    $realname = '刘思邈';//姓名 utf8
    $realname = urlencode($realname);
    $mobile = '17624086614';

    $cfg['header'][] = 'Authorization:APPCODE '.$appcode;

    $result = curlOpen("http://jisubank4.market.alicloudapi.com/bankcardverify4/verify?bankcard=$bankcard&idcard=$idcard&mobile=$mobile&realname=$realname", $cfg);

    $jsonarr = json_decode($result, true);
    if($jsonarr['status'] != 0)
    {
        echo $jsonarr['msg'];
        exit();
    }

    $result = $jsonarr['result'];
    echo $jsonarr;
    //echo $result['bankcard'].' 1'.$result['realname'].' 2'.$result['mobile'].' 3'.$result['idcard'].'<br />';
    echo $result['verifystatus'];//.' '.$result['verifymsg'].'<br />';  
  }



  public function kcard(){
    require_once './API/curl.func.php';

    $appcode = '1c28262f77684e9db881ee51536dcc44';//appcode
    $bankcard = '6230910199045742173';//银行卡 8位 10位
    // $idcard = '211321199805108617';//身份证
    // $realname = '刘思邈';//姓名 utf8
    // $realname = urlencode($realname);
    // $mobile = '17624086614';

    $cfg['header'][] = 'Authorization:APPCODE '.$appcode;

    $result = curlOpen("http://api43.market.alicloudapi.com/api/c43?bankcard=$bankcard", $cfg);

    $jsonarr = json_decode($result, true);
    if($jsonarr['status'] != 0)
    {
        echo $jsonarr['msg'];
        exit();
    }

    $result = $jsonarr['result'];
    // echo $jsonarr;
    dump($jsonarr);
    echo $jsonarr['error_code'];
    //echo $result['bankcard'].' 1'.$result['realname'].' 2'.$result['mobile'].' 3'.$result['idcard'].'<br />';
    echo $result['verifystatus'];
  }

  //用户订单总览
  public function kddan(){


  }

  public function ooa(){

    echo time(); 
    echo "<br/>";
    echo $san = time()-(3600*24*3);

  }









}