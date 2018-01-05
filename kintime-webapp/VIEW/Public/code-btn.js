$(function(){
	$('#send-sms').on('tap', function() {
		if(!$(this).hasClass('disable')){
			var data = {};
			data.type = document.getElementById('area-code').selectedIndex;
			data.phone = $('#area-code').val()+$('#phone').val();
			var jsonStr = JSON.stringify(data);
			$.ajax({
				type: "POST",
				url: "../../PHP/home/foods/fasong",
				contentType: 'application/x-www-form-urlencoded',
				data: jsonStr,
				dataType: "json",
				success: function(){
				},
				error: function(e) {
					console.log(e);
				}
			});
			$(this).addClass('disable');
			$('.allow-text').hide();
			$('.time-text').show();
			$('#send-sms .num').text(60);
			var timer = setInterval(function() {
				var time = Number($('#send-sms .num').text());
				if(time == 0) {
					clearInterval(timer);
					$('#send-sms').removeClass('disable');
					$('.allow-text').show();
					$('.time-text').hide();
				} else {
					time--;
					$('#send-sms .num').text(time);
				}
			}, 1000);
		}else{
			return false;
		};
	});
})
