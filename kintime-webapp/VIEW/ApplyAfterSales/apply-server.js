$(function(){
    // 按钮选项样式的切换
    $(".apply-btn-choose input").on('tap',function(e){
        $(this).siblings("input").removeClass('active');
        $(this).addClass('active');
        type = $(e.target).attr("id");
        // console.log(type);
        return type;
    });
    // 提交
    var commit = document.querySelector(".commit-title");
    commit.addEventListener("tap",function(){
        var data = {};
        data.id = "1";
        data.type = type;
        data.why = $(".inp-word").val();
        console.log(data);
        $.ajax({
            type:"POST",
            url:"../../PHP/home/foods/tui",
            async:true,
            contentType:"application/x-www-form-urlencoded",//内容编码类型
            dataType:"json",//服务器返回的数据类型
            success:function(res){
                console.log(res);
                $(".commit-tips").css("display","none");
                if(data == 1){
                    window.location.href = "../CommitSuccess/commit-success.html";
                }else{
                    $(".commit-tips").css("display","block");
                }
            },
            error:function(e){
                console.log(e);
                alert("数据提交失败");
            }
        })
    })
})



        