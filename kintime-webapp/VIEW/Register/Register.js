$(function(){
	$('#phone').on('input',function(){
		var phone = $(this).val();
		var phoneArea = document.getElementById('area-code').selectedIndex;
		if((phone.length !== 11&&phoneArea === 0)||(phone.length !== 11&&phoneArea === 1)){
			if($('#tip1').length){
				$('#tip1 .text-con').text('手机号格式不正确');
			}else{
				var tip = '<span class="tip-text" id="tip1"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">手机号格式不正确</span></span>';
				$('#tip').append(tip);
			};
		}else{
			$('#tip1').remove();
		};
	});
	$('#phone').on('input',function(){
		var phone = $(this).val();
		var phoneArea = document.getElementById('area-code').selectedIndex;
		if((phone.length === 11&&phoneArea === 0)||(phone.length === 11&&phoneArea === 1)){
			if($('#send-sms .time-text').css('display')==='none'){
				$('#send-sms').removeClass('disable');
			};
		};
	});
	$('#sms').on('input',function(){
		var sms = $(this).val();
		if(sms.length !== 6){
			if($('#tip4').length){
				$('#tip4 .text-con').text('验证码格式不正确');
			}else{
				var tip = '<span class="tip-text" id="tip4"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">验证码格式不正确</span></span>';
				$('#tip').append(tip);
			};
		}else{
			$('#tip4').remove();
		};
	});
	$('#password1').on('input',function(){
		var passW = $(this).val();
		var r = /[0-9][a-z]/ig;
		if(passW.length<8||passW.length>16||!r.test(passW)){
			$(this).parent().addClass('error');
			if($('#tip2').length){
				$('#tip2 .text-con').text('请确认密码在8~16位且同时包含字母和数字');
			}else{
				var tip = '<span class="tip-text" id="tip2"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">请确认密码在8~16位且同时包含字母和数字</span></span>';
				$('#tip').append(tip);
			};
		}else{
			$(this).parent().removeClass('error');
			$('#tip2').remove();
		};
		if($('#password2').val()!==''){
			var passW2 = $('#password2').val();
			var passW1 = $(this).val();
			if(passW1 !== passW2){
				$(this).parent().addClass('error');
				if($('#tip3').length){
					$('#tip3 .text-con').text('输入密码不一致');
				}else{
					var tip = '<span class="tip-text" id="tip3"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">输入密码不一致</span></span>';
				$('#tip').append(tip);
				};
			}else{
				$(this).parent().removeClass('error');
				$('#tip3').remove();
			};
		};
	});
	$('#password2').on('input',function(){
		var passW1 = $('#password1').val();
		var passW2 = $(this).val();
		if(passW1 !== passW2){
			$(this).parent().addClass('error');
			if($('#tip3').length){
				$('#tip3 .text-con').text('输入密码不一致');
			}else{
				var tip = '<span class="tip-text" id="tip3"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">输入密码不一致</span></span>';
			$('#tip').append(tip);
			};
		}else{
			$(this).parent().removeClass('error');
			$('#tip3').remove();
		}
	});
//	按钮
	$('#phone,#sms,#password1,#password2').on('input',function(){
		$('#tip5').remove();
		if($('#phone').val() !== ''&&$('#sms').val() !== ''&&$('#password1').val() !== ''&&$('#password2').val() !== ''&&$('#password1').val() === $('#password2').val()&&!$('.tip-text').length){
			$('.register-btn').removeClass('disabled');
		}else{
			$('.register-btn').attr('class','register-btn disabled');
		};
	});
	$('.register-btn').on('tap',function(){
		if(!$(this).hasClass('disabled')){
			var data = {};
			data.phone = $('#area-code').val()+$('#phone').val();
			data.ma = $('#sms').val();
			data.pass = $('#password1').val();
			var jsonStr = JSON.stringify(data);
			$.ajax({
				type: "post",
				url: "../../PHP/home/foods/zhu",
				async: true,
				contentType: 'application/x-www-form-urlencoded',
				data: jsonStr,
				dataType: "json",
				success: function(data){
					console.log(data);
					switch(data){
						case 1:window.location.href="../Login/Login.html";
							break;
						case 2:if($('#tip5').length){
									$('#tip5 .text-con').text('手机号已被注册');
								}else{
									var tip = '<span class="tip-text" id="tip5"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">手机号已被注册</span></span>';
									$('#tip').append(tip);
								};
							break;
						case 3:if($('#tip5').length){
									$('#tip5 .text-con').text('验证码不正确');
								}else{
									var tip = '<span class="tip-text" id="tip5"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">验证码不正确</span></span>';
									$('#tip').append(tip);
								};
							break;
						case 4:if($('#tip5').length){
									$('#tip5 .text-con').text('验证码超时');
								}else{
									var tip = '<span class="tip-text" id="tip5"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">验证码超时</span></span>';
									$('#tip').append(tip);
								};
							break;
						case 5:if($('#tip5').length){
									$('#tip5 .text-con').text('注册失败');
								}else{
									var tip = '<span class="tip-text" id="tip5"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">注册失败</span></span>';
									$('#tip').append(tip);
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
	
})
