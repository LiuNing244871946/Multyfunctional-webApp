$(function() {
	echo.init({
		offset: 0,
		throttle: 0
	});
	language();
	var sImgData = {};
	sImgData.type = 1;
	var sImgJson = JSON.stringify(sImgData);
	$.ajax({
		type: "post",
		url: "../../PHP/home/lunbo",
		async: true,
		contentType: 'application/x-www-form-urlencoded',
		dataType: "json",
		data: sImgJson,
		success: function(data) {
			var str = '';
			$.each(data, function(index, item) {
				str += '<a class="swiper-slide" href="' + item.url + '" data-img="' + item.id + '"><img src=".' + item.pic + '" /></a>';
			});
			$('#home-swiper .swiper-wrapper').append(str);
			var homeSwiper = new Swiper('#home-swiper', {
				direction: 'horizontal',
				loop: true,
				pagination: '#home-pagination',
				paginationClickable: true,
				autoplay: 3000,
				oberver: true,
				oberverParents: true
			});
		},
		error: function(e) {
			console.log(e);
		}
	});
	var sSwiper = new Swiper('#page-swiper', {
		noSwiping: true,
		onlyExternal: true,
		onSlideChangeEnd: function(swiper) {
			$('.page-btn').removeClass('selected');
			$('.page-btn').eq(swiper.activeIndex).addClass('selected');
		}
	});
	$('.page-btn').on('tap', function() {
		$('.page-btn').removeClass('selected');
		$(this).addClass('selected');
		sSwiper.slideTo($(this).index(), 1000, false);
	});
	//	数据
	function homeShop(data) {
		var str = "";
		$.each(data, function(index, item) {
			str += '<div class="fav-com-item" data-id="' + item.id + '"><a class="fav-com-link"><img data-echo=".' + item.headpic + '" class="fav-com-img" /><div class="fav-com-info"><div class="fav-com-name info-item">' + item.name + '</div><div class="fav-com-tip info-item">' + item.sming + '</div><div class="fav-com-other info-item"><div class="fav-com-price">人均<span class="limite-price"><i class="money">￥</i><span class="pricenum">' + item.price + '</span></span></div><div class="fav-com-dis">距离<span class="dis-num">26km</span></div></div></div><div class="fav-com-eva"><div class="fav-com-evaleft"><span class="rate-b"><span class="rate-s" style="width: ' + item.ping / 5 * 100 + '%;"></span></span></div><div class="fav-com-evaright">已售<span class="sale-num">' + item.xl + '</span></div></div></a></div>';
		});
		$(".fav-com-con").append(str);

	};
	getShopByType('北京', '0', '0', homeShop);
	$.ajax({
		type: "post",
		url: "../../PHP/home/bwc",
		async: true,
		contentType: 'application/x-www-form-urlencoded',
		dataType: "json",
		success: function(data) {
			var str = "";
			var begint = new Date(data.begintime);
			var nT = new Date();
			if(begint > nT) {
				var totalT = (begint - nT) / 1000;
				var day = Math.floor(totalT / 3600 / 24);
				var hours = Math.floor((totalT - day * 3600 * 24) / 3600);
				var mins = Math.floor((totalT - day * 3600 * 24 - hours * 3600) / 60);
				var secs = Math.floor(totalT - day * 3600 * 24 - hours * 3600 - mins * 60);
				str = '<a href="' + data.lianjie + '" class="king-meal-link"><img data-echo=".' + data.headpic + '" class="king-meal-img" /><div class="king-meal-titlecon"><span class="king-meal-titlename">' + data.tcname + '</span><span class="king-meal-titletime"><div class="countdown-d"><span id="countdown-d">' + day + '</span><span class="text-con">天</span></div><div class="countdown-h"><span id="countdown-h">' + hours + '</span><span class="text-con">小时</span></div><div class="countdown-m"><span id="countdown-m">' + mins + '</span><span class="text-con">分</span></div><div class="countdown-s"><span id="countdown-s">' + secs + '</span><span class="text-con">秒</span></div>后开抢</span></div><div class="king-meal-titlebac"></div><div class="king-meal-title">霸王餐</div></a>';
			} else {
				str = '<a href="' + data.lianjie + '" class="king-meal-link"><img data-echo=".' + data.headpic + '" class="king-meal-img" /><div class="king-meal-titlecon"><span class="king-meal-titlename">' + data.tcname + '</span><span class="king-meal-titletime">活动已开始</span></div><div class="king-meal-titlebac"></div><div class="king-meal-title">霸王餐</div></a>';
			}
			$(".king-meal").append(str);
			setInterval(function() {
				if(nT < begint) {
					nT = new Date();
					var totalT = (begint - nT) / 1000;
					var day = Math.floor(totalT / 3600 / 24);
					var hours = Math.floor((totalT - day * 3600 * 24) / 3600);
					var mins = Math.floor((totalT - day * 3600 * 24 - hours * 3600) / 60);
					var secs = Math.floor(totalT - day * 3600 * 24 - hours * 3600 - mins * 60);
					$('#countdown-d').text(day);
					$('#countdown-h').text(hours);
					$('#countdown-m').text(mins);
					$('#countdown-s').text(secs);
				};
			}, 500);
		},
		error: function(e) {
			console.log(e);
		}
	});
	var tHData = {};
	tHData.type = 1;
	var tHJsonStr = JSON.stringify(tHData);
	$.ajax({
		type: "post",
		url: "../../PHP/home/tehui",
		async: true,
		data: tHJsonStr,
		contentType: 'application/x-www-form-urlencoded',
		dataType: "json",
		success: function(data) {
			var str = "";
			$.each(data, function(index, item) {
				var overT = new Date(item.overtime);
				var nT = new Date();
				if(overT > nT) {
					var totalT = (overT - nT) / 1000;
					var day = Math.floor(totalT / 3600 / 24);
					var hours = Math.floor((totalT - day * 3600 * 24) / 3600);
					var mins = Math.floor((totalT - day * 3600 * 24 - hours * 3600) / 60);
					var secs = Math.floor(totalT - day * 3600 * 24 - hours * 3600 - mins * 60);
					str += '<a class="swiper-slide" id="special' + item.id + '" href="../FoodShop/FoodShop.html?id=' + item.sid + '"><img src="../../STATIC/img/网站-05.jpg" /><div class="time">仅剩<span class="time-d">' + day + '</span>天<span class="time-h">' + hours + '</span>小时<span class="time-m">' + mins + '</span>分<span class="time-s">' + secs + '</span>秒</div></a>';
				} else {
					str += '<a class="swiper-slide" id="special' + item.id + '" href="../FoodShop/FoodShop.html?id=' + item.sid + '"><img src="../../STATIC/img/网站-05.jpg" /><div class="time">活动已结束</div></a>';
				};
			});
			$('#special-swiper .swiper-wrapper').append(str);
			$.each(data, function(index, item) {
				var overT = new Date(item.overtime);
				var nT = new Date();
				var child = '#special' + item.id;
				setInterval(function() {
					if(nT < overT) {
						nT = new Date();
						var totalT = (overT - nT) / 1000;
						var day = Math.floor(totalT / 3600 / 24);
						var hours = Math.floor((totalT - day * 3600 * 24) / 3600);
						var mins = Math.floor((totalT - day * 3600 * 24 - hours * 3600) / 60);
						var secs = Math.floor(totalT - day * 3600 * 24 - hours * 3600 - mins * 60);
						$(child).find('.time-d').text(day);
						$(child).find('.time-h').text(hours);
						$(child).find('.time-m').text(mins);
						$(child).find('.time-s').text(secs);
					};
				}, 500);
			});
			var specialSwiper = new Swiper('#special-swiper', {
				direction: 'horizontal',
				pagination: '#special-pagination',
				paginationClickable: true,
				autoplay: 3000,
			});
		},
		error: function(e) {
			console.log(e);
		}
	});
	$('.fav-com-con').on('tap', '.fav-com-item', function() {
		$.fn.cookie('4373433CA7C70528', $(this).data('id'), {
			path: '/'
		});
		window.location.href = '../FoodShop/FoodShop.html';
	});
	$('.city-con').on('tap',function(){
		window.location.href='../CitySelect/CitySelect.html';
	});
})