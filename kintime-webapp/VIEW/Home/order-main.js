$(function(){
    $("#order-btn").on("tap",function(){
        var id = $.fn.cookie("id");
        $.ajax({
            type:"post",
            url:"../../PHP/home/ddall",
            async:true,
            contentType:"application/x-www-form-urlencoded",
            dataType:"json",
            success:function(res){
                console.log(res);
                var htmlNodes = '';
                for(var i=0;len=res.length,i<len;i++){
                    htmlNodes += '<div class="will-consume-box"><p class="will-consume-title"><span class="shop-name">'+res[i].name+'</span><span class="will-consume-word">'+res[i].ztai+'</span></p><div class="will-consume-content"><div class="content-left"><img class="content-left-img" src="'+"."+(res[i].headpic)+'" /></div><div class="content-right"><div class="content-right-top"><p class="content-right-left"><span class="content-right-top1">'+res[i].cainame+'等'+res[i].num+'件商品</span><span class="content-right-top2">'+"下单时间:"+res[i].time+'</span></p><p class="icon-box"></p></div><div class="content-right-bottom"><p class="content-right-bottom1"><span class="all-count">总计：</span><span class="money-num">'+"₭"+res[i].you+'</span></p><a class="view-code" href="'+"tel:"+ Number(res[i].phone)+'">联系骑手</a></div></div></div></div>';
                }
                $(".current-order-list").html(htmlNodes);
            },
            error:function(e){
                console.log(e);
            }
        })
    })
})