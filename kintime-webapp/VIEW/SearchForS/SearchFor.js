$(function() {
	if(!$.fn.cookie('id')) {
		window.location.href = '../Login/Login.html';
	};
	$('#search-btn').on('tap', function() {
		if($('.city-text').val()) {
			//			搜索店内商品
			var data = {};
			data.stypeid = 11;
			data.keyword = '小';
			var jsonStr = JSON.stringify(data);
			$.ajax({
				type: "post",
				url: "../../PHP/home/skeywords",
				async: true,
				contentType: 'application/x-www-form-urlencoded',
				dataType: "json",
				data: jsonStr,
				success: function(data) {
					console.log(data)
					var str = "";
					$.each(data, function(index, item) {
						str += '<div class="fav-com-item" data-id="' + item.id + '"><a class="fav-com-link"><img data-echo=".' + item.headpic + '" class="fav-com-img" /><div class="fav-com-info"><div class="fav-com-name info-item">' + item.cainame + '</div><div class="fav-com-tip info-item">' + item.pliao + '</div><div class="fav-com-other info-item"><div class="fav-com-price"><span class="limite-price"><i class="money">￥</i><span class="pricenum">' + item.price + '</span></span></div></div></div><div class="fav-com-eva"><div class="fav-com-evaleft"><span class="rate-b"><span class="rate-s" style="width: ' + item.m_ping / 5 * 100 + '%;"></span></span></div><div class="fav-com-evaright">已售<span class="sale-num">' + item.m_xl + '</span></div></div></a></div>';
					});
					$(".fav-com-con").append(str);
					echo.init({
						offset: 0,
						throttle: 0
					})
				},
				error: function(e) {
					console.log(e);
				}
			});
		} else {
			alert('关键字不能为空')
		};
	});
})