<?php

//引入核心库文件

include "phpqrcode/phpqrcode.php";

//定义纠错级别

$errorLevel = "L";

//定义生成图片宽度和高度;默认为3

$size = "8";

//定义生成内容

$content="http://www.baidu.com";

//调用QRcode类的静态方法png生成二维码图片//

QRcode::png($content, false, $errorLevel, $size);

//生成网址类型

/*$url="http://www.baudu1.html";

$url.="\r\n";

$url.="http://www.baudu2.html";

$url.="\r\n";

$url.="http://www.baudu3.html";

QRcode::png($url, false, $errorLevel, $size);*/


?>