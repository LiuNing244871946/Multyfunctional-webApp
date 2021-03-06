<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>控制台页面</title>
<link rel="stylesheet" href="/kintime-B/Public/ht/css/style.default.css" type="text/css" />
<script type="text/javascript" src="/kintime-B/Public/ht/js/plugins/jquery-1.7.min.js"></script>
<script type="text/javascript" src="/kintime-B/Public/ht/js/plugins/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="/kintime-B/Public/ht/js/plugins/jquery.cookie.js"></script>
<script type="text/javascript" src="/kintime-B/Public/ht/js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="/kintime-B/Public/ht/js/plugins/jquery.flot.min.js"></script>
<script type="text/javascript" src="/kintime-B/Public/ht/js/plugins/jquery.flot.resize.min.js"></script>
<script type="text/javascript" src="/kintime-B/Public/ht/js/plugins/jquery.slimscroll.js"></script>
<script type="text/javascript" src="/kintime-B/Public/ht/js/custom/general.js"></script>
<script type="text/javascript" src="/kintime-B/Public/ht/js/custom/dashboard.js"></script>
<script type="text/javascript" src="/kintime-B/Public/ht/js/jquery-1.8.3.min.js"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="/kintime-B/Public/ht/js/plugins/excanvas.min.js"></script><![endif]-->
<!--[if IE 9]>
    <link rel="stylesheet" media="screen" href="css/style.ie9.css"/>
<![endif]-->
<!--[if IE 8]>
    <link rel="stylesheet" media="screen" href="css/style.ie8.css"/>
<![endif]-->
<!--[if lt IE 9]>
    <script src="/kintime-B/Public/ht/js/plugins/css3-mediaqueries.js"></script>
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
                <img src="/kintime-B/<?php echo ($rowmm["headpic"]); ?>" width="20" height="20">
                <span><?php echo ($rowmm['username']); ?></span>
            </div><!--userinfo-->
            
            <div class="userinfodrop">
                <div class="avatar">
                    <a href=""><img src="/kintime-B/<?php echo ($rowmm["headpic"]); ?>" width="95" height="95"></a>
                    
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
                    <li><a href="<?php echo U('upass/upassshow');?>">查看美食商家账号信息</a></li>
                    <li><a href="<?php echo U('gouwu/gouwushow');?>">查看购物商家账号信息</a></li>
                    <li><a href="<?php echo U('history/index');?>">查看用户搜索历史记录</a></li>
                    <li><a href="<?php echo U('qshou/index');?>">查看骑手信息</a></li>
                    <li><a href="<?php echo U('user/h_user');?>">后台管理员</a></li>
                    <li><a href="<?php echo U('user/hi_qx');?>">权限组</a></li>
                </ul>
            </li>
            <li><a href="<?php echo U('ddgl/max_show');?>" class="gallery">订单管理</a></li>
            <li><a href="<?php echo U('juan/juanzi');?>" class="elements">优惠券</a></li>
            <li><a href="<?php echo U('lunbo/index');?>" class="elements">轮播图管理</a></li>
           
            
            <li><a href="#error" class="error">美食</a>
                <span class="arrow"></span>
                <ul id="error">
                    <li><a href="<?php echo U('shop/index');?>">堂食商铺管理</a></li>
                    <li><a href="<?php echo U('mshop/index');?>">外卖商铺管理</a></li>
                    <li><a href="<?php echo U('bawang/index');?>">霸王餐管理</a></li>
                    <li><a href="<?php echo U('tehui/index');?>">特惠美食管理</a></li>
                    <li><a href="<?php echo U('stype/index');?>">商铺总分类</a></li>
                    <li><a href="<?php echo U('food/index');?>">菜单管理</a></li>
                    <li><a href="<?php echo U('ftype/index');?>">菜品分类管理</a></li>
                </ul>
            </li>

            <li><a href="#abc" class="abc">购物</a>
                <span class="arrow"></span>
                <ul id="abc">
                    <li><a href="<?php echo U('gwshop/index');?>">店铺管理</a></li>
                    <li><a href="<?php echo U('user/h_user');?>">店铺总分类</a></li>
                    <li><a href="<?php echo U('user/hi_qx');?>">权限组</a></li>
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
        

