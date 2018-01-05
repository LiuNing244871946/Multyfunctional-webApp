$("#pwd-input").on("input", function() {  
    // trim(): 去两边空格的方法；
    var pwd = $(this).val().trim();  
    for (var i = 0; i < pwd.length; i++) {  
        $(".fake-box input").eq(i).val(pwd[i]);  
    }  
    $(".fake-box input").each(function() {  
        var index = $(this).index();  
        if ( index >= pwd.length ) {  
            $(this).val("");  
        }  
    });  
    //当输入达到6位之后，继续输入重置为6
    if (pwd.length > 6) {
        pwd = pwd.substr(0, 6);
        $(this).val(pwd);
        pwd.length = 6;
    }
    if (pwd.length == 6) {  
        //执行其他操作

    }  
});