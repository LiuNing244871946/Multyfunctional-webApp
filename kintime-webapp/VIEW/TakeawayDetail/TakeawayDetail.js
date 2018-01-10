$(function() {
	echo.init({
		offset: 0,
		throttle: 0
	});
	if($.fn.cookie('id')) {
		var data = {};
		data.cai = window.location.href.substr(window.location.href.indexOf("?") + 1);
		data.cai = data.cai.substring(16, data.cai.length);
		var jsonStr = JSON.stringify(data);
		$.ajax({
			type: "post",
			url: "../../PHP/home/foods/details",
			async: true,
			contentType: 'application/x-www-form-urlencoded',
			dataType: "json",
			data: jsonStr,
			success: function(data) {
				$('.shop-img').attr('data-echo', '.' + data.headpic);
				$('.name').text(data.cainame);
				$('.sale-num').text(data.m_xl);
				$('.pricenum').text(data.zhekou);
				$('.otherdetails-con .text-con').text(data.pliao);
				$('.eva-num').text(data.m_ping + '%');
				if(data.num === 0) {
					$('#shop-num').text(0);
				} else {
					$('#shop-num').text(data.num);
					$('#shop-num').show();
				};
				if(data.guige === '2') {
					$('.buy-btn a').text('选规格');
					//	规格展示
					$('.buy-btn').on('tap', function(e) {
						e.stopPropagation();
						var cName = $('.name').text();
						var cPrice = parseFloat($('.pricenum').text());
						var data3 = {};
						var cai = window.location.href.substr(window.location.href.indexOf("?") + 1);
						cai = cai.substring(16, cai.length);
						data3.id = cai;
						var jsonStr3 = JSON.stringify(data3);
						$('#norm-con').data('cid', cai);
						$('.norm-title').text(cName);
						$.ajax({
							type: "post",
							url: "../../PHP/home/Foods/mai_gg",
							async: true,
							contentType: 'application/x-www-form-urlencoded',
							dataType: "json",
							data: jsonStr3,
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
					//	规格加入购物车
					$('.joincart').on('tap', function(e) {
						e.preventDefault();
						e.stopPropagation();
						if(data.count < 99) {
							var dishItemSIndex = $('#norm-con').data('cid');
							var data4 = {};
							data4.cai = dishItemSIndex;
							data4.num = '1';
							data4.gge = '';
							$('.option-item.selected').each(function(index) {
								data4.gge += $(this).data('lid') + ',';
							});
							var jsonStr4 = JSON.stringify(data4);
							$.ajax({
								type: "post",
								url: "../../PHP/home/Foods/ggwc",
								async: true,
								contentType: 'application/x-www-form-urlencoded',
								dataType: "json",
								data: jsonStr4,
								success: function(data) {
									if(data === 1) {
										$('#shop-num').show();
										$('#shop-num').text(parseInt($('#shop-num').text()) + 1);
										$('#discount-con,.discount-item').hide();
									} else {
										alert('添加失败');
									};
								},
								error: function(e) {
									console.log(e);
								}
							});
						} else {
							return false;
						};
					});
				} else if(data.guige === '1') {
					$('.buy-btn a').text('加入购物车');
					$('.buy-btn').on('tap', function() {
						if(data.count < 99) {
							var data2 = {};
							data2.num = 1;
							var cai = window.location.href.substr(window.location.href.indexOf("?") + 1);
							cai = cai.substring(16, cai.length);
							data2.cai = cai;
							data2.gge = '0';
							var jsonStr2 = JSON.stringify(data2);
							$.ajax({
								type: "post",
								url: "../../PHP/home/Foods/ggwc",
								async: true,
								contentType: 'application/x-www-form-urlencoded',
								dataType: "json",
								data: jsonStr2,
								success: function(data) {
									if(data === 1) {
										$('#shop-num').show();
										$('#shop-num').text(parseInt($('#shop-num').text()) + 1);
									} else {
										alert('添加失败');
									}
								},
								error: function(e) {
									console.log(e);
								}
							});
						};
					});
				};
			},
			error: function(e) {
				console.log(e);
			}
		});
		var data1 = {};
		data1.id = data.cai;
		data1.type = '1';
		data1.num = '0';
		data1.mai = '1';
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
	$('.icon-guanbi').on('tap', function() {
		window.location.href = '../TakeawayShop/TakeawayShop.html';
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