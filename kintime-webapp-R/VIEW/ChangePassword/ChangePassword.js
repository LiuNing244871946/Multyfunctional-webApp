$(function() {
	$('input').focus(function() {
		if($(this).val() == "请输入手机号"|| $(this).val() == "请输入新验证码") {
			$(this).attr('type', 'number');
			$(this).val("");
		};
	});
	$('input').focus(function() {
		if($(this).val() == "请输入新密码"|| $(this).val() == "请再输入一遍密码") {
			$(this).attr('type', 'password');
			$(this).val("");
		};
	});
	$('#phone').blur(function() {
		if($(this).val() == "") {
			$(this).attr('type', 'text');
			$(this).val("请输入手机号");
		};
	});
	$('#vercode').blur(function() {
		if($(this).val() == "") {
			$(this).attr('type', 'text');
			$(this).val("请输入新验证码");
		};
	});
	$('#newpassword1').blur(function() {
		if($(this).val() == "") {
			$(this).attr('type', 'text');
			$(this).val("请输入新密码");
		};
	});
	$('#newpassword2').blur(function() {
		if($(this).val() == "") {
			$(this).attr('type', 'text');
			$(this).val("请再输入一遍密码");
		};
	});
})