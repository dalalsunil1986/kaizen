$(document).ready(function () {

    // tooltip activation
    $("[data-toggle=tooltip]").tooltip();

    // EventController Favorite btn
    $('#fav_btn').click(function () {
        alert('add To Fav');
    });

    jQuery(function($) {
        $("tr[data-link]").click(function() {
            window.location = this.dataset.link
        });
    });
            $('#myCarousel').on('slid.bs.carousel', function () {
                    
                // Get currently selected item
                var orderSlide = $('#myCarousel .carousel-inner .item.active').data('order');
                
                // Deactivate all nav links
                $('.tag').removeClass('active-tab-slide');

                var slideNumber = "#slide" + orderSlide;
                
                $(slideNumber).addClass('active-tab-slide');
            });

            $( "#slide0" ).on( "click", function() {
                
                $('.carousel').carousel(0); 
                activatTab($(this));
            });

            $( "#slide1" ).on( "click", function() {
                
                $('.carousel').carousel(1); 
                activatTab($(this));
            });

            $( "#slide2" ).on( "click", function() {
                
                $('.carousel').carousel(2); 
                activatTab($(this));
            });

            $( "#slide3" ).on( "click", function() {
                
                $('.carousel').carousel(3); 
                activatTab($(this));
            });

            $( "#slide4" ).on( "click", function() {
                
                $('.carousel').carousel(4); 
                activatTab($(this));
            });
});

function activatTab(tab){
    $('.tag').removeClass('active-tab-slide');

    tab.addClass('active-tab-slide');
}
