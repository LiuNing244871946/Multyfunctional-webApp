$(function() {
	if($.fn.cookie('id')) {
		$.ajax({
			type: "post",
			url: "../../PHP/home/money/qian_yu",
			async: true,
			contentType: 'application/x-www-form-urlencoded',
			dataType: "json",
			success: function(data) {
				if(data.jguo === 1) {
					$('#balance-num .number').text(data.qian);
				} else if(data.jguo === 2) {
					alert('查询余额失败')
				};
			},
			error: function(e) {
				console.log(e);
			}
		});
	} else {
		window.location.href = '../Login/Login.html';
	};
	$('#widthdraw').on('tap', function() {
		$.ajax({
			type: "post",
			url: "../../PHP/home/money/qian_ti",
			async: true,
			contentType: 'application/x-www-form-urlencoded',
			dataType: "json",
			success: function(data) {
				if(data === 2) {
					window.location.href = '../WidthDraw/WidthDraw.html';
				} else if(data === 1) {
					$('#discount-con,#tip-con').show();
				};
			},
			error: function(e) {
				console.log(e);
			}
		});
	});
	$('#recharge').on('tap',function(){
		window.location.href='../Recharge/Recharge.html';
	})
	$('.determine-btn').on('tap', function() {
		$('#discount-con,.discount-item').hide();
	});
})