$(document).ready(function () {
    $('#fav').click(function () {
        alert('add To Fav');
    }).on('mouseover',function () {
       // alert('working');
       $(this).toggleClass('glyphicon glyphicon-star');
    });
});
