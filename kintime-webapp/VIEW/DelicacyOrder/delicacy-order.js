$(function(){
    $(".swiper-slide").on("tap",function(e){
        var data = {};
        data.num = $(e.target).attr("id");
        var jsonStr = JSON.stringify(data);
        console.log(data.num);
        $.ajax({
            type:"post",
            url:"../../PHP/home/msddan",
            async:true,
            contentType:"application/x-www-form-urlencoded",
            dataType:"json",
            data:jsonStr,
            success:function(res){
                // if(data){
                    console.log(res);
                    var htmlNodes = '';
                    for(var i=0;len=res.length,i<len;i++){
                        htmlNodes += '<div class="will-consume-box"><p class="will-consume-title"><span class="shop-name">'+res[i].name+'</span><span class="will-consume-word">'+res[i].ztai+'</span></p><div class="will-consume-content"><div class="content-left"><img class="content-left-img" src="'+"."+(res[i].headpic)+'" /></div><div class="content-right"><div class="content-right-top"><p class="content-right-left"><span class="content-right-top1">'+res[i].cainame+'</span><span class="content-right-top2">'+"有效期至:"+res[i].yxtime+'</span></p></div><div class="content-right-bottom"><p class="content-right-bottom1"><span class="all-count">总计：</span><span class="money-num">'+"₭"+res[i].you+'</span></p><button class="view-code">'+res[i].ckjm  +'</button></div></div></div></div>';
                    }
                    $(".delicacy-order-list").html(htmlNodes);
                // }
            },
            error:function(e){
                console.log(e);
            }
        })
    })
})