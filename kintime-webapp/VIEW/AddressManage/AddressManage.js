$(function() {
	language();
	if($.fn.cookie('id')) {
		$.ajax({
			type: "post",
			url: "../../PHP/home/foods/address",
			async: true,
			contentType: 'application/x-www-form-urlencoded',
			dataType: "json",
			success: function(data) {
				if(data.dzid !== 0) {
					var str = '';
					$.each(data, function(index, item) {
						if(item.id) {
							str += '<li class="address-item" data-ad="' + item.id + '"><div class="address-info"><div class="address-text-con">' + item.address + item.xiaddress + '</div><div class="address-text-con"><span class="name-con">' + item.linkman + '';
							if(item.sex === '1') {
								str += '先生</span><span class="phone-con">' + item.phone + '</span></div></div><span class="select-con"><span class="edit-con"><i class="iconfont icon-edit"></i></span><span class="back-con"><i class="iconfont icon-ok"></i></span></span></li>';
							} else {
								str += '女士</span><span class="phone-con">' + item.phone + '</span></div></div><span class="select-con"><span class="edit-con"><i class="iconfont icon-edit"></i></span><span class="back-con"><i class="iconfont icon-ok"></i></span></span></li>';
							};
						};
					});
					$('.address-list').append(str);
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

	$('.determine').on('tap', function() {
		$(this).hide();
		$('#cancel').show();
		$('.add-address').hide();
		$('#delete-address').show();
		$('.edit-con').hide();
		$('.back-con').css('display', 'block');
	});
	$('#cancel').on('tap', function() {
		$(this).hide();
		$('.determine').show();
		$('.add-address').show();
		$('#delete-address').hide();
		$('.edit-con').show();
		$('.back-con').css('display', 'none');
	});
	$('.address-list').on('tap', '.address-item', function() {
		if($(this).find('.edit-con').css('display') === 'none') {
			$(this).toggleClass('select');
		} else {
			window.location.href = '../AddressModify/AddressModify.html?' + $(this).data('ad');
		};
	});
	$('.add-address').on('tap', function() {
		window.location.href = '../AddressAdd/AddressAdd.html';
	});
	$('#delete-address').on('tap', function() {
		var data = {};
		data.id = '';
		$('.address-item.select').each(function(index) {
			data.id += $(this).data('ad') + ',';
		});
		var jsonStr = JSON.stringify(data);
		$.ajax({
			type: "post",
			url: "../../PHP/home/foods/del_address",
			async: true,
			contentType: 'application/x-www-form-urlencoded',
			dataType: "json",
			data: jsonStr,
			success: function(data) {
				if(data === 1) {
					$('.address-item.select').toggle();
				} else {
					alert('删除失败');
				};
			},
			error: function(e) {
				console.log(e);
			}
		});
	});
	$('.icon-fanhui').on('tap', function() {
		window.location.href='../Home/Home.html';
	});
})