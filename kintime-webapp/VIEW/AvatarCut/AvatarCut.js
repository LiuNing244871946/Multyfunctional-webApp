$(function() {
	language();
	if(!$.fn.cookie('id')) {
		window.location.href = '../Login/Login.html';
	};
	const img = new Image();
	img.src = localStorage.avatar;
	img.onload = function() {
		const canvasBox = document.getElementById('image-box');
		const ctx = canvasBox.getContext('2d');
		let imgScale = img.width / img.height;
		let boxScale = $('.avatar-con').width() / $('.avatar-con').height();
		if(imgScale < boxScale) {
			img.height = $('.avatar-con').height();
			img.width = img.height * imgScale;
		} else {
			img.width = $('.avatar-con').width();
			img.height = img.width / imgScale;
		};
		canvasBox.width = img.width;
		canvasBox.height = img.height;
		ctx.drawImage(img, 0, 0, img.width, img.height);
		//		高亮图片
		const coverBox = document.getElementById('cover-img');
		const ctx2 = coverBox.getContext('2d');
		coverBox.width = canvasBox.width;
		coverBox.height = canvasBox.height;
		ctx2.drawImage(img, 0, 0, img.width, img.height);
		$('#cover-box').width($(window).width() / 2);
		$('#cover-box').height($(window).width() / 2);
		$('#cover-img').css({
			top: '-' + $('#cover-box').css('top'),
			left: '-' + $('#cover-box').css('left')
		});
		//	移动
		var divX=parseFloat($('#cover-box').css('left')),divY = parseFloat($('#cover-box').css('top')), divWidth = $('#cover-box').width(), divHeight = $('#cover-box').height(), touchX, touchY;
		var one = false;
		var twoDistance = 0;
		$('#cover-box').on('touchstart', function() {
			touchX = event.touches[0].clientX;
			touchY = event.touches[0].clientY;
			divX = parseFloat($(this).css('left'));
			divY = parseFloat($(this).css('top'));
			divWidth = $(this).width();
			divHeight = $(this).height();
			if(event.touches.length === 1) {
				one = true;
			} else if(event.touches.length === 2) {
				one = false;
				twoDistance = Math.abs(event.touches[0].clientX - event.touches[1].clientX);
			};
		});
		$('#cover-box').on('touchmove', function() {
			event.preventDefault();
			var divX2 = divX,
				divY2 = divY,
				divWidth2 = divWidth,
				divHeight2 = divHeight;
			if(event.touches.length === 1 && one) {
				divX2 = divX + event.touches[0].clientX - touchX;
				divY2 = divY + event.touches[0].clientY - touchY;
				if(divX2 < 0) {
					divX2 = 0;
				};
				if(divY2 < 0) {
					divY2 = 0;
				};
				if(divX2 + divWidth2 > $('#image-box').width()) {
					divX2 = $('#image-box').width() - divWidth2;
				};
				if(divY2 + divHeight2 > $('#image-box').height()) {
					divY2 = $('#image-box').height() - divHeight2;
				};
			} else if(event.touches.length === 2) {
				divWidth2 = divWidth + (Math.abs(event.touches[0].clientX - event.touches[1].clientX) - twoDistance);
				divHeight2 = divHeight + (Math.abs(event.touches[0].clientX - event.touches[1].clientX) - twoDistance);
				if(divWidth2 < 100) {
					divWidth2 = 100;
					divHeight2 = 100;
				};
				if(divX2 + divWidth2 > $('#image-box').width()) {
					divWidth2 = $('#image-box').width() - divX2;
					divHeight2 = divWidth2;
				};
				if(divY2 + divHeight2 > $('#image-box').height()) {
					divHeight2 = $('#image-box').height() - divY2;
					divWidth2 = divHeight2;
				};
			};
			$(this).css({
				width: divWidth2,
				height: divHeight2,
				left: divX2,
				top: divY2
			});
			$('#cover-img').css({
				top: '-' + $('#cover-box').css('top'),
				left: '-' + $('#cover-box').css('left')
			});
		});
		$('#cover-box').on('touchend', function() {
			one = false;
			$('#cover-img').css({
				top: '-' + $('#cover-box').css('top'),
				left: '-' + $('#cover-box').css('left')
			});
		});
		//	保存
		$('.over').on('tap', function() {
			const saveImg = document.getElementById('save-img');
			const ctx3 = saveImg.getContext('2d');
			saveImg.width = parseFloat($('#cover-box').css('width'));
			saveImg.height = parseFloat($('#cover-box').css('width'));
			var imgData = ctx2.getImageData(parseFloat($('#cover-box').css('left')), parseFloat($('#cover-box').css('top')), parseFloat($('#cover-box').css('width')), parseFloat($('#cover-box').css('height')));
			ctx3.putImageData(imgData, 0, 0,0,0,saveImg.width,saveImg.height);
			var ndata = saveImg.toDataURL('image.jepg', 1);
			var data = {};
			ndata = ndata.substring(22);
			data.img = ndata;
			var imgJsonStr = JSON.stringify(data);
			$.ajax({
				type: "post",
				url: "../../PHP/home/foods/upic",
				async: true,
				contentType: 'application/x-www-form-urlencoded',
				dataType: "json",
				data: imgJsonStr,
				success: function(data) {
					console.log(data);
					switch (data){
						case 1:
							$('#tip').text('保存成功,页面即将跳转');
							break;
						case 2:
							$('#tip').text('保存失败');
							break;
						case 3:
							$('#tip').text('您已退出帐号，请先登录');
							break;
					}
					document.getElementById('tip').style.webkitAnimation = 'tip 3s';
					document.getElementById('tip').addEventListener('webkitAnimationEnd',function(){
						document.getElementById('tip').style.webkitAnimation = '';
						if(data===1){
							window.location.href='../UserSetting/UserSetting.html';
						};
					});
					
				},
				error: function(e) {
					console.log(e);
				}
			});
		});
	};
	$('.icon-fanhui').on('tap',function(){
		window.location.href='../UserSetting/UserSetting.html';
	});
})