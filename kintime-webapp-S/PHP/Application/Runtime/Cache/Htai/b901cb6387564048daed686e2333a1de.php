<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>控制台页面</title>
<link rel="stylesheet" href="/kintime-webapp/kintime/Public/ht/css/style.default.css" type="text/css" />
<script type="text/javascript" src="/kintime-webapp/kintime/Public/ht/js/plugins/jquery-1.7.min.js"></script>
<script type="text/javascript" src="/kintime-webapp/kintime/Public/ht/js/plugins/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="/kintime-webapp/kintime/Public/ht/js/plugins/jquery.cookie.js"></script>
<script type="text/javascript" src="/kintime-webapp/kintime/Public/ht/js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="/kintime-webapp/kintime/Public/ht/js/plugins/jquery.flot.min.js"></script>
<script type="text/javascript" src="/kintime-webapp/kintime/Public/ht/js/plugins/jquery.flot.resize.min.js"></script>
<script type="text/javascript" src="/kintime-webapp/kintime/Public/ht/js/plugins/jquery.slimscroll.js"></script>
<script type="text/javascript" src="/kintime-webapp/kintime/Public/ht/js/custom/general.js"></script>
<script type="text/javascript" src="/kintime-webapp/kintime/Public/ht/js/custom/dashboard.js"></script>
<script type="text/javascript" src="/kintime-webapp/kintime/Public/ht/js/jquery-1.8.3.min.js"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="/kintime-webapp/kintime/Public/ht/js/plugins/excanvas.min.js"></script><![endif]-->
<!--[if IE 9]>
    <link rel="stylesheet" media="screen" href="css/style.ie9.css"/>
<![endif]-->
<!--[if IE 8]>
    <link rel="stylesheet" media="screen" href="css/style.ie8.css"/>
<![endif]-->
<!--[if lt IE 9]>
    <script src="/kintime-webapp/kintime/Public/ht/js/plugins/css3-mediaqueries.js"></script>
<![endif]-->
<style>
    .vernav2{
        top:60px;
    }
</style>
</head>

