$(function(){
	language();
	if(!$.fn.cookie('id')) {
		window.location.href = '../Login/Login.html';
	};
	$('.determine-btn').on('tap',function(){
		window.location.href='../UserSetting/UserSetting.html';
	});
})
