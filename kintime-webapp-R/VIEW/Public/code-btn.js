$(function(){
	$('#code-btn').on('tap', function() {
		if(!$(this).hasClass('disable')){
			$(this).addClass('disable');
			$(this).attr('disabled',true);
			$('#time').text(60);
			var timer = setInterval(function() {
				var time = Number($('#time').text());
				if(time == 0) {
					clearInterval(timer);
					$('#code-btn').removeClass('disable');
					$('#code-btn').attr('disabled',false);
				} else {
					time--;
					$('#time').text(time);
				}
			}, 1000);
		}else{
			return false;
		};
	});
})
