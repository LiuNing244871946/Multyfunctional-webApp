$(function(){
	if(!$.fn.cookie('id')) {
		window.location.href = '../Login/Login.html';
	};
	$('.city-text').focus(function(){
		if($(this).val()=="城市"){
			$(this).val("");
		};
	});
	$('.city-text').blur(function(){
		if($(this).val()==""){
			$(this).val("城市");
		};
	});
	$('.icon-fanhui').on('tap',function(){
		history.back(-1);
	})
})
