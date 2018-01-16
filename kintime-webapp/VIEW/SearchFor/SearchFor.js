$(function() {
	if($.fn.cookie('id')) {
		$.ajax({
			type: "post",
			url: "../../PHP/home/history",
			async: true,
			contentType: 'application/x-www-form-urlencoded',
			dataType: "json",
			success: function(data) {
				var str = "";
				$.each(data, function(index, item) {
					str += '<span class="history-item">' + item.nr + '</span>';
				});
				$("#history-con").append(str);
			},
			error: function(e) {
				console.log(e);
			}
		});
	} else {
//		window.location.href = '../Login/Login.html';
	};

	$('#search-btn').on('tap', function() {
		if($('.city-text').val()) {
			var data = {};
			data.address = '北京';
			data.keyword = $('.city-text').val();
			data.num = 0;
			var jsonStr = JSON.stringify(data);
			$.ajax({
				type: "post",
				url: "../../PHP/home/keywords",
				async: true,
				contentType: 'application/x-www-form-urlencoded',
				dataType: "json",
				data: jsonStr,
				success: function(data) {
					var str = "";
					$.each(data, function(index, item) {
						str += '<div class="fav-com-item"><a href="../FoodShop/FoodShop.html?id=' + item.id + '" class="fav-com-link"><img data-echo=".' + item.headpic + '" class="fav-com-img" /><div class="fav-com-info"><div class="fav-com-name info-item">' + item.name + '</div><div class="fav-com-tip info-item">' + item.sming + '</div><div class="fav-com-other info-item"><div class="fav-com-price">人均<span class="limite-price"><i class="money">￥</i><span class="pricenum">' + item.price + '</span></span></div><div class="fav-com-dis">距离<span class="dis-num">26km</span></div></div></div><div class="fav-com-eva"><div class="fav-com-evaleft"><span class="rate-b"><span class="rate-s" style="width: ' + item.ping / 5 * 100 + '%;"></span></span></div><div class="fav-com-evaright">已售<span class="sale-num">' + item.xl + '</span></div></div></a></div>';
					});
					$("#search-result .fav-com-con").append(str);
					$('#search-history').hide();
					$('#search-result').show();
					echo.init({
						offset: 0,
						throttle: 0
					});
				},
				error: function(e) {
					console.log(e);
				}
			});
		} else {
			alert('关键字不能为空')
		};
	});
	$('.icon-laji').on('tap', function() {
		$.ajax({
			type: "post",
			url: "../../PHP/home/delhistory",
			async: true,
			contentType: 'application/x-www-form-urlencoded',
			dataType: "json",
			success: function(data) {
				if(data === 1) {
					$('#history-con').remove('.history-item');
				};
			},
			error: function(e) {
				console.log(e);
			}
		});
	});
	$('.icon-fanhui').on('tap', function() {
		history.back(-1);
	});
})