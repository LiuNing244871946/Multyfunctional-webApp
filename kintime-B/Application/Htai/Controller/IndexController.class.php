<?php
namespace Htai\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        


       $this->display();
    }

    public function ajax_go(){
    	//if(IS_POST){
	    	$name = $_POST['oldname'];
	    	$pass = md5($_POST['oldpass']);
        	$guser = D('gluser');
        	$user_row = $guser->where("name= '{$name}' and pass = '{$pass}'")->select()[0];
        	if(!empty($user_row)){
                $_SESSION['uid_id']=$user_row['id'];
        		echo "哇哈哈";
        	}
       // }
    }
    public function tui(){
        unset($_SESSION['uid_id']);
        echo "<script>location.href='".U('index')."'</script>";
    }















}