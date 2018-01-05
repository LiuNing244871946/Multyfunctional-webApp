$(function(){
	//筛选事件
	$('.fav-title .fav-title-item').on('click', function(e) {
		$('.fav-title').addClass('fixed');
		$('.fav-discon').css('display', 'block');
		if($(this).hasClass('active')) {
			$('.fav-title').removeClass('fixed');
			$('.fav-title .fav-title-item').removeClass('active');
			$('.fav-discon').css('display', 'none');
		} else {
			$('.fav-title .fav-title-item').removeClass('active');
			$(this).addClass('active');
			$('.fav-discon-see div').removeClass('active');
			$('.fav-discon-see div').eq($(this).index()).addClass('active');
		};

	});
	$('.fav-discon').on('click', function(e) {
		if(e.target == this) {
			$('.fav-title').removeClass('fixed');
			$('.fav-title .fav-title-item').removeClass('active');
			$('.fav-discon').css('display', 'none');
		};
	});
	$('.category-wrapper a,.biz-wrapper a,.sort-wrapper a').on('click', function(e) {
		$(this).parent().find('a').removeClass('active');
		$(this).addClass('active');
		$('.fav-title-item.active .item-text span').text($(this).find('span:first-child').text());
		$('.fav-title').removeClass('fixed');
		$('.fav-title .fav-title-item').removeClass('active');
		$('.fav-discon').css('display', 'none');

	});
	$('.switch-cont.input-checkbox').on('click', function(e) {
		if($(this).find('i').hasClass('icon-checkbox-select')) {
			$(this).find('i').removeClass('icon-checkbox-select');
		} else {
			$(this).find('i').addClass('icon-checkbox-select');
		};
	});
	$('.csp-content .option-wrapper .option').on('click', function(e) {
		$(this).parents('.meal-number-option').find('.option').removeClass('selected');
		$(this).addClass('selected');
	});
	$('.csp-wrapper .operate .reset-button').on('click', function(e) {
		$('.csp-content .switch-cont .icon-checkbox').removeClass('icon-checkbox-select');
		$('.csp-content .meal-number-option .option').removeClass('selected');
		$('.csp-content .meal-number-option .option-wrapper:first-child .option').addClass('selected');
	});
	$('.csp-wrapper .operate .save-button').on('click', function(e) {
		$('.fav-title').removeClass('fixed');
		$('.fav-title .fav-title-item').removeClass('active');
		$('.fav-discon').css('display', 'none');
	});
})
