$(function() {
	$('input').focus(function() {
		if($(this).val() == "请输入手机号" || $(this).val() == "请输入新手机号" || $(this).val() == "请输入新验证码") {
			$(this).attr('type', 'number');
			$(this).val("");
		};
	});
	$('#oldphone').blur(function() {
		if($(this).val() == "") {
			$(this).attr('type', 'text');
			$(this).val("请输入手机号");
		};
	});
	$('#newphone').blur(function() {
		if($(this).val() == "") {
			$(this).attr('type', 'text');
			$(this).val("请输入新手机号");
		};
	});
	$('#vercode').blur(function() {
		if($(this).val() == "") {
			$(this).attr('type', 'text');
			$(this).val("请输入新验证码");
		};
	});
})