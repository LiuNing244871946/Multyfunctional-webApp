<?php
namespace Htai\Controller;
use Think\Controller;
class AaaController extends CommonController {
    // 前台用户总览
    public function q_user(){
        if(IS_POST){
            $upload = new \Think\Upload();// 实例化上传类    
            $upload->maxSize   =     3145728 ;// 设置附件上传大小    
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型 
            $upload->savePath  =      '../../abc/'; // 设置附件上传目录  
            $upload->autoSub = false;  

            // 上传文件     
            $info   =   $upload->upload();   
            if(!$info) {// 上传错误提示错误信息        
                $this->error($upload->getError()); 
            }else{// 上传成功        
                $this->success('上传成功！');    
            }
        }else{
            
            $this->display();
        }


    }








}