$(function(){
	language();
	if(!$.fn.cookie('id')) {
		window.location.href = '../Login/Login.html';
	};
})
