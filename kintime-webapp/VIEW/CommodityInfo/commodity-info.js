// 删除商品
function deleteShop(){
    $('#mask').css({
        display:'block',
        height:$(document).height()
    });
    var $sureBox = $('.sure-box');
    var $cancelBox = $('.cancel-box');
    $sureBox.css({
        display : 'block',
        display : 'flex'
    })
    $cancelBox.css({
        display : 'block',
        display : 'flex'
    })
}
function cancelDelete(){
    $('#mask,.sure-box,.cancel-box').css('display','none');
}
function selectionSort(){
    $('#mask').css({
        display:'block',
        height:$(document).height()
    });
    var $sortList = $('.sort-list-box');
    $sortList.css({
        display : 'block',
        display : 'flex'
    })
}