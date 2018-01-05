<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>大分类</title>
</head>
<body>
<table width="700" border="1">
 <?php if(is_array($row)): foreach($row as $key=>$v): ?><tr>
		<td><a href="<?php echo U('type/stype?id='.$v['id']);?>"><?php echo ($v["name"]); ?></a></td>
	</tr><?php endforeach; endif; ?>
</table>
</body>
</html>