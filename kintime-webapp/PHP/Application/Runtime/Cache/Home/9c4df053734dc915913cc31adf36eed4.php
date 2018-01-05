<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>外卖下各个分类的商品</title>
</head>
<body>
<table width="700" border="1">
 <?php if(is_array($row)): foreach($row as $key=>$v): ?><tr><!--未改超链接-->
		
		<td><a href="<?php echo U('wmfood/wmindex?id='.$v['id']);?>"><?php echo ($v["name"]); ?></a></td>
		
	
	</tr><?php endforeach; endif; ?>

</table>
</body>
</html>