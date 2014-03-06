$(document).ready(function () {
    $('#fav').click(function () {
        alert('add To Fav');
    }).hover(function () {
       // alert('working');
       $(this).toggleClass('glyphicon glyphicon-star');
    });
});