<style>
.dataTables_filter{
    top:77px;
    right:23px;
}
.pagination{
  float:right;
}
.page{
  height:33px;
}
</style>
    <div class="pageheader">
        <h1 class="pagetitle">所有分类 </h1>
       
       <!--  <h5><a href=<?php echo U('stype/add');?> style='float:right'>添加分类&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></h5> -->

    </div><!--pageheader-->
    
    <div id="contentwrapper" class="contentwrapper">
        <form action="<?php echo U('stype/index');?>" method='get'>
         <!-- 搜索框-->
          <div id="dyntable_length" style="padding:4px" class="dataTables_length">
           <a href="<?php echo U('stype/add');?>" class="btn btn_orange btn_flag"><span>添加分类</span></a> 
           <!--  <label style="line-height:100px"><select size="1" style='min-width:10%' name="pnum">
	            <option value="10" <?php echo I('get.pnum')==10?"selected":"" ;?>>10</option>
	            <option value="15" <?php echo I('get.pnum')==15?"selected":"" ;?>>15</option>
	            <option value="30" <?php echo I('get.pnum')==30?"selected":"" ;?>>30</option>
	            <option value="50" <?php echo I('get.pnum')==50?"selected":"" ;?>>50</option>
            </select> 条目</label> -->
            <div class="dataTables_filter" style='width:400px' id="dyntable_filter">
                <label>分类名: <input type="text" name='search' style='width:65%' placeholder="请输入关键字" /></label>
                <input type="submit" value='查找'>
            </div>
           </div>
        </form>
               
                <table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="dyntable">
                    <colgroup>
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th class="head0" style="text-align: center;">ID</th>
                            <th class="head1" style="text-align: center;">分类名</th>
                            <th class="head0" style="text-align: center;">对应的主类号</th>
                            <th class="head1" style="text-align: center;">关系路径</th>
                            <th class="head1" style="text-align: center;">操作</th>
                            
                        </tr>
                    </thead>

                    <tbody>
                     <?php if(is_array($row)): foreach($row as $key=>$v): ?><tr class="gradeX">
                         
                            <td class="center" align="center"><?php echo ($v["id"]); ?></td>
                            <td class="center" align="center"><?php echo ($v["name"]); ?></td>
                            <td class="center" align="center"><?php echo ($v["pid"]); ?></td>
                            <td class="center" align="center"><?php echo ($v["path"]); ?></td>
                    
                    <td class="center" align="center">
                     
            <?php if($v['aa'] == 1): ?><a href="<?php echo U('stype/zladd?id='.$v['id']);?>" class="btn btn2 btn_blue btn_flag"><span>添加子分类</span></a>
             <?php else: ?>
                   <span style="color:red;font-size:20px">不能添加分类！</span><?php endif; ?>
                      <a href="<?php echo U('del?id='.$v['id']);?>" class="btn btn2 btn_blue btn_trash"><span>删除</span></a>
                      <a href="<?php echo U('edit?id='.$v['id']);?>" class="btn btn2 btn_blue btn_link"><span>修改</span></a>
                    </td>
                        </tr><?php endforeach; endif; ?>
                    </tbody>
                </table>
                <div class="dataTables_info" id="dyntable_info">
           		</div>

           <div class="dataTables_paginate paging_full_numbers page" id="dyntable_paginate">
            <?php echo ($show); ?>
           </div>
          </div>
    </div><!--contentwrapper-->


<script>
  aa();
  function aa() {
    $('#error').css('display','block');
  }


</script>

    
    </div>  
    </div><!-- centercontent -->
    
    
</div><!--bodywrapper-->

</body>
</html>
<script>
    
</script>