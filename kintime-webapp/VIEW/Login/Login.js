$(function() {
	language();
	$('input').on('input', function() {
		$('#tip1').remove();
		if($('#account').val() !== ''&&$('#password').val() !== '') {
			$('.login-btn').removeClass('disabled');
		} else {
			$('.login-btn').attr('class', 'login-btn disabled');
		};
	});
	$('.login-btn').on('tap', function() {
		if(!$(this).hasClass('disabled')) {
			var data = {};
			data.account = $('#account').val();
			data.pass = $('#password').val();
			var jsonStr = JSON.stringify(data);
			$.ajax({
				type: "post",
				url: "../../PHP/home/foods/dengl",
				async: true,
				contentType: 'application/x-www-form-urlencoded',
				data: jsonStr,
				dataType: "json",
				success: function(data) {
					switch(data) {
						case 1:
							window.location.href = "../Home/Home.html";
							break;
						case 2:
							if($('#tip1').length) {
								$('#tip1 .text-con').text('账号或密码不正确');
							} else {
								var tip = '<span class="tip-text" id="tip1"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">账号或密码不正确</span></span>';
								$('#tip').append(tip);
							};
							break;
						case 3:
							if($('#tip1').length) {
								$('#tip1 .text-con').text('该账号已冻结');
							} else {
								var tip = '<span class="tip-text" id="tip1"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">该账号已冻结</span></span>';
								$('#tip').append(tip);
							};
							break;
						case 4:
							if($('#tip1').length) {
								$('#tip1 .text-con').text('账号不存在');
							} else {
								var tip = '<span class="tip-text" id="tip1"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">账号不存在</span></span>';
								$('#tip').append(tip);
							};
							break;
						case 5:
							if($('#tip1').length) {
								$('#tip1 .text-con').text('账号已登录');
							} else {
								var tip = '<span class="tip-text" id="tip1"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">账号已登录</span></span>';
								$('#tip').append(tip);
							};
							break;
						case 6:
							if($('#tip1').length) {
								$('#tip1 .text-con').text('登录失败');
							} else {
								var tip = '<span class="tip-text" id="tip1"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">登录失败</span></span>';
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
			console.log(0)
			return false;
		}
	});
	$('.icon-fanhui').on('tap',function(){
		history.back(-1);
	});
})