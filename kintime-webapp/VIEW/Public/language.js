function language() {
	$('[set-lan]').each(function() {
		var me = $(this);
		var a = me.attr('set-lan').split(':');
		var p = a[0];
		var m = a[1];
		var t;
		var lan = $.fn.cookie('lan');
		switch(lan) {
			case 'zh':
				$.getJSON('/kintime-webapp/json/zh.json', function(json) {
					t = json[0][m];
					switch(p) {
						case 'html':
							me.html(t);
							break;
						case 'val':
							me.val(t);
							break;
						case 'placeholder':
							me.attr('placeholder', t);
							break;
					};
				});
				break;
			case 'lao':
				$.getJSON('/kintime-webapp/json/lao.json', function(json) {
					t = json[0][m];
					switch(p) {
						case 'html':
							me.html(t);
							break;
						case 'val':
							me.val(t);
							break;
						case 'placeholder':
							me.attr('placeholder', t);
							break;
					};
				});
				break;
			case 'en':
				$.getJSON('/kintime-webapp/json/en.json', function(json) {
					t = json[0][m];
					switch(p) {
						case 'html':
							me.html(t);
							break;
						case 'val':
							me.val(t);
							break;
						case 'placeholder':
							me.attr('placeholder', t);
							break;
					};
				});
				break;
		};
	});
};