$(function() {
	$('#newphone').on('input', function() {
		var phone = $(this).val();
		var phoneArea = document.getElementById('area-code').selectedIndex;
		if((phone.length !== 11 && phoneArea === 0) || (phone.length !== 11 && phoneArea === 1)) {
			if($('#tip2').length) {
				$('#tip2 .text-con').text('手机号格式不正确');
			} else {
				var tip = '<span class="tip-text" id="tip2"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">手机号格式不正确</span></span>';
				$('#tips2-con').append(tip);
			};
		} else {
			$('#tip2').remove();
		};
	});
	$('#newphone').on('input', function() {
		var phone = $(this).val();
		var phoneArea = document.getElementById('area-code').selectedIndex;
		if((phone.length === 11 && phoneArea === 0) || (phone.length === 11 && phoneArea === 1)) {
			if($('#newsend-sms .time-text').css('display') === 'none') {
				$('#newsend-sms').removeClass('disable');
			};
		};
	});
	$('#newsms').on('input', function() {
		var sms = $(this).val();
		if(sms.length !== 6) {
			if($('#tip3').length) {
				$('#tip3 .text-con').text('验证码格式不正确');
			} else {
				var tip = '<span class="tip-text" id="tip3"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">验证码格式不正确</span></span>';
				$('#tips2-con').append(tip);
			};
		} else {
			$('#tip3').remove();
		};
	});
	$('#newphone,#newsms').on('input', function() {
		$('#tip4').remove();
		if($('#newphone').val() !== '' && $('#newsms').val() !== '' && !$('#newpage .tip-text').length) {
			$('#next-phone2').removeClass('disabled');
		} else {
			$('#next-phone2').attr('class', 'next-btn disabled');
		};
	});
	$('#next-phone2').on('tap', function() {
		if(!$(this).hasClass('disabled')) {
			var data = {};
			data.phone = $('#area-code').val() + $('#newphone').val();
			data.ma = $('#newsms').val();
			var jsonStr = JSON.stringify(data);
			$.ajax({
				type: "post",
				url: "../../PHP/home/foods/gaip",
				async: true,
				contentType: 'application/x-www-form-urlencoded',
				data: jsonStr,
				dataType: "json",
				success: function(data) {
					console.log(data);
					switch(data) {
						case 1:
							window.location.href = "../ChangePhoneSuccess/ChangePhoneSuccess.html";
							break;
						case 2:
							if($('#tip4').length) {
								$('#tip4 .text-con').text('验证码错误');
							} else {
								var tip = '<span class="tip-text" id="tip4"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">验证码错误</span></span>';
								$('#tips2-con').append(tip);
							};
							break;
						case 3:
							if($('#tip4').length) {
								$('#tip4 .text-con').text('手机号已被注册');
							} else {
								var tip = '<span class="tip-text" id="tip4"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">手机号已被注册</span></span>';
								$('#tip').append(tip);
							};
							break;
						case 4:
							if($('#tip4').length) {
								$('#tip4 .text-con').text('修改失败');
							} else {
								var tip = '<span class="tip-text" id="tip4"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">修改失败</span></span>';
								$('#tip').append(tip);
							};
							break;
						case 5:
							if($('#tip4').length) {
								$('#tip4 .text-con').text('验证码失效');
							} else {
								var tip = '<span class="tip-text" id="tip4"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">验证码失效</span></span>';
								$('#tip').append(tip);
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