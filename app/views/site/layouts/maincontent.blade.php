@section('maincontent')
<div id="youtube_main" class="row">

   <iframe style="width:100%; min-height:250px; height: 350px; max-height: 350px; padding-top: 18px; margin:0px; "
            src="//www.youtube.com/embed/N6KpbdJVWIY?list=PLgziGzRnamoJ4ESrNu5Yhtzqc4j-Mer3_" frameborder="0" allowfullscreen></iframe>
    <script src="https://apis.google.com/js/platform.js"></script>
    <div class="g-ytsubscribe" data-channel="GoogleDevelopers"></div>
</div>
<div id="youtube_playlist" class="row">
    <?php
    $playlistdiv = '';
    $json = json_decode(file_get_contents('http://gdata.youtube.com/feeds/api/playlists/PLgziGzRnamoJ4ESrNu5Yhtzqc4j-Mer3_?v=2&alt=jsonc'));

    for($i=0; $i<= 3; $i++) {
        $playlistdiv .= '<div class="col-md-3"><a href="'.$json->data->items[$i]->video->player->default.'">
        <img class="img-thumbnail" src="'.$json->data->items[$i]->video->thumbnail->sqDefault.'"/></a>
        <p>'.$json->data->items[$i]->video->title.'</p>
        </div>';
    }
    echo $playlistdiv;
    ?>
</div>

<div id="side-instagram">
    <div class="panel panel-default">
        <div class="panel-heading">انستجرام</div>
        <div class="panel-body">
            <!-- <iframe id="instimg-iframe" src="http://imageagram.com/grid.php?q=u&search=Kaizen_co&wt=in&s=180&h=3&w=3&b=no&c=&p=35&ho=fadeOut&sh=no" allowTransparency="true" frameborder="0" scrolling="no" style="border:none; overflow:hidden; width:651px; height: 651px" ></iframe> -->
            <iframe id="instimg-iframe" src="http://imageagram.com/grid.php?q=u&search=Kaizen_co&wt=in&s=120&h=3&w=3&b=no&c=&p=5&ho=none&sh=yes" allowTransparency="true" frameborder="0" scrolling="no" style="border:none; overflow:hidden; width:381px; height: 381px" ></iframe>
        </div>
    </div>
</div>

@stop