<body class="withvernav">
<div class="bodywrapper">
    <div class="topheader">
        <div class="left">
            <h1 class="logo">Kintime</h1>
            <span class="slogan">后台管理系统</span>
            
            
            
            <br clear="all" />
            
        </div><!--left-->
        
        <div class="right">
            <!--<div class="notification">
                <a class="count" href="ajax/notifications.html"><span>9</span></a>
            </div>-->
            <div class="userinfo">
                <img src="/kintime-webapp/<?php echo ($rowmm["headpic"]); ?>" width="20" height="20">
                <span><?php echo ($rowmm['username']); ?></span>
            </div><!--userinfo-->
            
            <div class="userinfodrop">
                <div class="avatar">
                    <a href=""><img src="/kintime-webapp/<?php echo ($rowmm["headpic"]); ?>" width="95" height="95"></a>
                    
                </div><!--avatar-->
                <div class="userdata">
                    <h4><?php echo ($rowmm['name']); ?></h4>
                    <span class="email"><?php echo ($rowmm['email']); ?></span>
                    <ul>
                        <li><a href="editprofile.html">编辑资料</a></li>
                        <li><a href="accountsettings.html">账号设置</a></li>
                        <li><a href="help.html">帮助</a></li>
                        <li><a href="<?php echo U('index/tui');?>">退出</a></li>
                    </ul>
                </div><!--userdata-->
            </div><!--userinfodrop-->
        </div><!--right-->
    </div><!--topheader-->
    
    
    
    
    <div class="vernav2 iconmenu">
        <ul>
            <li><a href="#formsub" class="editor">用户管理</a>
                <span class="arrow"></span>
                <ul id="formsub">
                    <li><a href="<?php echo U('user/q_user');?>">我的用户</a></li>
                    <li><a href="<?php echo U('user/h_user');?>">后台管理员</a></li>
                    <li><a href="<?php echo U('user/hi_qx');?>">权限组</a></li>
                </ul>
            </li>
            <li><a href="<?php echo U('ddgl/max_show');?>" class="gallery">订单管理</a></li>
            <li><a href="<?php echo U('juan/juanzi');?>" class="elements">优惠券</a></li>
            <!-- <li><a href="widgets.html" class="widgets">网页插件</a></li>
            <li><a href="calendar.html" class="calendar">日历事件</a></li>
            <li><a href="<?php echo U('shdz/index');?>" class="support">收货地址</a></li>
            <li><a href="typography.html" class="typo">文字排版</a></li>
            <li><a href="tables.html" class="tables">数据表格</a></li>
            <li><a href="buttons.html" class="buttons">按钮 &amp; 图标</a></li>
 -->
            <li><a href="#error" class="error">美食</a>
                <span class="arrow"></span>
                <ul id="error">
                    <li><a href="<?php echo U('shop/index');?>">商铺管理</a></li>
                    <li><a href="<?php echo U('stype/index');?>">商铺总分类</a></li>
                    <li><a href="<?php echo U('food/index');?>">菜单管理</a></li>
                    <li><a href="<?php echo U('ftype/index');?>">菜品分类管理</a></li>
                </ul>
            </li>

            <li><a href="#addons" class="addons">其他页面</a>
                <span class="arrow"></span>
                <ul id="addons">
                    <li><a href="newsfeed.html">新闻订阅</a></li>
                    <li><a href="profile.html">资料页面</a></li>
                    <li><a href="productlist.html">产品列表</a></li>
                    <li><a href="photo.html">图片视频分享</a></li>
                    <li><a href="gallery.html">相册</a></li>
                    <li><a href="invoice.html">购物车</a></li>
                </ul>
            </li>
        </ul>
       
        <br /><br />
    </div><!--leftmenu-->
    <div class="centercontent">
        

        <div class="pageheader">
            <h1 class="pagetitle">订单详情修改</h1>

        </div><!--pageheader-->

            <div id="validation" class="subcontent" >
                
                    <form id="form1" class="stdform" method="post" action="<?php echo U('kan_show');?>" enctype="multipart/form-data">
                    <input type='hidden' name="id" id="firstname" style="width:30%" class="longinput" value="<?php echo ($row["id"]); ?>" />
                        <p>
                          <label>订&nbsp;&nbsp;&nbsp;单&nbsp;&nbsp;&nbsp;号</label>
                            <span class="field"><input type="text" id="email" class="longinput" style="width:30%" value="<?php echo ($row["id"]); ?>" disabled /></span>
                        </p>
                        <p>
                          <label>用&nbsp;&nbsp;&nbsp;户&nbsp;&nbsp;&nbsp;名</label>
                            <span class="field"><input type="text" id="email" class="longinput" style="width:30%" value="<?php echo ($row["uid"]); ?>" disabled /></span>
                        </p>
                        <p>
                          <label>店&nbsp;&nbsp;&nbsp;铺&nbsp;&nbsp;&nbsp;名</label>
                            <span class="field"><input type="text" id="email" class="longinput" style="width:30%" value="<?php echo ($row["sid"]); ?>" disabled /></span>
                        </p>
                        <p>
                          <label>订&nbsp;单&nbsp;时&nbsp;间</label>
                            <span class="field"><input type="text" id="email" class="longinput" style="width:30%" value="<?php echo ($row["time"]); ?>" disabled /></span>
                        </p>
                        <p>
                          <label>订&nbsp;单&nbsp;商&nbsp;品</label>
                            <span class="field"><input type="text" id="email" class="longinput" style="width:30%" value="<?php echo ($row["food"]); ?>" disabled /></span>
                        </p>
                        <p>
                          <label>原价</label>
                            <span class="field"><input type="text" id="email" class="longinput" style="width:30%" value="<?php echo ($row["yuan"]); ?>" disabled /></span>
                        </p>
                        <p>
                          <label>折扣价</label>
                            <span class="field"><input type="text" id="email" class="longinput" style="width:30%" value="<?php echo ($row["you"]); ?>" disabled /></span>
                        </p>
                        <p>
                            <label>订&nbsp;单&nbsp;状&nbsp;态</label>
                             <span class="field">
                             <select size="1" style='min-width:20%' name="ztai">
                                
                                <option  value="1" <?php echo ($row['ztai']=='1'?'selected':''); ?>>待付款</option>
                                <option  value="2" <?php echo ($row['ztai']=='2'?'selected':''); ?>>待使用</option>
                                <option  value="3" <?php echo ($row['ztai']=='3'?'selected':''); ?>>待评价</option>
                                <option  value="4" <?php echo ($row['ztai']=='4'?'selected':''); ?>>退款/售后</option>

                                
                             </select>
                             </span>
                        </p>
                        <p>
                            <label>是&nbsp;否&nbsp;可&nbsp;见</label>
                             <span class="field">
                             <select size="1" style='min-width:20%' name="see">
                                
                                <option  value="1" <?php echo ($row['see']=='1'?'selected':''); ?>>可见</option>
                                <option  value="2" <?php echo ($row['see']=='2'?'selected':''); ?>>隐藏</option>

                                
                             </select>
                             </span>
                        </p>
                        <br />
                        
                       <p class="stdformbutton">
                        <button class="submit radius2" >
                          &nbsp;&nbsp;&nbsp;<font size='5px'>修&nbsp;&nbsp;&nbsp;&nbsp;改</font>&nbsp;&nbsp;&nbsp;
                        </button>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                       </p> 
                       
                    </form>

            </div><!--subcontent-->
        
    
</div>

    
    </div>  
    </div><!-- centercontent -->
    
    
</div><!--bodywrapper-->

</body>
</html>
<script>
    
</script>