$(function(){
	var homeSwiper = new Swiper('#home-swiper',{
		direction:'horizontal',
		loop:true,
		pagination:'#home-pagination',
		paginationClickable:true,
		autoplay:3000
	});
	function homeShop(data) {
		var str = "";
		$.each(data, function(index, item) {
			str += '<div class="fav-com-item" data-id="' + item.id + '"><a class="fav-com-link"><img data-echo=".' + item.headpic + '" class="fav-com-img" /><div class="fav-com-info"><div class="fav-com-name info-item">' + item.name + '</div><div class="fav-com-tip info-item">' + item.sming + '</div><div class="fav-com-other info-item"><div class="fav-com-price">人均<span class="limite-price"><i class="money">￥</i><span class="pricenum">' + item.price + '</span></span></div><div class="fav-com-dis">距离<span class="dis-num">26km</span></div></div></div><div class="fav-com-eva"><div class="fav-com-evaleft"><span class="rate-b"><span class="rate-s" style="width: ' + item.ping / 5 * 100 + '%;"></span></span></div><div class="fav-com-evaright">已售<span class="sale-num">' + item.xl + '</span></div></div></a></div>';
		});
		$(".fav-com-con").append(str);

	};
	getShopByType('北京','1','0',homeShop);
	$('.fav-com-con').on('tap','.fav-com-item',function(){
		$.fn.cookie('4373433CA7C70528',$(this).data('id'),{path:'/'});
		window.location.href='../FoodShop/FoodShop.html';
	})
})
