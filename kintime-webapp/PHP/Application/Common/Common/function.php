<?php
//什么时候用递归  当你感觉 想用循环 但是不知道循环几次的时候 
//封函数 
//循环数组
//数组写if
//if自己调自己
//???  瞎写  
function getArray($arr,$id=0){
	
	$row = [];
	$str = '';
	foreach($arr as $k=>$v){
		if($v['pid']==$id){

			$ppp = D('user');
			//评论人头像
			$ppprow = $ppp->where("name='{$v['uname']}'")->select()[0];
			//session 头像
			$pppprow = $ppp->where("name='{$_SESSION['username']}'")->select()[0];
			$str .= "<ul class='commentList'>";
			
			
				$str .= "<li class='item cl'> <a href='#'><i class='avatar size-L radius'><img src='../../../../Uploads/Uploads/".$ppprow['pic']."'></i></a>";
					$str .= "<div class='comment-main'>";
						$str .= "<header class='comment-header'>";
							$str .= "<div class='comment-meta'>";
								$str .= "<a class='comment-author' href='#'>".$v['uname']."</a>";
							$str .= "</div>";
						$str .= "</header>";
						$str .= "<div class='comment-body'>";
							$str .= "<div >";
								$str .= "<span class='lala' style='float:left'>";
									$str .= $v['nrong'];
								$str .= "</span>";
								if($v['pics']!=0){
									$pp = D('plunpic');
									$pprow = $pp->where('pid='.$v['id'])->select();
									//dump($row);
									foreach($pprow as $k=>$vv){
										$str .= "<img src='../../../../Uploads/Uploads/{$vv['pic']}' width='100' style='float:left;margin-top:20px;'>";
									}
								}
							$str .= "</div>";
						$str .= "<div style='float:right'>";
							$str .= "<button class='hf f-r btn btn-default size-S mt-10' name='3' pid='{$v['id']}'>评论</button>";
						$str .= "</div>";
					$str .= "</div>";

	
				$str .= getArray($arr,$v['id']);
				$str .= "</div>";
			$str .= "</li>";
		$str .= "</ul>";
		}

	}

	
	return $str;
}

function createRandomStr($length){
	$str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';//62个字符
	$strlen = 62;
		while($length > $strlen){
			$str .= $str;
			$strlen += 62;
		}
	$str = str_shuffle($str);
	return substr($str,0,$length);
}

function usersId(){
	$name = $_COOKIE['id'];
	$q_users = D('users');
	$user_row = $q_users->where("name = {$name}")->find();
	return $user_row['id'];
}

?>