<?php
namespace Htai\Controller;
use Think\Controller;
class UserController extends CommonController {
    // 前台用户总览
    public function q_user(){
        //搜索条件
        if(!empty($_GET['search'])){
            $search = $_GET['search'];
            $map = " name like '%{$search}%' OR phone like '%{$search}%' ";
        }

        $q_user = D('users');
        $count = $q_user->where($map)->count();
        $Page = new \Think\Page($count,I('get.pnum',10));
        $row = $q_user->order('id desc')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();
        foreach ($row as $k => $v) {
            if($v['state']== 1){
                $row[$k]['state']='正常';
            }elseif($v['state']== 2){
                $row[$k]['state']='禁用';
            }
            /***************************/
        }

        
        $show = $Page->show();// 分页显示输出

        $this->assign('show',$show);

        $this->assign('row',$row);
        $this->display();
    }

    //前台用户详情  禁用
    public function q_userkan(){
        $q_user = D('users');
        if(IS_GET){
            // $row = $q_user->where('id='.$_GET['id'])->select()[0];
            $row = $q_user->query("select u.*,y.new,y.time from users u,yer y where y.uid = u.id and u.id={$_GET['id']} order by y.time desc limit 1")[0];
            // dump($row);
            
            
                /***************************/
                switch ($row['type']) {
                    case 1:
                        $row['atype']='普通用户';
                        break;
                    
                }
            /**************************************/
            $this->assign('row',$row);
            // dump($row);
            $this->display();

        }else{
           // dump($_POST);
            $q_user->save($_POST);
            echo "<script>location.href='".U('q_user')."'</script>";

        }
    }    

    //后台管理总览
    public function h_user(){
       if(!empty($_GET['search'])){
            $map['name'] = array('like',"%{$_GET['search']}%");
        }

        $q_user = D('gluser');
        $group = D('group');
        $count = $q_user->where($map)->count();
        //$_SESSION['pnum']=$_POST['pnum'];
        $Page = new \Think\Page($count,I('get.pnum',10));
        $row = $q_user->order('id desc')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();


        foreach ($row as $k => $v) {
            $g_row = $group->where('id='.$v['glid'])->select()[0];
            $row[$k]['g_gl']=$g_row['gname'];
        }

        $show = $Page->show();// 分页显示输出
        $this->assign('show',$show);

        $this->assign('row',$row);
        $this->display();
    }


    //后台管理 查看修改
    public function h_userkan(){
        $q_user = D('gluser');
        $group = D('group');
        if(IS_GET){
            $row = $q_user->where('id='.$_GET['id'])->select()[0];
            $g_row = $group->where('id='.$row['glid'])->select()[0];
            $row['glid']=$g_row['gname'];
            $ga_row = $group->select();
            if($row['id']!=1){
                unset($ga_row[0]);
            }
            //

            $this->assign('row',$row);
            $this->assign('ga_row',$ga_row);
            $this->display();

        }elseif(IS_POST){
            $old_pic=$_POST['old_pic'];
            
            if(!empty($_FILES)){

                $upload = new \Think\Upload();// 实例化上传类    
                $upload->maxSize   =     3145728 ;// 设置附件上传大小    
                $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型    
                $upload->savePath  =      './'; // 设置附件上传目录  
                $upload->autoSub = false;  

                // 上传文件     
                $info   =   $upload->upload();   
                if($info) {// 上传成功
                    unlink("./Uploads/".$old_pic); 
                    $pic_name = $info['pic']['savename'];
                    $_POST['headpic']= "kintime/Uploads/".$pic_name;
                }
                
            }
                unset($_POST['old_pic']);
                $q_user->save($_POST);
                echo "<script>location.href='".U('h_user')."'</script>";
            

        }
    }    
    // 管理员添加
    public function hadd_user(){
        if(IS_POST){
            ////////////******************正则*************///
            //确认密码
            unset($_POST['qr_pass']);
            $upload = new \Think\Upload();// 实例化上传类    
            $upload->maxSize   =     3145728 ;// 设置附件上传大小    
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型    
            $upload->savePath  =      './'; // 设置附件上传目录  
            $upload->autoSub = false;  

            // 上传文件     
            $info   =   $upload->upload();   
            if($info) {// 上传成功
                $pic_name = $info['pic']['savename'];
                $_POST['headpic']=$pic_name;
            }
            $q_user = D('gluser');
            //密码md5加密
            $_POST['pass'] = md5($_POST['pass']);
            //执行添加
            $q_user->add($_POST);
            echo "<script>location.href='".U('h_user')."'</script>";
        }else{
            $group = D('group');
            $ga_row = $group->select();
            $this->assign('ga_row',$ga_row);
            $this->display();
        }

    }

