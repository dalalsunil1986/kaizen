$(document).ready(function () {

    // tooltip activation
    $("[data-toggle=tooltip]").tooltip();

    // EventController Favorite btn
    $('#favorite_btn').click(function () {

       if($('#favorite').hasClass('active')) {
           var behavior = 'unfavorite'
       } else {
           var behavior = 'favorite'
       }

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
                alert(data.message);
            }
        });
    });

    $('#follow_btn').click(function () {
        if($('#follow').hasClass('active')) {
            var behavior = 'unfollow'
        } else {
            var behavior = 'follow'
        }

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
            var behavior = 'subscribe'
        } else {
            var behavior = 'unsubscribe'
        }
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
    })

});


function getPosts(id,action) {
    var params = {
        id: id,
        mode:action
    };
    //	$('#ajax').html(ajax_load).css('text-align','center');
    //	$("#ajax").bind("ajaxStart", function(){
    $("#listings").bind("ajaxStart", function(){
        $(this).html(ajax_load +'').css('text-align','center');
    }).bind("ajaxStop", function(){
        //	$(this).hide();
    });
    $.ajax({
        url: settingsUrl,
        type: 'GET',
        data: $.param(params),
        cache : true,
        dataType: "json",
        error: function(xhr, textStatus, errorThrown) {
            displayError(textStatus);
        },
        success: function(data) {
            //	$('#ajax').empty().remove(); // remove the div inorder not to repeat the contents when clicking second time
            var postHeading = action; // to send the heading
            readPosts(data,postHeading,id);
        }
    });
    return false;
}
