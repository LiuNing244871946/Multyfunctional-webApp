$(function(){
	$('.bank-select').on('tap',function(){
		$('#discount-con,#select-con').show();
	});
	$('#discount-con,#select-con,#tips-con').on('tap',function(e){
		e.stopPropagation();
	});
	$('.bank-item').on('tap',function(e){
		$('.bank-item').removeClass('selected');
		$(this).addClass('selected');
	});
	$('.determine-btn').on('tap',function(e){
		if($('.bank-item.selected').hasClass('bank-olditem')){
			$('#discount-con,.discount-item').hide();
		}else{
			$('.discount-item').hide();
			$('#tips-con').show();
		};
	});
	$('.ok-btn').on('tap',function(e){
		$('#discount-con,.discount-item').hide();
	});
	$('.no-btn').on('tap',function(e){
		$('#discount-con,.discount-item').hide();
		$('.bank-item').removeClass('selected');
		$('.bank-item').eq(0).addClass('selected');
	});
//	提现按钮
	$('.widthdraw-btn').on('tap',function(){
		$('#discount-con,#pay-con').show();
	});
})