    // 权限组总览
    public function hi_qx(){
        if(!empty($_GET['search'])){
            $map['gname'] = array('like',"%{$_GET['search']}%");
        }
        $group = D('group');
        $g_user = D('gluser');
        $count = $group->where($map)->count();
        $Page = new \Think\Page($count,I('get.pnum',10));
        //$g_row = $group->select();
        $g_row = $group->order('id desc')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();
        //dump($g_row);
        foreach ($g_row as $k => $v) {
            $g_row[$k]['count'] = $g_user->where('glid='.$v['id'])->count();
        }
        
        //dump($g_row);
        $this->assign('g_row',$g_row);
        $this->display();
    }
    public function hi_qxkan(){
        if(IS_POST){
            //处理页
            $m = D('gx');
            
            $m->where('gid='.$_POST['id'])->delete();
            foreach($_POST['name'] as $k=>$v){
                $arr = ['gid'=>$_POST['id'],'pdes'=>$v];
                $m->add($arr);
            }
            echo "<script>location.href='".U('hi_qx')."'</script>";
        }else{
            $m = D('gx');
            $row = $m->where('gid='.$_GET['id'])->select();
            $g = D('power');
            $grow = $g->select();
            $arr = array();
            foreach ($row as $k => $v) {
                $arr[] = $v['pdes'];
            }
            foreach ($grow as $k => $v) {
                if(in_array($v['pname'],$arr)){
                    $grow[$k][ch] = 'checked';
                }
            }
            $this->assign('grow',$grow);
            $this->display();

        }
    }
    // 权限组删除
    public function hi_qxdel(){
        $group = D('group');
        $g_gx = D('gx');
        $group->where('id='.$_GET['id'])->delete();
        $g_gx->where('gid='.$_GET['id'])->delete();
        echo "<script>location.href='".U('hi_qx')."'</script>";

    }

    // 后台管理员删除
    public function h_userdel(){
        $gluser = D('gluser');
        // 查 管理员头像 删掉
        $row = $gluser->where('id='.$_GET['id'])->select()[0];
        unlink("./Uploads/".$row['headpic']);
        $gluser->where('id='.$_GET['id'])->delete();
        echo "<script>location.href='".U('h_user')."'</script>";

    }
    // 权限组添加
    public function hiadd_qx(){
        if(IS_POST){
            //dump($_POST);
            $group = D('group');
            
            //$group->data($data)->add();
            $g_row = $group->where("gname='{$_POST['zuname']}'")->select();
            //dump($g_row);
            if(!empty($g_row)){
                echo "飞流直下三千尺";
            }else{
                $gname = $_POST['zuname'];
                $data['gname'] = htmlspecialchars($gname);
                $add_id = $group->add($data);
                echo $add_id;
            }
        }else{
            $this->display();
        }
    }
    // 收货地址
    public function q_shdz(){
        $q_shdz = D('shdz');
        $q_user = D('users');

        $q_name = $q_user->where('id='.$_GET['id'])->find();
        // dump($q_name);

        $q_row = $q_shdz->where('uid='.$_GET['id'])->select();
        foreach ($q_row as $k => $v) {
            if ($v['id']==$q_name['dzid']) {
                array_unshift($q_row, $v);
                unset($q_row[$k+1]);
            }
        }
        // dump($q_row);
        
        $this->assign('q_row',$q_row);
        $this->assign('q_name',$q_name);
        $this->display();
    }

    // 余额明细
    public function q_mingxi(){
        // dump($_GET);
        $q_yer = D('yer');
        $q_user = D('users');
        $q_name = $q_user->where('id='.$_GET['id'])->select()[0];
        $count = $q_yer->count();
        $Page = new \Think\Page($count,I('get.pnum',15));

        $row = $q_yer->order("time desc")->where("uid=".$_GET['id'])->limit($Page->firstRow.','.$Page->listRows)->select();
        foreach ($row as $k => $v) {
            $row[$k]['time'] = date("Y-m-d H:i:s",$v['time']);
            $cha = $v['new']-$v['yuan'];
            switch ($v['sming']) {
                case 1:
                    $row[$k]['sming'] = "银行卡充值  ".$cha;
                    break;
                case 2:
                    $row[$k]['sming'] = "银行卡体现 ".$cha;
                    break;
                case 3:
                    $row[$k]['sming'] = "创建账号";
                    break;
            }
        }
        // dump($row);
        $show = $Page->show();// 分页显示输出
        $this->assign('show',$show);
        $this->assign('row',$row);
        $this->assign('q_name',$q_name);
        $this->display();

    }








}