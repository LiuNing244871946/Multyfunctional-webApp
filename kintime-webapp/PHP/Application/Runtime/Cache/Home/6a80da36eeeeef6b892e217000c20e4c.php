<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>大分类</title>
</head>
<body>
<table width="1500" border="1">
 <?php if(is_array($row)): foreach($row as $key=>$v): ?><tr>
		<td><?php echo ($v["id"]); ?></td>
		<td><?php echo ($v["cainame"]); ?></td>
		<td><?php echo ($v["price"]); ?></td>
		<td><?php echo ($v["zhekou"]); ?></td>
	<td><img src="/kintime/Public/../Uploads/<?php echo ($v['headpic']); ?>" width="70" height="50"></td>
		<td><?php echo ($v["typeid"]); ?></td>
		<td><?php echo ($v["rx"]); ?></td>
		<td><?php echo ($v["sid"]); ?></td>
		<td><?php echo ($v["stypeid"]); ?> </td>
		<td><?php echo ($v["pliao"]); ?> </td>
		<td><?php echo ($v["xl"]); ?> </td>
		<td><?php echo ($v["kouwei"]); ?> </td>
		<td><?php echo ($v["wendu"]); ?> </td>
		<td><?php echo ($v["guige"]); ?> </td>
		<td><?php echo ($v["wmstate"]); ?></td>
		
	</tr><?php endforeach; endif; ?>
</table>
</body>
</html>