$(function() {
	echo.init({
		offset: 0,
		throttle: 0
	});
	if($.fn.cookie('id')) {
		var packId = window.location.href.substr(window.location.href.indexOf("?id=") + 4);
		var data = {};
		data.tcan = packId;
		var tcanJsonStr = JSON.stringify(data);
		$.ajax({
			type: "post",
			url: "../../PHP/home/foods/tcan",
			async: true,
			contentType: 'application/x-www-form-urlencoded',
			dataType: "json",
			data: tcanJsonStr,
			success: function(data) {
				var imgStr = '<a href="../FoodShop/FoodShop.html?id=' + data.sid + '" id="shop-link"><img data-echo=".' + data.headpic + '" id="shop-img" /><div id="shop-namecon"><span class="text-con">' + data.name + '</span><i class="iconfont icon-jiantouyou"></i></div></a>';
				$('#shop-imgcon').append(imgStr);
				$('#detail-name').text(data.tcname);
				$('#limite-pricecon .money-num').text(data.tcprice);
				$('#or-pricenum').text(data.oldprice);
				var other = '<span class="otherdetails-item current" data-id="' + data.id + '">' + data.tcname + '</span>';
				$.each(data.other, function(index, item) {
					other += '<span class="otherdetails-item" data-id="' + item.id + '">' + item.tcname + '</span>';
				});
				$('#otherdetails-con').append(other);
				var sheight = $('.otherdetails-item').height() + parseInt($('.otherdetails-item').css('margin-bottom'));
				if($('#otherdetails-con').height() > 2 * sheight + 10) {
					$('#otherdetails').addClass('hide-con');
					$('#otherdetails').append('<div id="show-btn"><span class="text-con">查看全部套餐</span><i class="iconfont icon-jiantouxia"></i></div>')
				};
				var detailTable = '';
				$.each(data.cai, function(index, item) {
					detailTable += '<tr><td class="com-namecon" data-img=".' + item.caipic + '"><span class="com-name">' + item.cainame + '</span><i class="iconfont icon-jiantouyou"></i></td><td class="com-numcon">' + item.cainum + '份</td><td class="com-price"><i class="money">￥</i><span class="money-num">' + item.caiprice + '</span></td></tr>';
				});
				$('#details-tablecon tbody').append(detailTable);
				var notes = '<li>' + data.ymd_k + '至' + data.ymd_t + '（';
				if(data.momo === '1') {
					notes += '周末,';
				} else {
					notes += '周一至周五,';
				};
				if(data.jiejia === '1') {
					notes += '法定节假日';
				} else {
					notes += '非法定节假日';
				};
				notes += '通用）</li>';
				$('#notes-valid .notes-text').append(notes);
				var time = '<li>' + data.his_k + '-' + data.his_t + '</li>';
				$('#notes-time .notes-text').append(time);
				var rule = '';
				$.each(data.gze, function(index, item) {
					rule += '<li>' + item.gz + '</li>';
				});
				$('#notes-rule .notes-text').append(rule);
				var ping = '<span id="eva-star"><span class="rate-b"><span class="rate-s" style="width: ' + data.ping / 5.0 * 100 + '%;"></span></span><span id="rate-num">' + data.ping + '分</span></span><span id="eva-titlemore"><span class="text-con">用户评价(</span><span id="eva-num">' + data.p_num + '</span><span class="text-con">)</span><i class="iconfont icon-jiantouyou"></i></span>';
				$('#eva-score').append(ping);
			},
			error: function(e) {
				console.log(e);
			}
		});
		var data1 = {};
		data1.id = packId;
		data1.type = '1';
		data1.num = '0';
		data1.mai = '2';
		var tcanPJsonStr = JSON.stringify(data1);
		$.ajax({
			type: "post",
			url: "../../PHP/home/foods/tcan_ping",
			async: true,
			contentType: 'application/x-www-form-urlencoded',
			dataType: "json",
			data: tcanPJsonStr,
			success: function(data) {
				var str = '';
				$.each(data, function(index, item) {
					str += '<li class="eva-item"><div class="eva-itemtitle"><a class="eva-user"><span class="user-con"><img data-echo=".' + item.headpic + '" class="user-img"/><span class="user-info"><span class="user-name-con"><span class="user-name">' + item.username + '</span><i class="icon-level"></i></span><span class="rate-b"><span class="rate-s" style="width: 80%;"></span></span></span></span><span class="eva-time">' + item.ptime + '</span></a></div><div class="evaitem-main"><div class="eva-text">' + item.nrong + '</div><div class="eva-img"><div class="img-con">';
					if(item.pic) {
						$.each(item.pic, function(index, picitem) {
							str += '<img data-echo=".' + picitem.picname + '" />';
						});
						str += '</div></div></div></li>';
					} else {
						str += '</div></div></div></li>';
					};
				});
				$('#eva-list').append(str);
			},
			error: function(e) {
				console.log(e);
			}
		});
	} else {
		window.location.href = '../Login/Login.html';
	};

	//	套餐点击事件
	$('#otherdetails-con').on('tap', '.otherdetails-item', function() {
		$('.otherdetails-item').removeClass('current');
		$(this).addClass('current');
		window.location.href = '../FoodDetail/FoodDetail.html?id=' + $(this).data('id');
	});
	//	查看全部套餐点击事件
	$('#otherdetails').on('tap', '#show-btn', function() {
		$('#otherdetails').toggleClass('hide-con');
		if($('#otherdetails').hasClass('hide-con')) {
			$('#show-btn .iconfont').attr('class', 'iconfont icon-jiantouxia');
		} else {
			$('#show-btn .iconfont').attr('class', 'iconfont icon-jiantoushang');
		}
	});
	//	图片展示区事件
	$(".details-table").on('tap', '.com-namecon', function() {
		var arr = [];
		var indexnum = $($('.com-namecon')).index($(this));
		$.each($('.com-namecon'), function(index) {
			arr.push($('.com-namecon').eq(index).data('img'));
		});
		showImg(arr, indexnum, imgSwiper);
		$('#discount-con,#img-show').show();
	});
	//	评论图片
	$("#eva-list").on('tap', '.img-con img', function() {
		var arr = [];
		var indexnum = $($('.img-con img')).index($(this));
		$.each($('.img-con img'), function(index) {
			arr.push($(this).attr('src'));
		});
		showImg(arr, indexnum, imgSwiper);
		$('#discount-con,#img-show').show();
	});
	var imgSwiper = new Swiper('#img-swiper', {
		direction: 'horizontal',
		pagination: '.swiper-pagination',
		paginationType: 'fraction',
		width: window.innerWidth,
		observer: true,
		onTap: function(swiper) {
			$('#discount-con,.discount-item').hide();
		}
	});
	$('#buy-btn').on('tap', function() {
		window.location.href = '../FoodPay/FoodPay.html?id=' + packId;
	});
	$('.icon-fanhui').on('tap', function() {
		history.back(-1);
	});
})

function showImg(arr, indexnum, ob) {
	$('#img-swiper .swiper-slide').remove();
	var str = '';
	$.each(arr, function(index, item) {
		str += '<div class="swiper-slide"><img src="' + item + '" /></div>';
	});
	$('#img-swiper .swiper-wrapper').append(str);
	ob.slideTo(indexnum, 1000, false);
}