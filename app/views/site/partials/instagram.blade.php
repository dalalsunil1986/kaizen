<style>
.instagramWraper{
    text-align: right;
}
.media-grid .item {
    float:right;
}
</style>
<div id="side-instagram" class="hidden-xs">
    <div class="panel panel-default">
        <div class="panel-heading">{{ Lang::get('site.general.instagram') }}</div>
        <div class="panel-body instagramWraper">
            <iframe id="instagram" src="http://www.intagme.com/in/?u=a2FpemVuX2NvbXBhbnl8aW58MTY1fDN8M3x8eWVzfDV8dW5kZWZpbmVkfG5v" allowTransparency="true" frameborder="0" scrolling="no" style="border:none; overflow:hidden; width:520px; height: 520px" ></iframe>
        </div>
    </div>
</div>
<div id="side-instagram" class="visible-xs">
    <div class="panel panel-default">
        <div class="panel-heading">{{ Lang::get('site.general.instagram') }}</div>
        <div class="panel-body">
<!-- www.intagme.com -->
<!-- www.intagme.com -->
        {{--<iframe src="http://www.intagme.com/in/?u=a2FpemVuX2NvbXBhbnl8aW58MTUwfDF8M3x8eWVzfDV8dW5kZWZpbmVkfHllcw==" allowTransparency="true" frameborder="0" scrolling="no" style="border:none; overflow:hidden; width:165px; height: 495px" ></iframe>--}}

        </div>
    </div>
</div>

<script>
    $('iframe').load(function() {
           alert('rady');
    });
</script>