extends('site.layout.home')
@section('ads')
<!-- Advertisment section-->
<div id="ads-section" class="row">
    @if($ad1)
        <div id="ads-1" class="col-md-6">
            <div class="ads" style="height: 125px;width: 460px; overflow: hidden">
                {{ HTML::image($ad1.'','image1',array('class'=>'img-responsive')) }}
            </div>
        </div>
    @else
        <div id="ads-1" class="col-md-6"><img class="img-responsive" src=" http://placehold.it/550x150"/></div>
    @endif

    @if($ad2)
            {{ HTML::image($ad2.'','image1',array('class'=>'img-responsive')) }}
    @else
        <div id="ads-2" class="col-md-6"><img class="img-responsive" src=" http://placehold.it/550x150"/></div>
    @endif
</div>
@stop