$(function() {
	language();
	if($.fn.cookie('id')) {
		var adId;
		$.ajax({
			type: "post",
			url: "../../PHP/home/foods/m_address",
			async: true,
			contentType: 'application/x-www-form-urlencoded',
			dataType: "json",
			success: function(data) {
				if(data.dzid !== 0) {
					var aId = data.dzid;
					var str = '';
					$.each(data, function(index, item) {
						if(item.id) {
							str += '<li class="address-item" data-ad="' + item.id + '"><div class="address-info"><div class="address-text-con">' + item.address + item.xiaddress + '</div><div class="address-text-con"><span class="name-con">' + item.linkman + '';
							if(item.sex === '1') {
								str += '先生</span><span class="phone-con">' + item.phone + '</span></div></div><span class="select-con"><span class="back-con"><i class="iconfont icon-ok"></i></span></span></li>';
							} else {
								str += '女士</span><span class="phone-con">' + item.phone + '</span></div></div><span class="select-con"><span class="back-con"><i class="iconfont icon-ok"></i></span></span></li>';
							};
						};
					});
					$('.address-list').append(str);
					$('.address-item').each(function(index) {
						if($(this).data('ad') === parseInt(aId)) {
							$(this).addClass('select');
						};
					});
				} else {
					alert('你还没有地址，请先添加地址');
				};
			},
			error: function(e) {
				console.log(e);
			}
		});
	} else {
		window.location.href = '../Login/Login.html';
	};

	$('.address-list').on('tap', '.address-item', function(e) {
		$('.address-item').removeClass('select');
		$(this).addClass('select');
		adId = $(this).data('ad');
	});
	//	确定按钮
	$('.determine').on('tap', function() {
		if(adId === undefined) {
			window.location.href = '../TakeawayPay/TakeawayPay.html';
		} else {
			var data = {};
			data.id = adId;
			data.type = 1;
			var jsonStr = JSON.stringify(data);
			$.ajax({
				type: "post",
				url: "../../PHP/home/foods/dan_dz",
				async: true,
				contentType: 'application/x-www-form-urlencoded',
				dataType: "json",
				data: jsonStr,
				success: function(data) {
					if(data === 1) {
						window.location.href = '../TakeawayPay/TakeawayPay.html';
					} else {
						alert('修改地址失败，请重新修改');
					};
				},
				error: function(e) {
					console.log(e);
				}
			});
		};
	});
	//	添加地址
	$('.add-address').on('tap', function() {
		window.location.href = '../AddressAdd/AddressAdd.html';
	});
	$('.icon-fanhui').on('tap', function() {
		history.back(-1);
	});
})