@section('maincontent')

<div id="youtube_main">

   <iframe style="width:100%; min-height:250px; height: 350px; max-height: 350px; margin:0px; "
            src="//www.youtube.com/embed/N6KpbdJVWIY?list=PLgziGzRnamoJ4ESrNu5Yhtzqc4j-Mer3_" frameborder="0" allowfullscreen></iframe>
    <script src="https://apis.google.com/js/platform.js"></script>
    <div class="g-ytsubscribe" data-channel="KaizenYC"></div>
</div>
<div id="youtube_playlist" class="row">
    <?php
    $playlistdiv = '';
    $json = json_decode(file_get_contents('http://gdata.youtube.com/feeds/api/playlists/PLgziGzRnamoJ4ESrNu5Yhtzqc4j-Mer3_?v=2&alt=jsonc'));

    for($i=0; $i<= 3; $i++) {
        $playlistdiv .= '<div class="col-md-3 col-sm-6 col-xs-6"><a href="'.$json->data->items[$i]->video->player->default.'">
        <img class="img-thumbnail" src="'.$json->data->items[$i]->video->thumbnail->sqDefault.'"/></a>
        <p>'.$json->data->items[$i]->video->title.'</p>
        </div>';
    }
    echo $playlistdiv;
    ?>
</div>
<div class="col-xs-12">

    <div id="recent" class="well well-sm pongstagrm row" data-type="recent">
    </div>
</div>
<!--end of container-->
<script>
    $(document).ready(function(){
        $('#recent').pongstgrm({
            accessId    : 'cd971aa718234a51bb809f74f34c4c04',
            accessToken : 'c354705aa343451a8f15d77317daf6d0',
            show        : 'recent',
            count       : 8,
            pager       : true
        });
    });
</script>
@stop