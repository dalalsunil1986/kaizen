$(document).ready(function () {
    // tooltip activation
    $("[data-toggle=tooltip]").tooltip();

    // EventController Favorite btn
    $('#favorite_btn').click(function () {
//        $('#favorite_btn').prop('title','unfavorite');
        if($('#favorite').hasClass('active')) {
           var behavior = 'unfavorite';
        } else {
           var behavior = 'favorite';
        }
        //change tooltip text
        $('#favorite_btn').tooltip('hide')
            .attr('title', behavior)
            .tooltip('fixTitle')
            .tooltip('show');
        $.ajax({
            url: '/en/event/' + id + '/'+ behavior,
            type: 'GET',
            cache : true,
            dataType: "json",
            error: function(xhr, textStatus, errorThrown) {
                //
            },
            success: function(data) {
                if(data.success) {
                    $('#favorite').toggleClass('active');
                }
                //alert(data.message);
            }
        });
    });

    $('#follow_btn').click(function () {
        if($('#follow').hasClass('active')) {
            var behavior = 'unfollow'
        } else {
            var behavior = 'follow'
        }
        $('#follow_btn').tooltip('hide')
            .attr('title', behavior)
            .tooltip('fixTitle')
            .tooltip('show');
        $.ajax({
            url: '/en/event/' + id + '/'+ behavior,
            type: 'GET',
            cache : true,
            dataType: "json",
            error: function(xhr, textStatus, errorThrown) {
                //
            },
            success: function(data) {
                if(data.success) {
                    $('#follow').toggleClass('active');
                }
                alert(data.message);
            }
        });
    });

    $('#subscribe_btn').click(function () {
        if($('#subscribe').hasClass('active')) {
            var behavior = 'unsubscribe'
        } else {
            var behavior = 'subscribe'
        }
        $('#subscribe_btn').tooltip('hide')
            .attr('title', behavior)
            .tooltip('fixTitle')
            .tooltip('show');
        $.ajax({
            url: '/en/event/' + id + '/'+ behavior,
            type: 'GET',
            cache : true,
            dataType: "json",
            error: function(xhr, textStatus, errorThrown) {
                //
            },
            success: function(data) {
                if(data.success) {
                    $('#subscribe').toggleClass('active');
                }
                alert(data.message);
            }
        });
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

