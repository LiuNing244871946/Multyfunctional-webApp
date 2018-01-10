<?php
namespace Home\Controller;
use Think\Controller;
use Aliyun\Core\Config; 
use Aliyun\Core\Profile\DefaultProfile; 
use Aliyun\Core\DefaultAcsClient; 
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;
class FoodsController extends CommonController {
	// 店铺首页
    public function index(){
        $id = $_COOKIE['4373433CA7C70528'];
        $q_dian = D('shop');
        $q_tc = D('tc');
        $q_shop = D('m_shop');
      	$q_shoppic = D('shoppic');

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
        $q_shoppic = D('shoppic');
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
        $q_tc = D('tc');
        $q_tcx = D('tc_x');
        $q_gze = D('gze');
        // $row = $q_tc->where("id={$tcan}")->find();/
        $row = $q_model->query("select t.*,s.name from tc t,shop s where s.id=t.sid and t.id={$tcan} and tftype=0")[0];
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

      $m_shop = D('m_shop');
    	$q_food = D('food');
    	$q_hd = D('hd');
      $q_ftype = D('ftype');
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
      $q_ggetype = D('ggetype');
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
      $m_shoppic = D('m_shoppic');
      $m_wspic = D('wspic');
      echo time();


    }

    


    // 外卖商家的评论内容
    public function mai_ping(){
        $arr=json_decode(file_get_contents('php://input'));
        $num = $arr->num;
        $type = $arr->type;
        $id = $_COOKIE['C057DF743DCFDA2C'];

        $q_model = D();
        $q_pjpic = D('pjpic');
        if($type==1){
          $xin = "ORDER BY p.dj desc";
        }
        if($type==2){
          $xin = "ORDER BY p.ptime desc";
        }
        if($type==3){
          $tu = "AND p.pics = 2";
        } 
        if($type==4){
          $xin = "ORDER BY p.dj asc";
        } 
        $pl = $q_model->query("select p.*,u.username from pj p,users u,ddan d where p.did = d.id and d.sid = {$id} and p.uid = u.id and d.ztai = 4 AND d.mai = 1 {$tu} {$xin} limit {$num},6");
        
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

        $q_model = D();
        $q_pjpic = D('pjpic');
        $xin='';
        $tu ='';
        if($type==1){
          $xin = "ORDER BY p.dj desc";
        }
        if($type==2){
          $xin = "ORDER BY p.ptime desc";
        }
        if($type==3){
          $tu = "AND p.pics = 2";
        }
        if($type==4){
          $xin = "ORDER BY p.dj asc";
        } 
        $pl = $q_model->query("select p.id,p.dj,p.pics,p.ptime,p.nrong,u.headpic,u.username from pj p,users u,ddan d where p.did = d.id and d.sid = {$id} and p.uid = u.id and d.ztai = 4 AND d.mai = 2 {$tu} {$xin} limit {$num},6");
        
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
      $q_users = D('users');
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
        $q_food = D('food');
        $model = D('');
        $row = $q_food->field('cainame,headpic,m_xl,zhekou,guige,pliao,m_ping')->where("id={$id}")->find();

        $roww = $model->query("select s.num,s.fid from shopcar c,sgoods s where c.uid={$uid} AND c.sid={$sid} AND c.id=s.carid");
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
        $q_food = D('dzcd');
        $model = D('');
        $row = $q_food->field('cainame,headpic,m_xl,zhekou,guige,pliao,m_ping')->where("id={$id}")->find();

        $roww = $model->query("select s.num,s.fid from dz_shopcar c,dz_sgoods s where c.uid={$uid} AND c.sid={$sid} AND c.id=s.carid");
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
        $q_shdz = D('shdz');
        $users = D('users');
        $name = $_COOKIE['id'];
        $row = $users->field('id,dzid')->where("name = {$name}")->find();
        $shdz_row = $q_shdz->where("uid=".$row['id'])->select();
        $shdz_row['dzid'] = $row['dzid'];

        echo json_encode($shdz_row);
    }

