$(function(){
	const img = new Image();
	img.src = localStorage.avatar;
	img.onload = function(){
		const canvasBox = document.getElementById('image-box');
		const ctx = canvasBox.getContext('2d');
		let imgScale = img.width/img.height;
		let boxScale = $('.avatar-con').width()/$('.avatar-con').height();
		if(imgScale<boxScale){
			img.height = $('.avatar-con').height();
			img.width = img.height*imgScale;
		}else{
			img.width = $('.avatar-con').width();
			img.height = img.width/imgScale;
		};
		canvasBox.width = img.width;
		canvasBox.height = img.height;
		ctx.drawImage(img,0,0,img.width,img.height);
//		裁剪区域
		const coverBox = document.getElementById('cover-box');
		const cotx = coverBox.getContext('2d');
		coverBox.width = 100;
		coverBox.height = 100;
		let relativeTop = $('#cover-box').offset().top-$('#image-box').offset().top;
		let relativeLeft = $('#cover-box').offset().left-$('#image-box').offset().left;
		var coverData =  ctx.getImageData(relativeLeft,relativeTop,$('#cover-box').width(),$('#cover-box').height());
		cotx.putImageData(coverData,0,0);
		//	裁剪区域移动
		var flag = false;
		var cur = {
			x:0,
			y:0
		};
		var dur = {
			dx:0,
			dy:0
		};
		var cdisx,cdisy,disx,disy;
		var borderx = $('.img-con').width()-$('#cover-box').width();
		var bordery = $('.img-con').height()-$('#cover-box').height();
		console.log(borderx,bordery);
		$('#cover-box').on('touchstart',function(){
			flag = true;
			let touch;
			if(event.touches){
				touch = event.touches[0];
			}else{
				touch = event;
			};
			cur.x = touch.clientX;
			cur.y = touch.clientY;
			dur.dx = $('#cover-box').offset().left-$('.img-con').offset().left;
			dur.dy = $('#cover-box').offset().top-$('.img-con').offset().top;
		});
		$('#cover-box').on('touchmove',function(){
			event.preventDefault();
			if(flag){
				let touch;
				if(event.touches){
					touch = event.touches[0];
				}else{
					touch = event;
				};
				cdisx = touch.clientX-cur.x;
				cdisy = touch.clientY-cur.y;
				disx = dur.dx+cdisx;
				disy = dur.dy+cdisy;
				if(disx<0){
					disx = 0;
				};
				if(disx>borderx){
					disx = borderx;
				};
				if(disy<0){
					disy = 0;
				};
				if(disy>bordery){
					disy = bordery;
				};
				$(this).css({
					left:disx,
					top:disy
				});
				let relativeTop = $('#cover-box').offset().top-$('#image-box').offset().top;
				let relativeLeft = $('#cover-box').offset().left-$('#image-box').offset().left;
				var coverData =  ctx.getImageData(relativeLeft,relativeTop,$('#cover-box').width(),$('#cover-box').height());
				cotx.putImageData(coverData,0,0);
			}
		});
		$('#cover-box').on('touchend',function(){
			flag = false;
		});
		const ndata = coverBox.toDataURL('image.jepg',1);
//		ajax



	};

})
