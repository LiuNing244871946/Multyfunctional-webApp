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
		window.location.href='../Login/Login.html';
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
	})
})
