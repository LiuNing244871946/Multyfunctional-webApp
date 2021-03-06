$(function() {
	language();
	if($.fn.cookie('id')) {
		var packId = window.location.href.substr(window.location.href.indexOf("?") + 1);
		var data = {};
		data.id = packId;
		var jsonStr = JSON.stringify(data);
		$.ajax({
			type: "post",
			url: "../../PHP/home/foods/fuq",
			async: true,
			contentType: 'application/x-www-form-urlencoded',
			dataType: "json",
			data: jsonStr,
			success: function(data) {
				if(data === '2') {
					alert('订单信息错误，请返回重新购买');
					window.location.href = '../FoodShop/FoodShop.html';
				} else {
					$('#pay-page .shop-img').attr('src', '.' + data.headpic);
					$('#pay-page .order-money .money-num').text(data.tcprice);
					$('#pay-page .ordernum-con .order-num').text(data.id);
				};
			},
			error: function(e) {
				console.log(e);
			}
		});
	} else {
		window.location.href = '../Login/Login.html';
	};

	//	支付方式
	$('#pay-page .payment-select').on('tap', function() {
		$('#pay-page .payment-item').removeClass('selected');
		$(this).parent().addClass('selected');
	});
	//	确认支付
	$('#pay-page .pay-btn').on('tap', function() {
		$('#discount-con,#pay-con').show();
	});
	//	银行卡列表
	$('#china .card-num').on('tap', function() {
		$('#discount-con').css('display','flex');
		$('#discount-con').css('display','-webkit-flex');
		$('#cardlist-con').show();
	});
	$('#card-list .bank-select').on('tap', function() {
		$('#card-list .card-item').removeClass('selected');
		$(this).parent().addClass('selected');
	});
	$('#add-card').on('tap', function() {
		location.href = 'add-card.html';
	});
	$('#cardlist-con .determine-btn').on('tap', function() {
		var bankName = $('#card-list .selected .bank-name').text();
		var bankNum = $('#card-list .selected .bank-num').text();
		$('#discount-con,.discount-item').hide();
		$('#china .num-text').text(bankNum);
	});
	$('.icon-fanhui').on('tap', function() {
		history.back(-1);
	});
})