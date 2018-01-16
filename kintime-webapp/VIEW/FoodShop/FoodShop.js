$(function() {
	echo.init({
		offset: 0,
		throttle: 0
	});
		$.ajax({
			type: "post",
			url: "../../PHP/home/Foods/index",
			async: true,
			contentType: 'application/x-www-form-urlencoded',
			dataType: "json",
			success: function(data) {
				var str = '<img data-echo=".' + data.headpic + '" id="shop-info-img" />';
				$('#shop-img').append(str);
				if(data.pic === '0') {
					$('#more-img').remove();
				} else {
					$('#more-imgnum').text(data.pic);
				};
				$('#shop-name').text(data.name);
				$('#shop-rate .rate-s').css('width', data.ping / 5 * 100 + '%');
				$('#average .money-num').text(data.price);
				$('#address-text').text(data.xiaddress);
				$('#phone-con a').attr('href', 'tel:' + data.phone);
				$('#shop-takeaway').data('ts', data.wmstate);
				switch(data.wmstate) {
					case 0:
						$('#takeaway-status .text-con').text('暂未开通外卖功能');
						break;
					case 1:
						$('#takeaway-status .text-con').text('');
						break;
					case 2:
						$('#takeaway-status .text-con').text('不在配送时间');
						break;
					case 3:
						$('#takeaway-status .text-con').text('不在配送范围');
						break;
				};
				$('#shop-order a').attr('href', '../FoodMenu/FoodMenu.html?id=' + data.id);
				var pack = '';
				$.each(data.food, function(index, item) {
					pack += '<li class="pack-item"><a href="../FoodDetail/FoodDetail.html?id=' + item.id + '" class="pack-itemlink"><img data-echo=".' + item.headpic + '" class="pack-item-img" /><div class="pack-item-info"><div class="pack-item-info-name">' + item.tcname + '</div><div class="pack-item-info-tip"><span class="pack-item-time">';
					if(item.momo === '1') {
						pack += '周一至周日';
					} else if(item.momo === '2') {
						pack += '周一至周五';
					};
					pack += '</span><span class="icon-gedang"> | </span><span class="pack-item-sta">';
					if(item.yue === '1') {
						pack += '免预约';
					} else if(item.yue === '2') {
						pack += '需预约';
					};
					pack += '</span></div><div class="pack-item-info-price"><span class="limite-price"><i class="money">￥</i><span>' + item.tcprice + '</span></span><span class="or-price">门店价:<i class="money">￥</i><span>' + item.oldprice + '</span></span></div><div class="pack-item-info-rate"><span class="rate-b"><span class="rate-s" style="width: ' + item.ping / 5 * 100 + '%;"></span></span><span class="score">' + item.ping + '分</span></div></div><div class="pack-item-salenum"><span class="sale-num">已售<span class="num">' + item.xl + '</span><i class="iconfont icon-jiantouyou"></i></span></div></a></li>';
				});
				$("#pack-list").append(pack);
				if(data.food.length > 2) {
					var show = '<div id="show-btn"><span class="text-con">查看全部套餐</span><i class="iconfont icon-jiantouxia"></i></div>';
					$('#shop-pack').append(show);
				} else {
					return false;
				};
				$('#eva-num').text(data.p_num);
				$('#overall-num').text(data.ping);
				$('#overall-con .rate-s').css('width', data.ping / 5 * 100 + '%');
				$('#peernum').text(data.jib);
				$('#fav-ratenum').text(data.lv);
				var moreeva = '<a href="../EvaAll/EvaAll.html?id="' + data.id + ' id="eva-morelink">查看全部用户评价<span id="eva-morenumcon">共<span class="eva-morenum">' + data.p_num + '</span>条<i class="iconfont icon-jiantouyou"></i></span></a>';
				$('#eva-more').append(moreeva);
			},
			error: function(e) {
				console.log(e);
			}
		});
		//	附近
		var shopData = {};
		shopData.stypeid = 11;
		var shopJson = JSON.stringify(shopData);
		$.ajax({
			type: "post",
			url: "../../PHP/home/more",
			async: true,
			contentType: 'application/x-www-form-urlencoded',
			dataType: "json",
			data: shopJson,
			success: function(data) {
				var str = "";
				$.each(data, function(index, item) {
					str += '<div class="fav-com-item" data-id="' + item.id + '"><a class="fav-com-link"><img data-echo=".' + item.headpic + '" class="fav-com-img" /><div class="fav-com-info"><div class="fav-com-name info-item">' + item.name + '</div><div class="fav-com-tip info-item">' + item.sming + '</div><div class="fav-com-other info-item"><div class="fav-com-price">人均<span class="limite-price"><i class="money">￥</i><span class="pricenum">' + item.gogo + '</span></span></div><div class="fav-com-dis">距离<span class="dis-num">26km</span></div></div></div><div class="fav-com-eva"><div class="fav-com-evaleft"><span class="rate-b"><span class="rate-s" style="width: ' + item.ping / 5 * 100 + '%;"></span></span></div><div class="fav-com-evaright">已售<span class="sale-num">' + item.xl + '</span></div></div></a></div>';
				});
				$("#moreshop .fav-com-con").append(str);
			},
			error: function(e) {
				console.log(e);
			}
		});

	$('#shop-pack').on('tap', '#show-btn', function() {
		$('#pack-list').toggleClass('hide');
		if($('#pack-list').hasClass('hide')) {
			$('#show-btn .iconfont').attr('class', 'iconfont icon-jiantouxia');
		} else {
			$('#show-btn .iconfont').attr('class', 'iconfont icon-jiantoushang');
		};
	});
	$('.eva-sortitem').on('tap', function() {
		$('.eva-sortitem').removeClass('selected');
		$(this).addClass('selected');
		$('.eva-item').remove();
		eva($(this).index() + 1, 0);
	});
	eva(1, 0);
	$('#shop-takeaway').on('tap', function() {
		if($(this).data('ts') === 1) {
			window.location.href = '../TakeawayShop/TakeawayShop.html';
		} else {
			return false;
		};
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

})

//加载评论
function eva(type, num) {
	var evaData = {};
	evaData.type = type;
	evaData.num = num;
	var evaJsonStr = JSON.stringify(evaData);
	$.ajax({
		type: "post",
		url: "../../PHP/home/foods/tang_ping",
		async: true,
		contentType: 'application/x-www-form-urlencoded',
		dataType: "json",
		data: evaJsonStr,
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
			echo.init({
				offset: 0,
				throttle: 0
			});
		},
		error: function(e) {
			console.log(e);
		}
	});
	$('.icon-fanhui').on('tap', function() {
		history.back(-1);
	});
}

function showImg(arr, indexnum, ob) {
	$('#img-swiper .swiper-slide').remove();
	var str = '';
	$.each(arr, function(index, item) {
		str += '<div class="swiper-slide"><img src="' + item + '" /></div>';
	});
	$('#img-swiper .swiper-wrapper').append(str);
	ob.slideTo(indexnum, 1000, false);
}