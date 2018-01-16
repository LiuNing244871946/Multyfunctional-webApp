$(function() {
	echo.init({
		offset: -100,
		throttle: 0
	})
	eva(1, 0);
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
	$.ajax({
		type: "post",
		url: "../../PHP/home/Foods/mai",
		async: true,
		contentType: 'application/x-www-form-urlencoded',
		dataType: "json",
		success: function(data) {
			$('.shop-info').css('background-image', 'url(.' + data.pic + ')');
			$('#shop-avatar').attr('src', '.' + data.headpic);
			$('.info-con .name-con').text(data.name);
			$('.info-con .annou-con').text(data.jian + ',' + data.sming);
			if(data.lei.length > 0) {
				var str = '';
				var rstr = '';
				$.each(data.lei, function(index, item) {
					str += '<li class="left-menu-item" data-leiId="' + item.id + '">' + item.name + '</li>';
					rstr += '<div class="right-menu-item" data-leiId="' + item.id + '"><div class="item-title"><span class="text-con1"><span class="text-con2">' + item.name + '</span></span></div><ul>';
					$.each(item.food, function(rindex, ritem) {
						if(ritem.guige === '1') {
							rstr += '<li class="dish-item" data-cId="' + ritem.id + '"><div class="dishimg-con"><img src=".' + ritem.headpic + '" class="dish-img" /></div><div class="dish-info"><span class="dish-title">' + ritem.cainame + '</span><span class="dish-tag"><span class="tag-item suggest-item">店家力荐</span>';
							if(ritem.type === 1) {
								rstr += '<span class="tag-item new-item">新品</span>';
							};
							rstr += '</span><span class="dish-remark">' + ritem.pliao + '</span><span class="dishsalenum-con">销量<span class="num">' + ritem.m_xl + '</span></span><div class="price-btn-con"><span class="price-con"><i class="money">K</i><span class="money-num">' + ritem.zhekou + '</span></span><span class="numbtn-con"><span class="less-btn">-</span><span class="num-con">0</span><span class="add-btn">+</span></span></div></div></li>';
						} else {
							rstr += '<li class="dish-item dish-item-s" data-cId="' + ritem.id + '"><div class="dishimg-con"><img src=".' + ritem.headpic + '" class="dish-img" /></div><div class="dish-info"><span class="dish-title">' + ritem.cainame + '</span><span class="dish-tag"><span class="tag-item suggest-item">店家力荐</span>';
							if(ritem.type === 1) {
								rstr += '<span class="tag-item new-item">新品</span>';
							};
							rstr += '</span><span class="dish-remark">' + ritem.pliao + '</span><span class="dishsalenum-con">销量<span class="num">' + ritem.m_xl + '</span></span><div class="price-btn-con"><span class="price-con"><i class="money">K</i><span class="money-num">' + ritem.zhekou + '</span><i class="money-text">起</i></span><span class="numbtn-con"><span class="text-con">选规格</span><span class="num-con">0</span></span></div></div></li>';
						}
					});
					rstr += '</ul></div>';
				});
				$('#left-list').append(str);
				$('#right-menu').append(rstr);
				$('.left-menu-item').eq(0).addClass('active');
			} else {
				return false;
			};
			$('#overall-num').text(data.ping);
			$('#overall-con .rate-s').css('width', data.ping / 5.0 * 100 + '%');
			$('#peernum').text(data.jib);
			$('#fav-ratenum').text(data.lv);
			$('#shop-address .text-con').text(data.xiaddress);
			$('#shop-address a').attr('href', 'tel:' + data.phone);
			$('#shop-time .text-con').text('配送时间：' + data.hi_b + '-' + data.hi_o);
			$('#delivery-money .money-num').text(data.song);
			$('#start-price .money-num').text(data.gogo);
			$('.order-btn').text(data.gogo + '基普起送');
			shopCart();
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
	$('#left-list').on('tap', '.left-menu-item', function() {
		var rightScroll = 0;
		for(var i = 0; i < $(this).index(); i++) {
			rightScroll += $('.right-menu-item').eq(i).height();
		};
		$(window).scrollTop(scrollDis);
		$('.left-menu-item').removeClass('active');
		$(this).addClass('active');
		$('#right-menu').scrollTop(rightScroll);
	});
	//	菜品数量
	if($.fn.cookie('id')) {
		$('#right-menu').on('tap', '.add-btn', function(e) {
			e.stopPropagation();
			window.event.cancelBubble = true;
			e.preventDefault();
			window.event.returnValue = false;
			if($('.order-num').text() < 99) {
				var listItem = $(this).parents('.dish-item');
				var data = {};
				data.num = 1;
				data.cai = listItem.data('cid');
				data.gge = '0';
				var jsonStr = JSON.stringify(data);
				$.ajax({
					type: "post",
					url: "../../PHP/home/Foods/ggwc",
					async: true,
					contentType: 'application/x-www-form-urlencoded',
					dataType: "json",
					data: jsonStr,
					success: function(data) {
						if(data === 1) {
							shopCart();
						} else {
							alert('添加失败');
						}
					},
					error: function(e) {
						console.log(e);
					}
				});
			} else {
				alert('商品已达最大数量');
			};
		});
		$('#right-menu').on('tap', '.less-btn', function(e) {
			e.stopPropagation();
			window.event.cancelBubble = true;
			e.preventDefault();
			window.event.returnValue = false;
			var listItem = $(this).parents('.dish-item');
			var foodNum = listItem.find('.num-con').text();
			var data = {};
			data.num = 2;
			data.cai = listItem.data('cid');
			data.gge = '0';
			var jsonStr = JSON.stringify(data);
			$.ajax({
				type: "post",
				url: "../../PHP/home/Foods/ggwc",
				async: true,
				contentType: 'application/x-www-form-urlencoded',
				dataType: "json",
				data: jsonStr,
				success: function(data) {
					if(data === 1) {
						if(foodNum === '1') {
							shopCart();
							listItem.find('.num-con').text(0);
							listItem.removeClass('selected');
						} else {
							shopCart();
						};
					} else {
						alert('减少商品失败');
					}
				},
				error: function(e) {
					console.log(e);
				}
			});
		});
		$('.joincart').on('tap', function(e) {
			e.preventDefault();
			e.stopPropagation();
			var dishItemSIndex = $('#norm-con').data('cid');
			var data = {};
			data.cai = dishItemSIndex;
			data.num = '1';
			data.gge = '';
			$('.option-item.selected').each(function(index) {
				data.gge += $(this).data('lid') + ',';
			});
			var jsonStr = JSON.stringify(data);
			$.ajax({
				type: "post",
				url: "../../PHP/home/Foods/ggwc",
				async: true,
				contentType: 'application/x-www-form-urlencoded',
				dataType: "json",
				data: jsonStr,
				success: function(data) {
					if(data === 1) {
						if($('.order-num').text() < 99) {
							shopCart();
						} else {
							return false;
						};
						$('#discount-con,.discount-item').hide();
					} else {
						alert('添加失败');
					};
				},
				error: function(e) {
					console.log(e);
				}
			});
		});
	} else {
		$('#right-menu').on('tap', '.add-btn', function(e){
			window.location.href='../Login/Login.html';
		});
		$('#right-menu').on('tap', '.less-btn', function(e){
			window.location.href='../Login/Login.html';
		});
		$('.joincart').on('tap',function(e){
			window.location.href='../Login/Login.html';
		});
	};
	//	菜详情
	$('#right-menu').on('tap', '.dishimg-con', function(e) {
		e.stopPropagation();
		window.event.cancelBubble = true;
		e.preventDefault();
		window.event.returnValue = false;
		window.location.href = '../TakeawayDetail/TakeawayDetail.html?52E0DDC35C3C1109' + $(this).parents('.dish-item').data('cid');
	});
	//	订单展示
	$('.menu-footer .order-img').on('tap', function() {
		if($('.menu-footer').hasClass('active')) {
			$('#discount-con,#order-list').toggle();
		} else {
			return false;
		};
	});
	//	购物车按钮
	$('#order-list').on('tap', '.add-num', function() {
		if($('.order-num').text() < 99) {
			var listItem = $(this).parents('.orderlist-item');
			var data = {};
			data.num = 1;
			data.cai = listItem.data('cid');
			data.gge = listItem.data('lid');
			var jsonStr = JSON.stringify(data);
			$.ajax({
				type: "post",
				url: "../../PHP/home/Foods/ggwc",
				async: true,
				contentType: 'application/x-www-form-urlencoded',
				dataType: "json",
				data: jsonStr,
				success: function(data) {
					if(data === 1) {
						shopCart();
					} else {
						alert('添加失败');
					}
				},
				error: function(e) {
					console.log(e);
				}
			});
		} else {
			alert('商品已达最大数量');
		};
	});
	$('#order-list').on('tap', '.less-num', function() {
		var listItem = $(this).parents('.orderlist-item');
		var cNum = listItem.find('.num-con').text();
		var cId = listItem.data('cid');
		var data = {};
		data.num = 2;
		data.cai = listItem.data('cid');
		data.gge = listItem.data('lid');
		var jsonStr = JSON.stringify(data);
		$.ajax({
			type: "post",
			url: "../../PHP/home/Foods/ggwc",
			async: true,
			contentType: 'application/x-www-form-urlencoded',
			dataType: "json",
			data: jsonStr,
			success: function(data) {
				if(data === 1) {
					if(cNum === '1') {
						shopCart();
						$('.dish-item').each(function(index, item) {
							if($(this).data('cid') === cId) {
								$(this).find('.num-con').text(0);
								$(this).removeClass('selected');
							};
						});
					} else {
						shopCart();
					};
				} else {
					alert('减少商品失败');
				}
			},
			error: function(e) {
				console.log(e);
			}
		});
	});
	$('#order-list').on('tap', '#clear-btn', function() {
		$.ajax({
			type: "post",
			url: "../../PHP/home/Foods/che_mei",
			async: true,
			contentType: 'application/x-www-form-urlencoded',
			dataType: "json",
			success: function(data) {
				shopCart();
			},
			error: function(e) {
				console.log(e);
			}
		});
	});
	$('.order-btn').on('tap', function() {
		$.ajax({
			type: "post",
			url: "../../PHP/home/foods/kgwc",
			async: true,
			contentType: 'application/x-www-form-urlencoded',
			dataType: "json",
			success: function(data) {
				if(data.all < $('#start-price .money-num').text()) {
					return false;
				} else {
					window.location.href = '../TakeawayPay/TakeawayPay.html';
				};
			},
			error: function(e) {
				console.log(e);
			}
		});
	});
	//	规格展示
	$('#right-menu').on('tap', '.dish-item-s .numbtn-con', function(e) {
		e.stopPropagation();
		var listItem = $(this).parents('.dish-item');
		var cName = listItem.find('.dish-title').text();
		var cPrice = parseFloat(listItem.find('.money-num').text());
		$('#norm-con').data('cid', listItem.data('cid'));
		var data = {};
		data.id = listItem.data('cid');
		var jsonStr = JSON.stringify(data);
		$('.norm-title').text(cName);
		$.ajax({
			type: "post",
			url: "../../PHP/home/Foods/mai_gg",
			async: true,
			contentType: 'application/x-www-form-urlencoded',
			dataType: "json",
			data: jsonStr,
			success: function(data) {
				$('.norm-item').remove();
				var str = '';
				$.each(data, function(index, item) {
					cPrice += parseFloat(item.lei[0].price);
					str += '<div class="norm-item"><div class="normitem-title">' + item.name + '</div><div class="item-option">';
					$.each(item.lei, function(lindex, litem) {
						str += '<span class="option-item" data-lId="' + litem.id + '">' + litem.name + '</span>';
					});
					str += '</div></div>';
				});
				$('.norm-list').append(str);
				$('.item-option').children(':first-child').addClass('selected');
				$('.normprice-con .money-text').text(cPrice);
			},
			error: function(e) {
				console.log(e);
			}
		});
		$('#discount-con,#norm-con').show();
	});
	$('.norm-list').on('tap', '.norm-item .option-item', function() {
		$(this).parent().children('.option-item').removeClass('selected');
		$(this).addClass('selected');
		$('.normprice-con .money-text').text('--.--');
		var data = {};
		data.cai = $('#norm-con').data('cid');
		data.gge = '';
		$('.option-item.selected').each(function(index) {
			data.gge += $(this).data('lid') + ',';
		});
		var jsonStr = JSON.stringify(data);
		$.ajax({
			type: "post",
			url: "../../PHP/home/Foods/gg_money",
			async: true,
			contentType: 'application/x-www-form-urlencoded',
			dataType: "json",
			data: jsonStr,
			success: function(data) {
				$('.normprice-con .money-text').text(data);
			},
			error: function(e) {
				console.log(e);
			}
		});
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
		url: "../../PHP/home/foods/mai_ping",
		async: true,
		contentType: 'application/x-www-form-urlencoded',
		dataType: "json",
		data: evaJsonStr,
		success: function(data) {
			console.log(data);
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
//图片展示
function showImg(arr, indexnum, ob) {
	$('#img-swiper .swiper-slide').remove();
	var str = '';
	$.each(arr, function(index, item) {
		str += '<div class="swiper-slide"><img src="' + item + '" /></div>';
	});
	$('#img-swiper .swiper-wrapper').append(str);
	ob.slideTo(indexnum, 1000, false);
}
//购物车
function shopCart() {
	$.ajax({
		type: "post",
		url: "../../PHP/home/foods/kgwc",
		async: true,
		contentType: 'application/x-www-form-urlencoded',
		dataType: "json",
		success: function(data) {
			if(data.all > $('#start-price .money-num').text()) {
				$('.order-btn').text('提交订单');
			} else {
				$('.order-btn').text($('#start-price .money-num').text() + '基普起送');
			};
			if(data[0]) {
				$('.orderlist-item').remove();
				$('.menu-footer').addClass('active');
				var num = 0;
				var cart = '';
				var dishNum = {};
				$.each(data, function(index, item) {
					if(item.num) {
						dishNum[item.fid] = 0;
					};
				});
				$.each(data, function(index, item) {
					if(item.num) {
						dishNum[item.fid] += parseInt(item.num);
						num += parseInt(item.num);
						cart += '<li class="orderlist-item" data-cid="' + item.fid + '" data-lid="' + item.gge + '"><span class="dish-name">' + item.cainame + '</span><span class="price-num"><span class="dish-price"><i class="money">K</i><span class="money-num">' + item.ji + '</span></span><span class="dish-num"><span class="less-num">-</span><span class="num-con">' + item.num + '</span><span class="add-num">+</span></span></span></li>';
						$('.dish-item').each(function(indexi) {
							if($(this).data('cid') === parseInt(item.fid)) {
								$(this).addClass('selected');
								$(this).find('.num-con').text(dishNum[item.fid]);
							};
						});
					};
				});
				$('.order-num').text(num);
				$('.menu-footer .money-num').text(data.all);
				$('#order-list ul').append(cart);
			} else {
				$('.orderlist-item').remove();
				$('.dish-item').removeClass('selected');
				$('.dish-item .num-con').text(0);
				$('.menu-footer').removeClass('active');
				$('.menu-footer .order-num').text(0);
				$('#discount-con,.discount-item').hide();
			}
		},
		error: function(e) {
			console.log(e);
		}
	});
}