      // 外卖购物车收货地址
    public function m_address(){
        $q_shdz = D('shdz');
        $shopcar = D('shopcar');
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
        $q_address = D('shdz');
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
        $q_address = D('shdz');
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
        }else{      //修改
          $rrow = $q_address->where("id={$id}")->find();
          if($rrow['linkman']==$linkman && $rrow['sex']==$sex && $rrow['phone']==$phone && $rrow['address && ']==$address && $rrow['jing']==$jing && $rrow['wei']==$wei && $rrow['xiaddress']==$xiaddress) die('1');
            $data['id'] = $id;
            $row = $q_address->save($data);
        }
        if($row) echo '1';
        else echo '2';
    }

    // 验证原密码密码
    public function change_password(){
        $name = $_COOKIE['id'];
        $arr=json_decode(file_get_contents('php://input'));
        $password = $arr->pass;
        $pass = md5($password);
        $q_users = D('users');
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
        $q_user = D('users');
        $q_user->where("name={$name}")->save($data);
        if($q_user){
            cookie('id',null);
            echo 1;
        }else{
            echo 2;
        }
    }
    //会员中心
    public function me(){
        $user_id = $_COOKIE['id'];
        $q_user = D('users');
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
        $q_cc = D('cc');
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

      $q_cc = D('cc');
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
          $q_users = D('users');
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
        $q_pma = D('pma');
        $data['ma'] = $ma;
        $data['time'] = time();
        $row = $q_pma->where("phone=".$phone)->find();
        if($row){
          // $data['id'] = $row['id'];
          $cun = $q_pma->where("phone = {$phone}")->save($data);
        }else{
          $data['phone'] = $phone;
          $cun = $q_pma->add($data);
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
      $q_pma = D('pma');
      $q_users = D('users');

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
                  if($q_row) echo 1;  //修改成功
                  else echo 4;  //修改失败
                }
            }else echo 5; //验证时间大于5分钟 验证码失效
        }else echo 2;  //验证码错误

    }
    
    // 验证原手机号
    public function yuanp(){
      $arr=json_decode(file_get_contents('php://input'));
      $ma = $arr->ma;

      $q_pma = D('pma');
      $q_users = D('users');
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

    


    // 套餐或菜评价
    public function tcan_ping(){

        $arr=json_decode(file_get_contents('php://input'));
        $num = $arr->num;
        $type = $arr->type;
        $mai = $arr->mai;
        $id = $arr->id;

        $q_model = D();
        $q_pjpic = D('pjpic');

        if($type==1) $xin = "ORDER BY p.dj desc";
        if($type==2) $xin = "ORDER BY p.ptime desc";
        if($type==3) $tu = "AND p.pics = 2";
        if($type==4) $xin = "ORDER BY p.dj asc";                         
        $pl = $q_model->query("select p.id,p.dj,p.pics,p.ptime,p.nrong,u.headpic,u.username from ddshop dd,ddan d,pj p,users u where dd.ddid = d.id and d.id = p.did and p.uid = u.id and dd.sid = {$id} and d.mai = {$mai} {$tu} {$xin} limit {$num},6");
        
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

    //外卖满减
    public function mjian(){
        $id= 1;

        $q_hd = D('hd');
        $row = $q_hd->where("sid = {$id}")->select();
        // dump($row);
        echo json_encode($row);
    }
    //再查看订单
    public function kandd(){
        $arr=json_decode(file_get_contents('php://input'));
        $id = $arr->id;
        $q_model = D();
        $row = $q_model->query("select t.tcname,t.oldprice,t.tcprice,s.name from shop s,tc t where t.id={$id} and s.id=t.sid")[0];
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

        $q_ddan = D("ddan");
        $q_ddshop = D("ddshop");
        $q_tc = D("tc");
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
        // ddshop表添加数据
        if(!$row) die('2');
        $ddta['sid'] = $id;
        $ddta['ddid'] = $row;
        $ddta['num'] = $num;
        $ddta['money'] = $show_tc['tcprice']*$num;
        $ddta['name'] = $show_tc['tcname'];
        $rrow = $q_ddshop->add($ddta);
        if(!$rrow) die('2');
        //减库存
        $datt['stock'] = $yu;
        $datt['id'] = $id;
        $ok = $q_tc->save($datt);
        if(!$ok) die('2');
        echo $row;
    }


    // 买家确认外卖收货
    public function shou(){
        $id = 4;
        $q_ddan = D('ddan');
        $s_ddan = D('s_ddan');
        $row = $q_ddan->where("id={$id}")->find();
        // dump($row);
        $error = true;
        if($row['ztai'] ==6){
          $data['id'] = $id;
          $data['ztai'] = 3;
          $rowa = $q_ddan->save($data);
          if(!$rowa) $error = false;

          $dataa['ztai'] = 4;
          $rowaa = $s_ddan->where("did={$id}")->save($dataa);
          if(!$rowaa) $error = false;
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

        $q_ddan = D('ddan');
        $s_ddan = D('s_ddan');
        $row = $q_ddan->where("id={$id}")->find();
        // dump($row);
        $error = true;
        if($row['ztai'] ==3 || $row['ztai'] ==2){
            $data['id'] = $id;
            $data['ztai'] = 5;
            $data['type'] = $type;
            $data['why'] = $why;
            $rowa = $q_ddan->save($data);
            if(!$rowa) $error = false;

            $dataa['ztai'] = 6;
            $rowaa = $s_ddan->where("did={$id}")->save($dataa);
            if(!$rowaa) $error = false;
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

      $ddan = D('ddan');
      $model = D();
      $row = $ddan->where("id={$id}")->find();
      if($row['uid']!=$user_id || $row['sid']!=$shop_id) die('2');  //不匹配
      $rrow = $model->query("select s.headpic,d.time,t.tcprice from ddan d,ddshop dd,tc t,shop s where d.id={$id} AND d.sid=s.id AND dd.ddid=d.id AND dd.sid=t.id")[0];
      
      $rrow['id']=$row['time'].$row['id'];
      $rrow['time'] = date("Y-m-d H:i:s",$rrow['time']);
      echo json_encode($rrow);
    }


    // 堂食付款成功  生成二维码
    public function mama(){
        $id = 10; //ddid 的 id


        $q_mama = D('mama');
        $q_ddan = D('ddan');
        $t_ddan = D('t_ddan');
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
        if($ztt && $rr){
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
			      if($row) echo 1;
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
        $q_pma = D('pma');
        $q_users = D('users');
        $q_yer = D('yer');

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
              $name = 123;
              while ($name==123 || in_array($name,$namea)) {
                  $name = rand(00000000,99999999);
                    if(strlen($name)!=8){
                        $name = str_pad($name,8,"0",STR_PAD_LEFT);
                  }
              }
              $username = createRandomStr(10);
              $data['phone'] = $phone;
              $pass = md5($pass);
              $data['pass'] = $pass;
              $data['name'] = $name;
              $data['state'] = 1;
              $data['username'] =$username;
              $ab = $q_users->add($data);
              // 余额表生成信息
              $yer['uid'] = $ab;
              $yer['yuan'] = 0;
              $yer['new'] = 0;
              $yer['time'] = time();
              $yer['sming'] = 3;
              $abc = $q_yer->add($yer);
              if($ab && $abc) echo 1;
              else echo 5;  // 注册失败
          }else echo 4; //验证码超时
        }else echo 3; //验证码不正确
          // echo time();
    }

  // 用户头像上传
  public function upic(){
      $arr=json_decode(file_get_contents('php://input'));
      $img = $arr->img;

      $q_users = D('users');
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
          if($rrow) echo 1;  //修改成功
          else echo 2;  //修改失败
      }else echo 3; //登录超超时
      
  }


  // 用户修改性别  昵称
  public function sex(){
      $arr=json_decode(file_get_contents('php://input'));
      $type = $arr->type;
      $zhi = $arr->zhi;

      $q_users = D('users');
      $name = $_COOKIE['id'];

       $rrow = $q_users->where("name={$name}")->find();
      if($type == 1){ //改性别
        if($rrow['sex']!=$zhi){
          $data['sex'] = $zhi;
          $row = $q_users->where("name={$name}")->save($data);
          if($row) echo 1;
          else echo 2;
        }else echo 1;
      }else{          // 改昵称
         if($rrow['name']!=$zhi){
          $data['username'] = $zhi;
          $row = $q_users->where("name={$name}")->save($data);
          if($row) echo 1;
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

    $ggetype = D('ggetype');
    $food = D('food');
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
    $row = $q_model->query("select g.num,f.cainame,g.fid,f.zhekou,g.gge from shopcar c,sgoods g,food f where c.uid={$user_id} AND c.sid={$shop_id} AND c.id=g.carid AND g.fid=f.id");

    $all = 0;
    foreach ($row as $key => $value) {
      if($value['gge']!=0){ // 有规格的价格不一样

        $gge = rtrim($value['gge'],',');

        $ggetype = D('ggetype');
        $food = D('food');
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
    $q_users = D('users');
    $ggetype = D('ggetype');
    $shopcar = D('shopcar');
    $q_cc = D('cc');
    $q_shdz = D('shdz');
    $q_hd = D('hd');
    $m_shop = D('m_shop');
    // $m_shop = D('m_shop');
    $rarow = $m_shop->field('name,song,gogo,headpic')->where("id={$shop_id}")->find();
    $row['name'] = $rarow['name'];
    $row['song'] = $rarow['song'];
    $gogo = $rarow['gogo'];

    $row['food'] = $q_model->query("select g.num,f.cainame,f.zhekou,g.gge from shopcar c,sgoods g,food f where c.uid={$user_id} AND c.sid={$shop_id} AND c.id=g.carid AND g.fid=f.id");
    
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

    $q_shopcar = D('shopcar');
    $q_sgoods = D('sgoods');
    $q_users = D('users');
    $row= $q_shopcar->where("uid={$user_id} AND sid={$shop_id}")->find();
    $carid= $row['id']; 
    $error = true;
    if($row){  //有这个店铺 
      $raow = $q_sgoods->where("fid={$cai} AND carid={$carid} AND gge='{$gge}'")->find();  //有没有这道菜
      if($raow){  //有这道菜
        if($type==2 && $raow['num']==1){//数量为0 删掉这个菜
          $q_sgoods->where("fid={$cai} AND carid={$carid} AND gge='{$gge}'")->delete(); 
          if(!$q_sgoods) $error = false;
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
            if(!$rbow) $error = false;
          }else{    //没有这个规格  添加菜
            $data['num'] = 1;
            $data['fid'] = $cai;
            $data['gge'] = $gge;
            $data['carid'] = $carid;
            $rbow = $q_sgoods->add($data);
            if(!$rbow) $error = false;
          }
        }
      }else{     //没有这道菜
        $data['num'] = 1;
        $data['fid'] = $cai;
        $data['gge'] = $gge;
        $data['carid'] = $carid;
        $rbow = $q_sgoods->add($data);
        if(!$rbow) $error = false;
      }
    }else{     //没有这个店铺 添加购物车店铺
      $data['uid'] = $user_id;
      $data['sid'] = $shop_id;
      $data['dzid'] = $q_users->where("id = {$user_id}")->find()['dzid'];
      $row = $q_shopcar->add($data);
      if($row){  //添加菜
        $ddata['num'] = 1;
        $ddata['fid'] = $cai;
        $ddata['gge'] = $gge;
        $ddata['carid'] = $row;
        $rrow = $q_sgoods->add($ddata);
        if(!$rrow) $error = false;
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
    $shopcar = D('shopcar');
    $rrow = $shopcar->where("uid={$user_id} AND sid={$shop_id}")->find();
    if($type==1){
      if($rrow['dzid']==$id) die('1');
      $data['dzid'] = $id;
    }else{
      $data['ccid'] = $id;
      if($rrow['ccid']==$id) die('1');
    }
    $row = $shopcar->where("uid={$user_id} AND sid={$shop_id}")->save($data);
    if($row) echo '1';
    else echo '2';
  }

  //清空购物车
  public function che_mei(){
    $user_id = usersId();  //用户id
    $shop_id = $_COOKIE['C057DF743DCFDA2C']; // 外卖店的id

    $shopcar = D('shopcar');
    $sgoods = D('sgoods');
    $id = $shopcar->where("uid={$user_id} AND sid={$shop_id}")->find()['id'];
    $a = $shopcar->where("id={$id}")->delete();

    $b = $sgoods->where("carid={$id}")->delete();
    if($a && $b) echo 1;
    else  echo 2;
  }

  //外卖生成订单
  public function dan(){
    $user_id = usersId();  //用户id
    $shop_id = $_COOKIE['C057DF743DCFDA2C']; // 外卖店的id

    $q_shopcar = D('shopcar');
    $q_sgoods = D('sgoods');
    $ggetype = D('ggetype');
    $shdz = D('shdz');
    $dddz = D('dddz');
    $ddan = D('ddan');
    $ddshop = D('ddshop');
    $cc = D('cc');
    $q_model = D();

    $row= $q_shopcar->where("uid={$user_id} AND sid={$shop_id}")->find();
    $carid = $row['id'];
    $g_row = $q_model->query("select s.*,f.cainame,f.zhekou from sgoods s,food f where f.id=s.fid AND s.carid={$carid}");

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
    
    $dz_add = $dddz->add($dz_row);
    if(!$dz_add) die('2');
    //添加ddan
    $dd_data = [
      'uid' => $user_id,
      'sid' => $shop_id,
      'time' => time(),
      'you' => $row['zong'],
      'ztai' => 2,
      'see' => 1,
      'mai' => 1,
      'zhu' => $zhu,
      'dzid' => $dz_add,
    ];

    $dd_add = $ddan->add($dd_data);
    if(!$dd_add) die('2');
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
      if(!$dds_add) die('2');
    }
    echo 1;
   /* //修改优惠券为使用  **********************支付成功再改***************************************************
    $adata['id'] = $row['ccid'];  
    $adata['yong'] = 2;
    $c = $cc->save($adata);
    if(!$c) die('2');
    //清空购物车
    $a = $q_shopcar->where("id={$row['id']}")->delete();
    $b = $q_sgoods->where("carid={$row['id']}")->delete();
    if(!$a || !$b) die('2');*/
    
  }

  //用户退出
  public function utui(){
    cookie('id',null); 
  }

  //电子菜单首页
  public function dzcd(){
    $uid=usersId();    //用户id
    $sid = $_COOKIE['4373433CA7C70528'];  //堂食店铺

    $shop = D('shop');
    $tftype = D('tftype');
    $dzcd = D('dzcd');
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
    $q_ggetype = D('dz_gge');
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

    $ggetype = D('dz_gge');
    $food = D('food');
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

    $q_shopcar = D('dz_shopcar');
    $q_sgoods = D('dz_sgoods');
    $q_users = D('users');
    $row= $q_shopcar->where("uid={$user_id} AND sid={$shop_id} AND zhuo={$zhuo_id}")->find();
    $carid= $row['id']; 
    $error = true;
    if($row){  //有这个店铺 且这个桌
      $raow = $q_sgoods->where("fid={$cai} AND carid={$carid} AND gge='{$gge}'")->find();  //有没有这道菜
      if($raow){  //有这道菜
        if($type==2 && $raow['num']==1){//数量为0 删掉这个菜
          $q_sgoods->where("fid={$cai} AND carid={$carid} AND gge='{$gge}'")->delete(); 
          if(!$q_sgoods) $error = false;
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
            if(!$rbow) $error = false;
          }else{    //没有这个规格  添加菜
            $data['num'] = 1;
            $data['fid'] = $cai;
            $data['gge'] = $gge;
            $data['carid'] = $carid;
            $rbow = $q_sgoods->add($data);
            if(!$rbow) $error = false;
          }
        }
      }else{     //没有这道菜
        $data['num'] = 1;
        $data['fid'] = $cai;
        $data['gge'] = $gge;
        $data['carid'] = $carid;
        $rbow = $q_sgoods->add($data);
        if(!$rbow) $error = false;
      }
    }else{     //没有这个店铺 添加购物车店铺
      $data['uid'] = $user_id;
      $data['sid'] = $shop_id;
      $data['zhuo'] = $zhuo_id;
      $data['dzid'] = $q_users->where("id = {$user_id}")->find()['dzid'];
      $row = $q_shopcar->add($data);
      if($row){  //添加菜
        $ddata['num'] = 1;
        $ddata['fid'] = $cai;
        $ddata['gge'] = $gge;
        $ddata['carid'] = $row;
        $rrow = $q_sgoods->add($ddata);
        if(!$rrow) $error = false;
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
    $row = $q_model->query("select g.num,dz.cainame,g.fid,dz.price,g.gge from dz_shopcar c,dz_sgoods g,dzcd dz where c.uid={$user_id} AND c.sid={$shop_id} AND c.zhuo={$zhuo_id} AND c.id=g.carid AND g.fid=dz.id");

    $all = 0;
    foreach ($row as $key => $value) {
      if($value['gge']!=0){ // 有规格的价格不一样

        $gge = rtrim($value['gge'],',');

        $ggetype = D('ggetype');
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
    $q_users = D('users');
    $q_shdz = D('shdz');
    $ggetype = D('dz_gge');
    $shopcar = D('dz_shopcar');
 /*   $q_cc = D('cc');
    $q_hd = D('hd');*/
    $m_shop = D('shop');
    // $m_shop = D('m_shop');
    $rarow = $m_shop->field('name,headpic')->where("id={$shop_id}")->find();
    $row['name'] = $rarow['name'];
    $row['song'] = $rarow['song'];
    $gogo = $rarow['gogo'];

    $row['food'] = $q_model->query("select g.num,dz.cainame,g.fid,dz.price,g.gge from dz_shopcar c,dz_sgoods g,dzcd dz where c.uid={$user_id} AND c.sid={$shop_id} AND c.zhuo={$zhuo_id} AND c.id=g.carid AND g.fid=dz.id");
    
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

    $shdz = D('shdz');
    $id_row = explode(',', $id);
    foreach ($id_row as $key => $value) {
      $error = $shdz->where("id={$value}")->delete();
      if(!$error) die('2');
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

      /*$User = D('users');
      $row = $User->where('id=3 or id=4')->delete(); 
      dump($row);
      if($row) echo 1;
      else echo 2;*/

    // $gge =  '4,9,11,';
    // $gge = rtrim($gge,',');
    // echo $gge;

     /* $user_id = 26;
      $shop_id = 1;
      $time = time();
      $q_cc = D('cc');
      $count = $q_cc->where("((uid={$user_id} AND name=1) or name=2) AND yong=1 AND stop>{$time} AND sid={$shop_id}")->count();
      echo $count;*/
$str= "data:image/jpeg;base64,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";

header('Content-type:text/html;charset=utf-8');
$base64_image_content = $str;
//匹配出图片的格式
if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
$type = $result[2];
$new_file = "/upload/active/img/".date('Ymd',time())."/";
if(!file_exists($new_file))
{
//检查是否有该文件夹，如果没有就创建，并给予最高权限
mkdir($new_file, 0700);
echo 123;
}
$new_file = $new_file.time().".{$type}";
if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))){
echo '新文件保存成功：', $new_file;
}else{
echo '新文件保存失败';
}
}


// echo "<img src='../STATIC/img/add.png'>";

}









}