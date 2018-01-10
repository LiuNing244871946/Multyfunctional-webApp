$(function() {
	if($.fn.cookie('id')) {
		$.ajax({
			type: "post",
			url: "../../PHP/home/Foods/dgwc",
			async: true,
			contentType: 'application/x-www-form-urlencoded',
			dataType: "json",
			success: function(data) {
				if(data === 1) {
					alert('商品未达起送价，请重新购买商品');
					window.location.href = '../TakeawayShop/TakeawayShop.html';
				} else {
					$('#pay-page .shop-img').attr('src', '.' + data.ok.headpic);
					$('#pay-page .order-money .money-num').text(data.ok.money);
					$('#pay-page .ordernum-con .order-num').text(data.ok.newid);
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
		$('#discount-con,#cardlist-con').show();
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