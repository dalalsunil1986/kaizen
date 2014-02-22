@section('maincontent')
<div id="youtube-1">

   <!-- <iframe style="width:100%; min-height:250px; height: 350px; max-height: 350px; padding-top: 18px; margin:0px; "
            src="//www.youtube.com/embed/N6KpbdJVWIY?list=PLgziGzRnamoJ4ESrNu5Yhtzqc4j-Mer3_" frameborder="0" allowfullscreen></iframe>
    <script src="https://apis.google.com/js/platform.js"></script>
    <div class="g-ytsubscribe" data-channel="GoogleDevelopers">-->

        <?php
        $json = json_decode(file_get_contents('http://gdata.youtube.com/feeds/api/playlists/PLgziGzRnamoJ4ESrNu5Yhtzqc4j-Mer3_?v=2&alt=jsonc'));
print_r($json);
        exit;
        $i =0;
        $playlistdiv = '';

                if ($i <= 4) {

               // $media = $playlist->children('http://search.yahoo.')
                echo '<pre>';
                //print_r($playlist);
                //print_r($links->href);
                echo '</pre>';
                    $playlistdiv .= '<div><img src="http://img.youtube.com/vi/'.$json->data->thumbnail->sqDefault.'/default.jpg"/> <h6>'.$json->data->title.'</h6></div>';
                $i++;
                }

        echo $playlistdiv;
        exit;
        ?>
    </div>


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