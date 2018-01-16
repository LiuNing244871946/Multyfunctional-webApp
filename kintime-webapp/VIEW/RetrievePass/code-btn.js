$(function(){
//	原手机
	$('#send-sms').on('tap', function() {
		if(!$(this).hasClass('disable')){
			var data = {};
			if($('#oldphone').val().substring(0,2)==='86'){
				data.type = '0';
			}else if($('#oldphone').val().substring(0,2)==='85'){
				data.type = '1';
			}
			data.phone = '';
			data.typee = '2';
			var jsonStr = JSON.stringify(data);
			$.ajax({
				type: "POST",
				url: "../../PHP/home/foods/fasong",
				contentType: 'application/x-www-form-urlencoded',
				dataType: "json",
				data:jsonStr,
				success: function(data){
				},
				error: function(e) {
					console.log(e);
				}
			});
			$(this).addClass('disable');
			$('#send-sms .allow-text').hide();
			$('#send-sms .time-text').show();
			$('#send-sms .num').text(60);
			var timer = setInterval(function() {
				var time = Number($('#send-sms .num').text());
				if(time == 0) {
					clearInterval(timer);
					$('#send-sms').removeClass('disable');
					$('#send-sms .allow-text').show();
					$('#send-sms .time-text').hide();
				} else {
					time--;
					$('#send-sms .num').text(time);
				}
			}, 1000);
		}else{
			return false;
		};
	});
//	新手机
	$('#newsend-sms').on('tap', function() {
		if(!$(this).hasClass('disable')){
			var data = {};
			data.type = document.getElementById('area-code').selectedIndex;
			data.phone = $('#area-code').val()+$('#newphone').val();
			console.log(data);
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
			$('#newsend-sms .allow-text').hide();
			$('#newsend-sms .time-text').show();
			$('#newsend-sms .num').text(60);
			var timer = setInterval(function() {
				var time = Number($('#newsend-sms .num').text());
				if(time == 0) {
					clearInterval(timer);
					$('#newsend-sms').removeClass('disable');
					$('#newsend-sms .allow-text').show();
					$('#newsend-sms .time-text').hide();
				} else {
					time--;
					$('#newsend-sms .num').text(time);
				}
			}, 1000);
		}else{
			return false;
		};
	});
})
