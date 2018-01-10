$(function(){
	if($.fn.cookie('id')) {
		
	} else {
		window.location.href = '../Login/Login.html';
	};
	var sSwiper = new Swiper('#evasort-swiper',{
		noSwiping:true,
		onSlideChangeEnd:function(swiper){
			$('.sort-item').removeClass('selected');
			$('.sort-item').eq(swiper.activeIndex).addClass('selected');
		}
	});
	$('.sort-item').on('tap',function(){
		$('.sort-item').removeClass('selected');
		$(this).addClass('selected');
		sSwiper.slideTo($(this).index(),1000,false);
	});
})
