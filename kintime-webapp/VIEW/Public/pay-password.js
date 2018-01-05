$(function(){
	//	支付密码
	$('.pay-title .iconfont').on('tap',function(){
			$('#discount-con,.discount-item').hide();
			$('.lattice').text('');
			$('#pay-pass').val('');
	});
	$('#pay-pass').focus(function(){
		$('.lattice').css('border-color','#00BED7')
	});
	$('#pay-pass').blur(function(){
		$('.lattice').css('border-color','#1E0F00')
	});
	$('#pay-pass').on('input',function(e){
		var pw = $('#pay-pass').val();
		for(var i=0;i<6;i++){
			if(pw[i]){
				$($('.lattice')[i]).text('*')
			}else{
				$($('.lattice')[i]).text('')
			}
		}
	});
})
