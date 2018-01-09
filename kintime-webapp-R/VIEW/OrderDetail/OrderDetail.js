$(function(){
	var map = new BMap.Map('map-con');
	map.centerAndZoom(new BMap.Point(121.491, 31.233),11);
	map.addControl(new BMap.NavigationControl());
	var myCity = new BMap.LocalCity();
	var cityName;
	myCity.get(function(result){
		cityName = result.name;
//		map.setCenter(cityName);
		console.log("当前定位城市:"+cityName);
	});
	var myGeo = new BMap.Geocoder();
	var address ='杭州'+$('#start-point .address-street').text()+$('#start-point .address-name').text();
	console.log(address);
	myGeo.getPoint(address,function(point){
		if(point){
			map.centerAndZoom(point,16);
			map.addOverlay(new BMap.Marker(point));
		};
	});
})
