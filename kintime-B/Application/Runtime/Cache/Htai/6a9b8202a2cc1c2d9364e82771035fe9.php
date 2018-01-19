<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>登录页面</title>
<link rel="stylesheet" href="/kintime-B/Public/ht/css/style.default.css" type="text/css" />
<script type="text/javascript" src="/kintime-B/Public/ht/js/plugins/jquery-1.7.min.js"></script>
<script type="text/javascript" src="/kintime-B/Public/ht/js/plugins/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="/kintime-B/Public/ht/js/plugins/jquery.cookie.js"></script>
<script type="text/javascript" src="/kintime-B/Public/ht/js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="/kintime-B/Public/ht/js/custom/general.js"></script>
<script type="text/javascript" src="/kintime-B/Public/ht/js/custom/index.js"></script>
<script src="/kintime-B/Public/ht/js/jquery-1.8.3.min.js"></script>
<!--[if IE 9]>
    <link rel="stylesheet" media="screen" href="/kintime-B/Public/ht/css/style.ie9.css"/>
<![endif]-->
<!--[if IE 8]>
    <link rel="stylesheet" media="screen" href="/kintime-B/Public/ht/css/style.ie8.css"/>
<![endif]-->
<!--[if lt IE 9]>
	<script src="/kintime-B/Public/ht/js/plugins/css3-mediaqueries.js"></script>
<![endif]-->
</head>

<body class="loginpage">
	<div class="loginbox">
    	<div class="loginboxinner">
        	
            <div class="logo">
            	<h1 class="logo"><span>kintime</span></h1>
				<span class="slogan">后台管理系统</span>
            </div><!--logo-->
            
            <br clear="all" /><br />
            
            <div class="nousername">
				<div class="loginmsg">账号或密码不正确.</div>
            </div><!--nousername-->
            
            <div class="nopassword">
				<div class="loginmsg">密码不正确66.</div>
                <div class="loginf">
                    <div class="thumb"><img alt="" src="/kintime-B/Public/ht/images/thumbs/avatar1.png" /></div>
                    <div class="userlogged">
                        <h4 class="old"></h4>
                        <a href="index.html">其他账户?</a> 
                    </div>
                </div><!--loginf-->
            </div><!--nopassword-->
            
            <form id="login" action="dashboard.html" method="post">
            	
                <div class="username">
                	<div class="usernameinner">
                    	<input type="text" name="username" id="username" />
                    </div>
                </div>
                
                <div class="password">
                	<div class="passwordinner">
                    	<input type="password" name="password" id="password" />
                    </div>
                </div>
                
                <button class="tjiao">登录</button>
                
               
            
            </form>
            
        </div><!--loginboxinner-->
    </div><!--loginbox-->


</body>
</html>
<script>
$('.tjiao').click(function() {
    var oldname = $('#username').val();
    var oldpass = $('#password').val();
    $.post('<?php echo U('ajax_go');?>',{'oldname':oldname,'oldpass':oldpass},function(data){
        if(data == "哇哈哈"){
            //alert(123);
            location.href="<?php echo U('layout/layout');?>";
        }else{
            $('.nousername').css('display','block');
        }
    })
    /*$('.old').html(oldname);
    $('.nopassword').css('display','block');
    $('.username').css('display','none');*/
    return false;
})

    


</script>