$(function(){
	language();
	if(!$.fn.cookie('id')) {
		window.location.href = '../Login/Login.html';
	};
	$('.input').focus(function(){
		if($(this).val() == '请输入具体位置'){
			$(this).val('');
		};
	});
	$('.input').blur(function(){
		if($(this).val() == ''){
			$(this).val('请输入具体位置');
		};
	});
})
