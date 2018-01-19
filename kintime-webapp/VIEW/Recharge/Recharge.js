$(function(){
	language();
	if(!$.fn.cookie('id')) {
		window.location.href = '../Login/Login.html';
	};
	$('.card-recharge').on('tap',function(){
		window.location.href='../RechangeCard/rechange-card.html';
	});
	$('.online-recharge').on('tap',function(){
		window.location.href='../RechargeOnline/RechargeOnline.html';
	});
})
