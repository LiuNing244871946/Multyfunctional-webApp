$(document).ready(function(){
	var cityArr = [];
	$.getJSON('/kintime-webapp/json/city.json',function(json){
		$.each(json, function(index,city) {
			var city = city;
			cityArr.push(city);
		});
		var letters = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
		var citySort = {};
		var insetStr = floatStr = '';
		var cityABC = [];
		for( var i = 0;i<cityArr.length;i++){
			var first = pinyinUtil.getFirstLetter(cityArr[i].name);
			first = first.length>1?first.substring(0,1):first;
			if(citySort[first] == undefined){
				citySort[first] = [];
			};
			citySort[first].push(cityArr[i]);
		};
		for(var i = 0;i<26;i++){
			var print = citySort[letters[i]];
			if(citySort[letters[i]]!=undefined){
				cityABC.push(letters[i]);
				insetStr += '<dl id="'+letters[i]+'"<dt><a name="'+letters[i]+'">'+letters[i]+'</a></dt>'
				for(var j = 0;j<print.length;j++){
					insetStr += '<dd>'+print[j].name+'</dd>'
				};
				insetStr += '</dl>';
			}
		};
		$('#city-list').append(insetStr);
	});
	
})
