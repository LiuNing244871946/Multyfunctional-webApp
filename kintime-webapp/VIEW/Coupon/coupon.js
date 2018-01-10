$(function(){
    $.ajax({
        type:"post",
        url:"../../PHP/home/foods/takeaway_pay",
        async:true,
        contentType:"application/x-www-form-urlencoded",
        dataType:"json",
        success:function(res){
            console.log(res);
            if(res.hao){
                var arr1 = res.hao;
                var htmlNodes = '';
                for(var i=0;len=arr1.length,i<len;i++){
                    htmlNodes += '<div class="coupon-main-list"><div class="coupon-list-left"><span class="list-left1">'+ arr1[i].name +'</span><span class="list-left2">'+"有效期至：" + arr1[i].time+'</span><span class="list-left3">'+"满" + arr1[i].tj +"元可用"+'</span></div><div class="coupon-list-right"><p class="list-right1">'+"₭" + arr1[i].djin +'</p><button class="list-right2">使用</button></div></div>';
                }
                $(".coupon-main").append(htmlNodes);
            }
            // else if(res.mei){
            //     var arr2 = res.mei;
            //     for(var i=0;len=arr2.length,i<len;i++){
            //         $(".coupon-list-left .list-left1").text(arr2[i].name);
            //     }
            // }
        },
        error:function(e){
            console.log(e);
        }
    })
})