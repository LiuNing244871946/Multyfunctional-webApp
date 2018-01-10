$(function(){
	if($.fn.cookie('id')) {
		
	} else {
		window.location.href = '../Login/Login.html';
	};
	var menuTop = $('.shop-menu').offset().top;
	var scrollDis = menuTop - $('.top-navbar').height();
	var menuHeight = window.screen.availHeight-$('footer').offset().height-$('header').offset().height;
	var mainCon = menuHeight+$('.shop-info').offset().height+$('footer').offset().height;
	$('.shop-menu').css('height',menuHeight);
	$('.main-con').css('height',mainCon);
	$(window).scroll(function(){
		if($(window).scrollTop()>scrollDis-10){
			$('.top-navbar').addClass('active');
		};
		if($('.top-navbar').hasClass('active')){
			$('.main-con').addClass('fixed');
			if($(window).scrollTop()<$('.top-navbar').height()){
				$('.top-navbar').removeClass('active');
				$('.main-con').removeClass('fixed');
			};
		};
	});
//	左右侧联动
	$('.left-menu-item').on('tap',function(){
		var rightScroll = 0;
		for(var i=0;i<$(this).index();i++){
			rightScroll +=$('.right-menu-item').eq(i).height();
		};
		$(window).scrollTop(scrollDis);
		$('.left-menu-item').removeClass('active');
		$(this).addClass('active');
		$('.right-menu').scrollTop(rightScroll);
	});
//	菜品数量
	$('.add-btn').on('tap',function(){
		if($('.order-num').text()<99){
			var listItem = $(this).parents('.dish-item');
			var foodNum = parseInt(listItem.find('.num-con').text());
			foodNum++;
			listItem.find('.num-con').text(foodNum);
			listItem.addClass('selected');
			var orderNum = parseInt($('.order-num').text());
			orderNum++;
			$('.order-num').text(orderNum);
			$('.menu-footer').addClass('active');
		}else{
			return false;
		}
	});
	$('.less-btn').on('tap',function(){
		var listItem = $(this).parents('.dish-item');
		var foodNum = parseInt(listItem.find('.num-con').text());
		foodNum--;
		var orderNum = parseInt($('.order-num').text());
		orderNum--;
		$('.order-num').text(orderNum);
		if(foodNum === 0){
			listItem.find('.num-con').text(foodNum);
			listItem.removeClass('selected');
			if(orderNum === 0){
				$('.menu-footer').removeClass('active');
			}
		}else{
			listItem.find('.num-con').text(foodNum);
			listItem.addClass('selected');
		};
	});
//	订单展示
	$('.menu-footer .order-img').on('tap',function(){
		if($('.menu-footer').hasClass('active')){
			$('#discount-con,#order-list').toggle();
		}else{
			return false;
		};
	});
//	规格展示
	$('.dish-item-s .numbtn-con').on('tap',function(){
		$('#discount-con,#norm-con').show();
		var dishItemSIndex = $('.dish-item-s').index($(this).parents('.dish-item-s'));
//		$('.joincart').on('tap',function(){
//			$('.discount-con,.discount-item').hide();
//			if($('.order-num').text()<99){
//				var listItem = $('.dish-item-s').eq(dishItemSIndex);
//				var foodNum = parseInt(listItem.find('.num-con').text());
//				foodNum++;
//				listItem.find('.num-con').text(foodNum);
//				listItem.addClass('selected');
//				var orderNum = parseInt($('.order-num').text());
//				orderNum++;
//				$('.order-num').text(orderNum);
//				$('.menu-footer').addClass('active');
//			}else{
//				return false;
//			}
//		});
	});
	$('.norm-item .option-item').on('tap',function(){
		$(this).parent().children('.option-item').removeClass('selected');
		$(this).addClass('selected');
	});
	$('#discount-con').on('tap',function(e){
		e.stopPropagation();
		$('#discount-con,.discount-item').hide();
	});
	$('.discount-item').on('tap',function(e){
		e.stopPropagation();
	});
//	$('.joincart').on('tap', function() {
//		$('.discount-con,.discount-item').hide();
//		if($('.order-num').text() < 99) {
//			var listItem = $('.dish-item-s').eq(dishItemSIndex);
//			var foodNum = parseInt(listItem.find('.num-con').text());
//			foodNum++;
//			listItem.find('.num-con').text(foodNum);
//			listItem.addClass('selected');
//			var orderNum = parseInt($('.order-num').text());
//			orderNum++;
//			$('.order-num').text(orderNum);
//			$('.menu-footer').addClass('active');
//		} else {
//			return false;
//		}
//	});
})
