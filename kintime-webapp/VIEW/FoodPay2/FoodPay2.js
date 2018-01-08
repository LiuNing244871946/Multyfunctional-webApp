$(function() {
//	var packId = window.location.href.substr(window.location.href.indexOf("?id=") + 4);
//	var data = {};
//	data.id = packId;
//	var jsonStr = JSON.stringify(data);
//	$.ajax({
//		type: "post",
//		url: "../../PHP/home/foods/kandd",
//		async: true,
//		contentType: 'application/x-www-form-urlencoded',
//		data: jsonStr,
//		dataType: "json",
//		success: function(data) {
//			$('.shop-name').text(data.name);
//			$('tbody .food-name').text(data.tcname);
//			$('#tcPrice .money-num').text(data.tcprice);
//			$('#store-price .money-num').text(data.oldprice);
//			$('.total-price .money-num').text(data.tcprice);
//			$('.must-pay-con .money-num').text(data.tcprice);
//		},
//		error: function(e) {
//			console.log(e);
//		}
//	});
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
	})

})