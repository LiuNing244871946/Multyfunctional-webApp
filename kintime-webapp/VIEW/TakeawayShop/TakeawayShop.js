$(function() {
	echo.init({
		offset: 0,
		throttle: 0
	})
	eva(1,0);
	var sSwiper = new Swiper('#pageSwiper', {
		noSwiping: true,
		onlyExternal: true,
		onSlideChangeEnd: function(swiper) {
			$('.tap-item').removeClass('selected');
			$('.tap-item').eq(swiper.activeIndex).addClass('selected');
		}
	});
	$('.tap-item').on('tap', function() {
		$('.tap-item').removeClass('selected');
		$(this).addClass('selected');
		sSwiper.slideTo($(this).index(), 1000, false);
	});
	//	店铺信息
//	搜索店内商品
//	var data={};
//	data.stypeid=11;
//	data.keyword='小';
//	var jsonStr = JSON.stringify(data);
//	$.ajax({
//		type: "post",
//		url: "../../PHP/home/skeywords",
//		async: true,
//		contentType: 'application/x-www-form-urlencoded',
//		dataType: "json",
//		data:jsonStr,
//		success: function(data) {
//			console.log(data);
//		},
//		error: function(e) {
//			console.log(e);
//		}
//	});
	$.ajax({
		type: "post",
		url: "../../PHP/home/Foods/mai",
		async: true,
		contentType: 'application/x-www-form-urlencoded',
		dataType: "json",
		success: function(data) {
			console.log(data);
			$('.shop-info').css('background-image', 'url(.' + data.pic + ')');
			$('#shop-avatar').attr('src', '.' + data.headpic);
			$('.info-con .name-con').text(data.name);
			$('.info-con .annou-con').text(data.jian + ',' + data.sming);
			if(data.lei.length > 0) {
				var str = '';
				var rstr = '';
				$.each(data.lei, function(index,item) {
					str += '<li class="left-menu-item" data-leiId="' + item.id + '">' + item.name + '</li>';
					rstr+='<div class="right-menu-item" data-leiId="' + item.id + '"><div class="item-title"><span class="text-con1"><span class="text-con2">'+item.name+'</span></span></div><ul>';
					$.each(item.food, function(rindex,ritem) {
						if(ritem.guige==='1'){
							rstr+='<li class="dish-item" data-cId="'+ritem.id+'"><div class="dishimg-con"><img src=".'+ritem.headpic+'" class="dish-img" /></div><div class="dish-info"><span class="dish-title">'+ritem.cainame+'</span><span class="dish-tag"><span class="tag-item suggest-item">店家力荐</span>';
							if(ritem.type===1){
								rstr+='<span class="tag-item new-item">新品</span>';
							};
							rstr+='</span><span class="dish-remark">'+ritem.pliao+'</span><span class="dishsalenum-con">销量<span class="num">'+ritem.m_xl+'</span></span><div class="price-btn-con"><span class="price-con"><i class="money">K</i><span class="money-num">'+ritem.zhekou+'</span></span><span class="numbtn-con"><span class="less-btn">-</span><span class="num-con">0</span><span class="add-btn">+</span></span></div></div></li>';
						}else{
							rstr+='<li class="dish-item dish-item-s" data-cId="'+ritem.id+'"><div class="dishimg-con"><img src=".'+ritem.headpic+'" class="dish-img" /></div><div class="dish-info"><span class="dish-title">'+ritem.cainame+'</span><span class="dish-tag"><span class="tag-item suggest-item">店家力荐</span>';
							if(ritem.type===1){
								rstr+='<span class="tag-item new-item">新品</span>';
							};
							rstr+='</span><span class="dish-remark">'+ritem.pliao+'</span><span class="dishsalenum-con">销量<span class="num">'+ritem.m_xl+'</span></span><div class="price-btn-con"><span class="price-con"><i class="money">K</i><span class="money-num">'+ritem.zhekou+'</span><i class="money-text">起</i></span><span class="numbtn-con"><span class="text-con">选规格</span><span class="num-con">0</span></span></div></div></li>';
						}
					});
					rstr+='</ul></div>';
				});
				$('#left-list').append(str);
				$('#right-menu').append(rstr);
				$('.left-menu-item').eq(0).addClass('active');
			} else {
				return false;
			};
			$('#overall-num').text(data.ping);
			$('#overall-con .rate-s').css('width',data.ping/5.0*100+'%');
			$('#peernum').text(data.jib);
			$('#fav-ratenum').text(data.lv);
			$('#shop-address .text-con').text(data.xiaddress);
			$('#shop-address a').attr('href','tel:'+data.phone);
			$('#shop-time .text-con').text('配送时间：'+data.hi_b+'-'+data.hi_o);
		},
		error: function(e) {
			console.log(e);
		}
	});
	var menuTop = $('.shop-menu').offset().top;
	var scrollDis = menuTop - $('.top-navbar').height();
	var menuHeight = window.screen.availHeight - $('footer').offset().height - $('header').offset().height;
	var mainCon = menuHeight + $('.shop-info').offset().height + $('footer').offset().height;
	$('.shop-menu').css('height', menuHeight);
	$('.main-con').css('height', mainCon);
	$(window).scroll(function() {
		if($(window).scrollTop() > scrollDis - 10) {
			$('.top-navbar').addClass('active');
		};
		if($('.top-navbar').hasClass('active')) {
			$('.main-con').addClass('fixed');
			if($(window).scrollTop() < $('.top-navbar').height()) {
				$('.top-navbar').removeClass('active');
				$('.main-con').removeClass('fixed');
			};
		};
	});
	//	左右侧联动
	$('#left-list').on('tap','.left-menu-item', function() {
		var rightScroll = 0;
		for(var i = 0; i < $(this).index(); i++) {
			rightScroll += $('.right-menu-item').eq(i).height();
		};
		$(window).scrollTop(scrollDis);
		$('.left-menu-item').removeClass('active');
		$(this).addClass('active');
		$('.right-menu').scrollTop(rightScroll);
	});
	//	菜品数量
	$('.add-btn').on('tap', function() {
		if($('.order-num').text() < 99) {
			var listItem = $(this).parents('.dish-item');
			var foodNum = parseInt(listItem.find('.num-con').text());
			foodNum++;
			listItem.find('.num-con').text(foodNum);
			listItem.addClass('selected');
			var orderNum = parseInt($('.order-num').text());
			orderNum++;
			$('.order-num').text(orderNum);
			$('.menu-footer').addClass('active');
		} else {
			return false;
		}
	});
	$('.less-btn').on('tap', function() {
		var listItem = $(this).parents('.dish-item');
		var foodNum = parseInt(listItem.find('.num-con').text());
		foodNum--;
		var orderNum = parseInt($('.order-num').text());
		orderNum--;
		$('.order-num').text(orderNum);
		if(foodNum === 0) {
			listItem.find('.num-con').text(foodNum);
			listItem.removeClass('selected');
			if(orderNum === 0) {
				$('.menu-footer').removeClass('active');
			}
		} else {
			listItem.find('.num-con').text(foodNum);
			listItem.addClass('selected');
		};
	});
	//	订单展示
	$('.menu-footer .order-img').on('tap', function() {
		if($('.menu-footer').hasClass('active')) {
			$('#discount-con,#order-list').toggle();
		} else {
			return false;
		};
	});
	//	规格展示
	$('.dish-item-s .numbtn-con').on('tap', function(e) {
		e.stopPropagation();
		$('#discount-con,#norm-con').show();
	});
	$('.joincart').on('tap', function(e) {
		e.preventDefault();
		e.stopPropagation();
		var dishItemSIndex = $('.dish-item-s').index($(this).parents('.dish-item-s'));
		if($('.order-num').text() < 99) {
			var listItem = $('.dish-item-s').eq(dishItemSIndex);
			var foodNum = parseInt(listItem.find('.num-con').text());
			foodNum += 1;
			listItem.find('.num-con').text(foodNum);
			listItem.addClass('selected');
			var orderNum = parseInt($('.order-num').text());
			orderNum += 1;
			$('.order-num').text(orderNum);
			$('.menu-footer').addClass('active');
		} else {
			return false;
		};
		$('#discount-con,.discount-item').hide();
	});
	$('.norm-item .option-item').on('tap', function() {
		$(this).parent().children('.option-item').removeClass('selected');
		$(this).addClass('selected');
	});
	$('#discount-con').on('tap', function(e) {
		e.stopPropagation();
		$('#discount-con,.discount-item').hide();
	});
	$('.discount-item').on('tap', function(e) {
		e.stopPropagation();
	});
	//	评论
	$('.eva-sortitem').on('tap', function() {
		$('.eva-sortitem').removeClass('selected');
		$(this).addClass('selected');
		$('.eva-item').remove();
		eva($(this).index() + 1, 0);
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
		url: "../../PHP/home/foods/mai_ping",
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