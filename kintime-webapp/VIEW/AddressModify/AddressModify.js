$(function() {
	language();
	if($.fn.cookie('id')) {
		var data = {};
		data.id = window.location.href.substr(window.location.href.indexOf("?") + 1);
		var jsonStr = JSON.stringify(data);
		$.ajax({
			type: "post",
			url: "../../PHP/home/foods/add_kan",
			async: true,
			contentType: 'application/x-www-form-urlencoded',
			data: jsonStr,
			dataType: "json",
			success: function(data) {
				$('#name').val(data.linkman);
				if(data.sex === '1') {
					$('.sex-con').eq(0).addClass('select');
				} else {
					$('.sex-con').eq(1).addClass('select');
				};
				if(data.phone.substring(0, 2) === '86') {
					$('#area-code').val('中国+86');
					$('#phone').val(data.phone.substring(2, data.phone.length));
				} else {
					$('#area-code').val('老挝+856');
					$('#phone').val(data.phone.substring(3, data.phone.length));
				};
				$('#address0').val(data.address);
				$('#address').val(data.xiaddress);
			},
			error: function(e) {
				console.log(e);
			}
		});
	} else {
		window.location.href = '../Login/Login.html';
	};

	$('#name').on('input', function() {
		$('#tip5').remove();
		if(!$(this).val()) {
			if($('#tip1').length) {
				$('#tip1 .text-con').text('联系人不能为空');
			} else {
				var tip = '<span class="tip-text" id="tip1"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">联系人不能为空</span></span>';
				$('#tip').append(tip);
			};
		} else {
			$('#tip1').remove();
		};
	});
	$('#phone').on('input', function() {
		$('#tip5').remove();
		var phone = $(this).val();
		var phoneArea = document.getElementById('area-code').selectedIndex;
		if((phone.length !== 11 && phoneArea === 0) || (phone.length !== 11 && phoneArea === 1)) {
			if($('#tip2').length) {
				$('#tip2 .text-con').text('手机号格式不正确');
			} else {
				var tip = '<span class="tip-text" id="tip2"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">手机号格式不正确</span></span>';
				$('#tip').append(tip);
			};
		} else {
			$('#tip2').remove();
		};
	});
	$('.sex-con').on('tap', function() {
		$('.sex-con').removeClass('select');
		$(this).addClass('select');
	});
	$('.address-select').on('tap', function() {
		window.location.href = '../AddressMap/AddressMap.html';
	});
	$('#address').on('input', function() {
		$('#tip5').remove();
		if(!$(this).val()) {
			if($('#tip4').length) {
				$('#tip4 .text-con').text('详细地址不能为空');
			} else {
				var tip = '<span class="tip-text" id="tip4"><i class="iconfont icon-shurukuangqingkong"></i><span class="text-con">详细地址不能为空</span></span>';
				$('#tip').append(tip);
			};
		} else {
			$('#tip4').remove();
		};
	});
	$('.add-address').on('tap', function() {
		var data = {};
		data.id = window.location.href.substr(window.location.href.indexOf("?") + 1);;
		data.name = $('#name').val();
		if($('.sex-con.select').text() === '先生') {
			data.sex = 1;
		} else {
			data.sex = 0;
		};
		data.phone = $('#area-code').val() + $('#phone').val();
		data.address = $('#address0').val();
		data.xiaddress = $('#address').val();
		data.jing = 30.2684079898;
		data.wei = 120.2283668518;
		var jsonStr = JSON.stringify(data);
		console.log(data);
		$.ajax({
			type: "post",
			url: "../../PHP/home/foods/add_change",
			async: true,
			contentType: 'application/x-www-form-urlencoded',
			data: jsonStr,
			dataType: "json",
			success: function(data) {
				if(data === 1) {
					history.back(-1);
				} else {
					alert('修改地址失败，请重试');
				}
			},
			error: function(e) {
				console.log(e);
			}
		});
	});
})