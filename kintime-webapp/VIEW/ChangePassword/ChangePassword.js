$(function() {
	language();
	if(!$.fn.cookie('id')) {
		window.location.href = '../Login/Login.html';
	};
	var passSwiper = new Swiper('#passSwiper', {
		direction: 'horizontal',
		noSwiping: true,
		onlyExternal: true
	});
	$('#oldpassword').on('input', function() {
		$('#tip2').remove();
		if($('#oldpassword').val() === '') {
			if($('#tip1').length) {
				$('#tip1 .text-con').text('请输入原密码');
			} else {
				var tip = '<span class="tip-text" id="tip1"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">请输入原密码</span></span>';
				$('#tips1-con').append(tip);
			};
		} else {
			$('#tip1').remove();
		}
	})
	$('#next1').on('tap', function() {
		if($('#oldpassword').val() === '') {
			if($('#tip1').length) {
				$('#tip1 .text-con').text('请输入原密码');
			} else {
				var tip = '<span class="tip-text" id="tip1"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">请输入原密码</span></span>';
				$('#tips1-con').append(tip);
			};
		} else {
			$('#tip1').remove();
			var data={};
			data.pass=$('#oldpassword').val();
			var jsonStr = JSON.stringify(data);
			$.ajax({
				type: "post",
				url: "../../PHP/home/foods/change_password",
				async: true,
				contentType: 'application/x-www-form-urlencoded',
				data: jsonStr,
				dataType: "json",
				success:function(data){
					switch(data) {
						case 1:
							passSwiper.slideTo(1, 100, false);
							break;
						case 2:
							if($('#tip2').length) {
								$('#tip2 .text-con').text('原密码验证失败');
							} else {
								var tip = '<span class="tip-text" id="tip2"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">原密码验证失败</span></span>';
								$('#tips1-con').append(tip);
							};
							break;
					}
				},
				error:function(e){
					console.log(e);
				}
			});
		};
	});
	$('#newpassword0').on('input',function(){
		$('#tip5').remove();
		var passW = $(this).val();
		var r = /[0-9][a-z]/ig;
		if(passW.length<8||passW.length>16||!r.test(passW)){
			if($('#tip3').length){
				$('#tip3 .text-con').text('请确认密码在8~16位且同时包含字母和数字');
			}else{
				var tip = '<span class="tip-text" id="tip3"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">请确认密码在8~16位且同时包含字母和数字</span></span>';
				$('#tips2-con').append(tip);
			};
		}else{
			$('#tip3').remove();
		};
		if($('#newpassword1').val()!==''){
			var passW2 = $('#newpassword1').val();
			var passW1 = $(this).val();
			if(passW1 !== passW2){
				if($('#tip4').length){
					$('#tip4 .text-con').text('输入密码不一致');
				}else{
					var tip = '<span class="tip-text" id="tip4"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">输入密码不一致</span></span>';
					$('#tips2-con').append(tip);
				};
			}else{
				$('#tip4').remove();
			};
		};
	});
	$('#newpassword1').on('input',function(){
		$('#tip5').remove();
		var passW1 = $('#newpassword0').val();
		var passW2 = $(this).val();
		if(passW1 !== passW2){
			if($('#tip4').length){
				$('#tip4 .text-con').text('输入密码不一致');
			}else{
				var tip = '<span class="tip-text" id="tip4"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">输入密码不一致</span></span>';
			$('#tips2-con').append(tip);
			};
		}else{
			$('#tip4').remove();
		};
	});
	$('#next2').on('tap',function(){
		if(!$('.tip-text').length){
			var data = {};
			data.pass = $('#newpassword0').val();
			var jsonStr = JSON.stringify(data);
			$.ajax({
				type: "post",
				url: "../../PHP/home/foods/change_password2",
				async: true,
				contentType: 'application/x-www-form-urlencoded',
				data: jsonStr,
				dataType: "json",
				success: function(data){
					console.log(data);
					switch(data){
						case 1:window.location.href="../ChangePassSuccess/ChangePhoneSuccess.html";
							break;
						case 2:if($('#tip5').length){
									$('#tip5 .text-con').text('密码修改失败');
								}else{
									var tip = '<span class="tip-text" id="tip5"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">密码修改失败</span></span>';
									$('#tips2-con').append(tip);
								};
							break;
					}
				},
				error: function(e) {
					console.log(e);
				}
			});
		}else{
			return false;
		};
	});
	$('.icon-fanhui').on('tap',function(){
		history.back(-1);
	});
})