$(function() {
	var phoneSwiper = new Swiper('#phoneSwiper', {
		direction: 'horizontal',
		noSwiping: true,
		onlyExternal: true
	});
	$('#sms').on('input', function() {
		var sms = $(this).val();
		if(sms.length !== 6) {
			if($('#tip').length) {
				$('#tip .text-con').text('验证码格式不正确');
			} else {
				var tip = '<span class="tip-text" id="tip"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">验证码格式不正确</span></span>';
				$('#tips1-con').append(tip);
			};
		} else {
			$('#tip').remove();
		};
	});
	$('#sms').on('input', function() {
		$('#tip1').remove();
		if($('#sms').val() !== '' && !$('#oldpage .tip-text').length) {
			$('#next-phone').removeClass('disabled');
		} else {
			$('#next-phone').attr('class', 'next-btn disabled');
		};
	});
	$('#next-phone').on('tap', function() {
		if(!$(this).hasClass('disabled')) {
			var data = {};
			data.ma = $('#sms').val();
			var jsonStr = JSON.stringify(data);
			$.ajax({
				type: "post",
				url: "../../PHP/home/foods/yuanp",
				async: true,
				contentType: 'application/x-www-form-urlencoded',
				dataType: "json",
				data: jsonStr,
				success: function(data) {
					if(data === 1) {
						$('#tip1').remove();
						phoneSwiper.slideTo(1, 100, false);
					} else if(data === 2) {
						if($('#tip1').length) {
							$('#tip1 .text-con').text('验证码错误');
						} else {
							var tip = '<span class="tip-text" id="tip1"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">验证码错误</span></span>';
							$('#tips1-con').append(tip);
						};
					} else if(data === 3) {
						if($('#tip1').length) {
							$('#tip1 .text-con').text('验证码已过期');
						} else {
							var tip = '<span class="tip-text" id="tip1"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">验证码已过期</span></span>';
							$('#tips1-con').append(tip);
						};
					};
				},
				error: function(e) {
					console.log(e);
				}
			});
		} else {
			return false;
		};

	});
	$('.icon-fanhui').on('tap', function() {
		window.location.href = '../Login/Login.html';
	});
	$('#newpassword0').on('input', function() {
		$('#tip5').remove();
		var passW = $(this).val();
		var r = /[0-9][a-z]/ig;
		if(passW.length < 8 || passW.length > 16 || !r.test(passW)) {
			if($('#tip3').length) {
				$('#tip3 .text-con').text('请确认密码在8~16位且同时包含字母和数字');
			} else {
				var tip = '<span class="tip-text" id="tip3"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">请确认密码在8~16位且同时包含字母和数字</span></span>';
				$('#tips2-con').append(tip);
			};
		} else {
			$('#tip3').remove();
		};
		if($('#newpassword1').val() !== '') {
			var passW2 = $('#newpassword1').val();
			var passW1 = $(this).val();
			if(passW1 !== passW2) {
				if($('#tip4').length) {
					$('#tip4 .text-con').text('输入密码不一致');
				} else {
					var tip = '<span class="tip-text" id="tip4"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">输入密码不一致</span></span>';
					$('#tips2-con').append(tip);
				};
			} else {
				$('#tip4').remove();
			};
		};
	});
	$('#newpassword1').on('input', function() {
		$('#tip5').remove();
		var passW1 = $('#newpassword0').val();
		var passW2 = $(this).val();
		if(passW1 !== passW2) {
			if($('#tip4').length) {
				$('#tip4 .text-con').text('输入密码不一致');
			} else {
				var tip = '<span class="tip-text" id="tip4"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">输入密码不一致</span></span>';
				$('#tips2-con').append(tip);
			};
		} else {
			$('#tip4').remove();
		};
	});
	$('#next2').on('tap', function() {
		if(!$('.tip-text').length) {
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
				success: function(data) {
					console.log(data);
					switch(data) {
						case 1:
							window.location.href = "../Login/Login.html";
							break;
						case 2:
							if($('#tip5').length) {
								$('#tip5 .text-con').text('密码修改失败');
							} else {
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
		} else {
			return false;
		};
	});
})