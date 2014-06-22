<!-- Advertisment section-->
<div id="ads-section" class="row hidden-sm hidden-xs">
    @if($ad1)
    <div id="ads-1" class="col-md-6">
        <div class="ads" >
            {{ HTML::image('uploads/'.$ad1.'','image1',array('class'=>'img-responsive')) }}
        </div>
    </div>
    @endif

    @if($ad2)
    <div id="ads-2" class="col-md-6">
        <div class="ads" >
            {{ HTML::image('uploads/'.$ad2.'','image2',array('class'=>'img-responsive')) }}
        </div>
    </div>
    @endif
</div>