@section('maincontent')

<div id="youtube_main">

   <iframe style="width:100%; min-height:250px; height: 350px; max-height: 350px; padding-top: 18px; margin:0px; "
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
<div id="side-instagram" class="hidden-xs">
    <div class="panel panel-default">
        <div class="panel-heading">{{ Lang::get('site.general.instagram') }}</div>
        <div class="panel-body">
            <iframe src="http://snapwidget.com/in/?u=a2FpemVuX2NvfGlufDE1MHwzfDN8ZTZlNmU2fHllc3w1fG5vbmV8b25TdGFydHxubw==&v=26414" title="Instagram Widget" allowTransparency="true" frameborder="0" scrolling="no" style="border:none; overflow:hidden; width:495px; height:495px"></iframe>
        </div>
    </div>
</div>
<div id="side-instagram" class="visible-xs">
    <div class="panel panel-default">
        <div class="panel-heading">{{ Lang::get('site.general.instagram') }}</div>
        <div class="panel-body">
            <iframe src="http://snapwidget.com/in/?u=a2FpemVuX2NvfGlufDEwMHwyfDN8ZTZlNmU2fHllc3w1fG5vbmV8b25TdGFydHxubw==&v=26414" title="Instagram Widget" allowTransparency="true" frameborder="0" scrolling="no" style="border:none; overflow:hidden; width:230px; height:345px"></iframe>
        </div>
    </div>
</div>
@stop