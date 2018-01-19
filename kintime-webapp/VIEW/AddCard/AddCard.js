$(function(){
	language();
	if(!$.fn.cookie('id')) {
		window.location.href = '../Login/Login.html';
	};
	$('.bank-select').on('tap',function(){
		$('#discount-con,#select-con').show();
	});
	$('#discount-con,.discount-item').on('tap',function(e){
		e.stopPropagation();
	});
	$('.bank-item').on('tap',function(e){
		$('.bank-item').removeClass('selected');
		$(this).addClass('selected');
	});
	$('.determine-btn').on('tap',function(e){
		$('#discount-con,.discount-item').hide();
	});
})
