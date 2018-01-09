$(function() {
	$.ajax({
		type: "post",
		url: "../../PHP/home/Foods/dgwc",
		async: true,
		contentType: 'application/x-www-form-urlencoded',
		dataType: "json",
		success: function(data) {
			console.log(data);
			if(data === 1) {
				alert('商品未达起送价，请重新购买商品');
				window.location.href = '../TakeawayShop/TakeawayShop.html';
			} else {
				if(data.address === null) {
					$('.address-info-con .full-con').hide();
					$('.address-info-con .bare-con').show();
				} else {
					$('.address-info-con #address').text(data.address+data.xiaddress);
					$('.address-info-con .name-con').text(data.linkman);
					$('.address-info-con .phone-con').text(data.phone);
				};
				time();
				setInterval(function() {
					time();
				}, 300000);
				$('.shop-name').text(data.name);
				var str = '';
				$.each(data.food, function(index, item) {
					str += '<tr><td class="name">' + item.cainame + '</td><td class="num">x' + item.num + '</td><td class="price"><i class="money">￥</i><span class="money-num">' + item.ji + '</span></td></tr>';
				});
				$('.shop-table tbody').append(str);
				$('.del-money .money-num').text(data.song);
				$('.full-reduc .money-num').text(data.djin);
				if(data.cc) {
					$('.red-enve .red-tip .num-con').text(data.cc);
					$('.pay-money-con .discount-money .money-num').text(parseFloat(data.djin));
				} else if(data.yh) {
					$('.red-enve .red-tip').hide();
					$('.red-enve .money-con').show();
					$('.red-enve .money-con .money-num').text(data.yh);
					$('.pay-money-con .discount-money .money-num').text(parseFloat(data.djin) + parseFloat(data.yh));
				};
				$('.total-price .money-num').text(data.all);
				$('.pay-money-con .must-pay-con .money-num').text(data.all);
				$('#pay-page .shop-img').attr('src','.'+data.ok.headpic);
				$('#pay-page .order-money .money-num').text(data.ok.money);
				$('#pay-page .ordernum-con .order-num').text(data.ok.newid);
			};
		},
		error: function(e) {
			console.log(e);
		}
	});
	//	修改地址
	$('.address-con').on('tap',function(){
		window.location.href='../AddressShipping/AddressShipping.html';
	});
	//	提交订单
	$('.pay-btn-con').on('tap', function() {
		window.location.href='../TakeawayPay2/TakeawayPay2.html';
	});
})

function time() {
	var time = new Date();
	var endH = time.getHours();
	var endM = time.getMinutes();
	endM += 45;
	if(endM > 60) {
		endH += 1;
		endM -= 60;
	}else if(endM === 60) {
		endH += 1;
		endM = '00';
	};
	if(endM<10){
		endM='0'+endM;
	}
	if(endH > 12 && endH < 25) {
		endH -= 12;
	};
	if(endH<10){
		endH='0'+endH;
	};
	$('.time-text-con').text('(约' + endH + ':' + endM + '送达)');
}