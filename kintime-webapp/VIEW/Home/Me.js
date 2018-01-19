$(function(){
	if($.fn.cookie('id')){
		$.ajax({
			type: "post",
			url: "../../PHP/home/foods/me",
			async: true,
			contentType: 'application/x-www-form-urlencoded',
			dataType: "json",
			success:function(data){
				$('.user-info .img-con img').attr('src','.'+data.headpic);
				$('.user-name').text(data.username);
				$('.number-con').text(data.phone);
			},
			error:function(e){
				console.log(e);
			}
		});
	}else{
		$('.user-name').text('登录');
		$('.number-con').text('请先登录~');
	};
	$('.user-info').on('tap',function(){
		window.location.href='../UserSetting/UserSetting.html';
	});
	$('#wallet').on('tap',function(){
		window.location.href='../Account/Account.html';
	});
	$('#kin').on('tap',function(){
		window.location.href='../Kin/Kin.html';
	});
	$('#address').on('tap',function(){
		window.location.href='../AddressManage/AddressManage.html';
	});
	$('#coupon').on('tap',function(){
		window.location.href='../Coupon/coupon.html';
	});
	$('#language').on('tap',function(){
		$('#discount-con').css('visibility','visible');
		$('#language-con').show();
	});
	switch($.fn.cookie('lan')){
		case 'zh':
			$('.language-item').removeClass('selected');
			$('#zh').addClass('selected');
			break;
		case 'lao':
			$('.language-item').removeClass('selected');
			$('#lao').addClass('selected');
			break;
		case 'en':
			$('.language-item').removeClass('selected');
			$('#en').addClass('selected');
			break;
		default:
			$('.language-item').removeClass('selected');
			$('#zh').addClass('selected');
			break;
	}
	$('.language-item').on('tap',function(){
		$('.language-item').removeClass('selected');
		$(this).addClass('selected');
		var tex = $(this).find('.text-con').text();
		switch(tex){
			case '中文':
				tex='zh';
				break;
			case 'ລາວ':
				tex='lao';
				break;
			case 'English':
				tex='en';
				break;
		};
		var exp=new Date();
		exp.setTime(exp.getTime()+60*1000*60*24*30*12);
		$.fn.cookie('lan',tex,{path:'/',expires:exp});
		$('#discount-con').css('visibility','hidden');
		$('.discount-item').hide();
		language();
	});
})
