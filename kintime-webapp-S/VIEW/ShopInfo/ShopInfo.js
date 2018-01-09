$(function(){
//	保存
	$('.h-save').on('tap',function(){
		$('#discount-con,#save-dis').show();
//		ajax
	});
	$('#save-submit').on('tap',function(){
		$('#discount-con,.discount-item').hide();
	});
//	头像
	$('#shop-img').on('tap',function(){
		$('#discount-con,#img-dis').show();
	});
	$('#img-con').on('tap',function(){
		$('#discount-con,.discount-item').hide();
	});
//	选择头像
	$('#info-ava .item-title').on('tap',function(){
		$('#discount-con,#selectava-dis').show();
		var file;
		$('#album,#camera').on('change',function(e){
			file = e.target.files[0];
			var reader = new FileReader();
			reader.onload = function(e){
				if(typeof(Storage)!=='undefined'){
					localStorage.avatar = e.target.result;
					window.location.href='../AvatarCut/AvatarCut.html';
				}else{
					alert("浏览器不支持");
				}
			};
			reader.readAsDataURL(file);
		});
	});
	$('#selectava-dis').on('tap',function(){
		$('#discount-con,.discount-item').hide();
	});
//	店铺状态
	$('#info-status').on('tap',function(){
		$('#discount-con,#status-dis').show();
	});
	$('#select-status .status-item').on('tap',function(){
		$('#discount-con,.discount-item').hide();
		$('#shop-status').text($(this).text());
	});
})
