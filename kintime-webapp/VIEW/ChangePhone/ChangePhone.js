$(function() {
	language();
	if($.fn.cookie('id')) {
		$.ajax({
			type: "post",
			url: "../../PHP/home/foods/me",
			async: true,
			contentType: 'application/x-www-form-urlencoded',
			dataType: "json",
			success: function(data) {
				$('#oldphone').val(data.phone);
			},
			error: function(e) {
				console.log(e);
			}
		});
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
			if($('#sms').val() !== '' &&!$('#oldpage .tip-text').length) {
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
					data:jsonStr,
					success: function(data){
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
	} else {
		window.location.href = '../Login/Login.html';
	};
	$('.icon-fanhui').on('tap',function(){
		history.back(-1);
	});
})