$(function() {
	if(!$.fn.cookie('id')) {
		window.location.href = '../Login/Login.html';
	};
	echo.init({
		offset: 0,
		throttle: 0
	})
	getShopByType('杭州', '11', '0', homeShop);
	$('.fav-com-con').on('tap','.fav-com-item',function(){
		$.fn.cookie('C057DF743DCFDA2C',$(this).data('id'),{path:'/'});
		window.location.href='../TakeawayShop/TakeawayShop.html';
	})
})

function homeShop(data) {
	var str = "";
	$.each(data, function(index, item) {
		str += '<div class="fav-com-item" data-id="' + item.id + '"><a class="fav-com-link"><img data-echo=".' + item.headpic + '" class="fav-com-img" /><div class="fav-com-info"><div class="fav-com-name info-item">' + item.name + '</div><div class="fav-com-tip info-item">' + item.sming + '</div><div class="fav-com-other info-item"><div class="fav-com-price">人均<span class="limite-price"><i class="money">￥</i><span class="pricenum">' + item.gogo + '</span></span></div><div class="fav-com-dis">距离<span class="dis-num">26km</span></div></div></div><div class="fav-com-eva"><div class="fav-com-evaleft"><span class="rate-b"><span class="rate-s" style="width: ' + item.ping / 5 * 100 + '%;"></span></span></div><div class="fav-com-evaright">已售<span class="sale-num">' + item.xl + '</span></div></div></a></div>';
	});
	$(".fav-com-con").append(str);

};