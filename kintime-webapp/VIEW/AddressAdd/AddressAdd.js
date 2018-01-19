$(function(){
	language();
	if(!$.fn.cookie('id')) {
		window.location.href = '../Login/Login.html';
	};
	$('#name').on('input',function(){
		$('#tip5').remove();
		if(!$(this).val()){
			if($('#tip1').length){
				$('#tip1 .text-con').text('联系人不能为空');
			}else{
				var tip = '<span class="tip-text" id="tip1"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">联系人不能为空</span></span>';
				$('#tip').append(tip);
			};
		}else{
			$('#tip1').remove();
		};
	});
	$('#phone').on('input',function(){
		$('#tip5').remove();
		var phone = $(this).val();
		var phoneArea = document.getElementById('area-code').selectedIndex;
		if((phone.length !== 11&&phoneArea === 0)||(phone.length !== 11&&phoneArea === 1)){
			if($('#tip2').length){
				$('#tip2 .text-con').text('手机号格式不正确');
			}else{
				var tip = '<span class="tip-text" id="tip2"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">手机号格式不正确</span></span>';
				$('#tip').append(tip);
			};
		}else{
			$('#tip2').remove();
		};
	});
	$('.sex-con').on('tap',function(){
		$('.sex-con').removeClass('select');
		$(this).addClass('select');
	});
//	$('#address0').on('input',function(){
//		$('#tip5').remove();
//		if(!$(this).val()){
//			if($('#tip3').length){
//				$('#tip3 .text-con').text('地址不能为空');
//			}else{
//				var tip = '<span class="tip-text" id="tip3"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">地址不能为空</span></span>';
//				$('#tip').append(tip);
//			};
//		}else{
//			$('#tip3').remove();
//		};
//	});
	$('.address-select').on('tap',function(){
		window.location.href='../AddressMap/AddressMap.html';
	});
	$('#address').on('input',function(){
		$('#tip5').remove();
		if(!$(this).val()){
			if($('#tip4').length){
				$('#tip4 .text-con').text('详细地址不能为空');
			}else{
				var tip = '<span class="tip-text" id="tip4"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">详细地址不能为空</span></span>';
				$('#tip').append(tip);
			};
		}else{
			$('#tip4').remove();
		};
	});
	$('.determine').on('tap',function(){
		if(!$('#name').val()||!$('#phone').val()||!$('#address').val()||$('.tip-text').length){
			if($('#tip5').length){
				$('#tip5 .text-con').text('联系信息有误，请重新填写');
			}else{
				var tip = '<span class="tip-text" id="tip5"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">联系信息有误，请重新填写</span></span>';
				$('#tip').append(tip);
			};
		}else{
			var data={};
			data.id=0;
			data.name=$('#name').val();
			if($('.sex-con.select').text()==='先生'){
				data.sex=1;
			}else{
				data.sex=0;
			};
			data.phone=$('#area-code').val()+$('#phone').val();
			data.address=$('#address0').val();
			data.xiaddress=$('#address').val();
			data.jing=30.2684079898;
			data.wei=120.2283668518;
			var jsonStr = JSON.stringify(data);
			console.log(data);
			$.ajax({
				type: "post",
				url: "../../PHP/home/foods/add_change",
				async: true,
				contentType: 'application/x-www-form-urlencoded',
				data: jsonStr,
				dataType: "json",
				success:function(data){
					if(data===1){
						history.back(-1);
					}else{
						alert('添加地址失败，请重试');
					}
				},
				error:function(e){
					console.log(e);
				}
			});
		};
	});
	$('.icon-fanhui').on('tap',function(){
		history.back(-1);
	});
})
