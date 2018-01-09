$(function(){
//	侧边页
	$('.icon-zhongqingdianxinicon07').on('tap',function(){
		$('#discount-con').show();
		$('#me-con').animate({
			left:0
		},200);
	});
	var leftMe = $('#me-con').css('width');
	$('#discount-con').on('tap',function(){
		$('#me-con').animate({
			left:'-'+leftMe
		},200);
		$('#discount-con').hide();
		$('.discount-item').hide();
	});
	$('#me-con').on('tap',function(e){
		e.stopPropagation();
	});
	$('#me-status .status-item').on('tap',function(){
		$('#me-status .status-item').removeClass('selected');
		$(this).addClass('selected');
	});
})
