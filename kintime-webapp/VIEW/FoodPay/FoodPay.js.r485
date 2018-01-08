$(function() {
	var packId = window.location.href.substr(window.location.href.indexOf("?id=") + 4);
	var data = {};
	data.id = packId;
	var jsonStr = JSON.stringify(data);
	$.ajax({
		type: "post",
		url: "../../PHP/home/foods/kandd",
		async: true,
		contentType: 'application/x-www-form-urlencoded',
		data: jsonStr,
		dataType: "json",
		success: function(data) {
			$('.shop-name').text(data.name);
			$('tbody .food-name').text(data.tcname);
			$('#tcPrice .money-num').text(data.tcprice);
			$('#store-price .money-num').text(data.oldprice);
			$('.total-price .money-num').text(data.tcprice);
			$('.must-pay-con .money-num').text(data.tcprice);
		},
		error: function(e) {
			console.log(e);
		}
	});
	//	提交订单
	$('#order-page .pay-btn-con').on('tap', function() {
		var data ={};
		data.id = packId;
		data.num= 1;
		var jsonStr = JSON.stringify(data);
		$.ajax({
			type: "post",
			url: "../../PHP/home/foods/tjiao",
			async: true,
			contentType: 'application/x-www-form-urlencoded',
			data: jsonStr,
			dataType: "json",
			success: function(data) {
				if(data===2){
					alert('订单提交失败');
				}else if(data===3){
					alert('库存不足');
				}else{
					window.location.href='../FoodPay2/FoodPay2.html?'+data;
				}
			},
			error: function(e) {
				console.log(e);
			}
		});
	});
})