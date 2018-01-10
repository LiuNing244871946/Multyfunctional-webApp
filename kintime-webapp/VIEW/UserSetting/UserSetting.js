$(function() {
	if($.fn.cookie('id')) {
		$.ajax({
			type: "post",
			url: "../../PHP/home/foods/me",
			async: true,
			contentType: 'application/x-www-form-urlencoded',
			dataType: "json",
			success: function(data) {
				if(data !== 1) {
					$('#user-account .text-con').text(data.name);
					if(data.sex === '1') {
						$('#user-sex .text-con').text('男');
					} else if(data.sex === '0') {
						$('#user-sex .text-con').text('女');
					}
					$('#user-name .text-con').text(data.username);
					$('#user-phone .text-con').text(data.phone);
				} else {
					alert('您已退出登录，请重新登录');
				}
			},
			error: function(e) {
				console.log(e);
			}
		});
	} else {
		window.location.href = '../Login/Login.html';
	};

	////	昵称修改
	$('#user-name').on('tap', function(e) {
		$('#discount-con,#user-namecon').show();
		$('#user-newname').val($('#user-name .text-con').text());
		$('#user-newname').on('input propertychange', function() {
			$('#save-btn').addClass('active');
		});
	});
	$('#cancel-btn').on('tap', function() {
		$('#discount-con,.discount-item').hide();
		$('#save-btn').attr('disabled', true);
		$('#save-btn').removeClass('active');
	});
	$('#save-btn').on('tap', function() {
		if($(this).hasClass('active')) {
			$('#discount-con,.discount-item').hide();
			$('#save-btn').attr('disabled', true);
			$('#save-btn').removeClass('active');
			var data = {};
			data.type = 2;
			data.zhi = $('#user-newname').val();
			var jsonStr = JSON.stringify(data);
			$.ajax({
				type: "post",
				url: "../../PHP/home/foods/sex",
				async: true,
				contentType: 'application/x-www-form-urlencoded',
				dataType: "json",
				data: jsonStr,
				success: function(data) {
					if(data === 1) {
						$('#user-name .text-con').text($('#user-newname').val());
					} else {
						alert('保存失败');
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
	//	性别修改
	$('#user-sex').on('tap', function(e) {
		if($('#user-sex .text-con').text() === '男') {
			$('#man').attr('checked', true);
		} else {
			$('#woman').attr('checked', true);
		};
		$('#discount-con,#user-sexcon').show();
	});
	$('#sex-cancel-btn').on('tap', function() {
		$('#discount-con,.discount-item').hide();
	})
	$('#sex-save-btn').on('tap', function() {
		$('#discount-con,.discount-item').hide();
		var data = {};
		data.type = 1;
		if(document.getElementById('man').checked) {
			data.zhi = 1;
		} else {
			data.zhi = 0;
		}
		var jsonStr = JSON.stringify(data);
		$.ajax({
			type: "post",
			url: "../../PHP/home/foods/sex",
			async: true,
			contentType: 'application/x-www-form-urlencoded',
			dataType: "json",
			data: jsonStr,
			success: function(data) {
				console.log(data);
				if(data === 1) {
					if(document.getElementById('man').checked) {
						$('#user-sex .text-con').text('男');
					} else {
						$('#user-sex .text-con').text('女');
					}
				} else {
					alert('保存失败');
				};
			},
			error: function(e) {
				console.log(e);
			}
		});
	});
	//	手机号
	$('#user-phone').on('tap', function() {
		location.href = "../ChangePhone/ChangePhone.html";
	});
	//	密码
	$('#user-password').on('tap', function() {
		location.href = "../ChangePassword/ChangePassword.html";
	})
	//	头像
	$('#user-img').on('tap', function(e) {
		$('#discount-con,#user-avatar').show();
		var file;
		$('#album,#camera').on('change', function(e) {
			$('#discount-con,.discount-item').hide();
			file = e.target.files[0];
			var reader = new FileReader();
			reader.onload = function(e) {
				if(typeof(Storage) !== 'undefined') {
					localStorage.avatar = e.target.result;
					location.href = ('../AvatarCut/AvatarCut.html');
				} else {
					alert("浏览器不支持");
				}
			};
			reader.readAsDataURL(file);
		});
	});
	//	蒙板
	$('#discount-con').on('tap', function(e) {
		$('#discount-con,.discount-item').hide();
	});
	$('.discount-item').on('tap', function(e) {
		e.stopPropagation();
	});
	//	退出登录
	$('#exit-btn').on('tap', function() {
		$.ajax({
			type: "post",
			url: "../../PHP/home/foods/utui",
			async: true,
			contentType: 'application/x-www-form-urlencoded',
			dataType: "json",
			success: function(data) {
				console.log(data);
				switch(data) {
					case 1:
						window.location.href = "../Login/Login.html";
						break;
					case 2:
						alert('退出账号失败');
						break;
				}
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