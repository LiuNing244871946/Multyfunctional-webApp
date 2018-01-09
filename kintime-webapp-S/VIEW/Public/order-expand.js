$(function(){
	//订单展开
	$('.order-item .item-info').on('tap',function(){
		$(this).parent().toggleClass('active');
		if($(this).parent().hasClass('active')){
			$(this).find('.iconfont').attr('class','iconfont icon-arrow-up1');
		}else{
			$(this).find('.iconfont').attr('class','iconfont icon-arrow-down');
		}
	});
})

