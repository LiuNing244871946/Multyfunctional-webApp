//获取店铺
function getShopByType(address,stypeid,num,successfun) {
	var data = {};
	data.address = address;
	data.stypeid = stypeid;
	data.num = num;
	var jsonStr = JSON.stringify(data);
	$.ajax({
		type: "post",
		url: "../../PHP/home/typejz",
		async: true,
		contentType: 'application/x-www-form-urlencoded',
		data: jsonStr,
		dataType: "json",
		success: successfun,
		error: function(e) {
			console.log(e);
		}
	});
};