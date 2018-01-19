$(function(){
    $(".swiper-slide").on("tap",function(e){
        var data = {};
        data.num = $(e.target).attr("id");
        var jsonStr = JSON.stringify(data);
        console.log(data.num);
        $.ajax({
            type:"post",
            url:"../../PHP/home/wmddan",
            async:true,
            contentType:"application/x-www-form-urlencoded",
            dataType:"json",
            data:jsonStr,
            success:function(res){
                console.log(res);
                var htmlNodes = '';
                for(var i=0;len=res.length,i<len;i++){
                    htmlNodes += '<div class="will-consume-box"><p class="will-consume-title"><span class="shop-name">'+res[i].name+'</span><span class="will-consume-word">'+res[i].ztai+'</span></p><div class="will-consume-content"><div class="content-left"><img class="content-left-img" src="'+"."+(res[i].headpic)+'" /></div><div class="content-right"><div class="content-right-top"><p class="content-right-left"><span class="content-right-top1">'+res[i].cainame+'</span><span class="content-right-top2">'+"下单时间"+res[i].time+'</span></p><p class="icon-box"><i class="iconfont icon-next"></i></p></div><div class="content-right-bottom"><p class="content-right-bottom1"><span class="all-count">总计：</span><span class="money-num">'+"₭"+res[i].you+'</span></p><button class="view-code">'+res[i].lxphone
                    +'</button></div></div></div></div>';
                }
                $(".takeout-order-list").html(htmlNodes);
            },
            error:function(e){
                console.log(e);
            }
        })
    })
})