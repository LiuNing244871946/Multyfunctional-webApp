$(function(){
	//切换页面
	$('.page-btn').on('tap',function(){
		$('.page-btn').removeClass('selected');
		$(this).addClass('selected');
		var cPage = $('.page-btn').index($(this));
		var leftM = '-'+100*cPage+'%';
		$('.page-con').animate({
			left:leftM
		},200);
	});
})

