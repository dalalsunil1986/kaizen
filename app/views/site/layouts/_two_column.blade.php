<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" >
    @section('content')
    @show
</div>
<div id="sidecontent" class="col-md-4 col-xs-12">
    @section('sidebar')
        @include('site.partials.twitter')
        @include('site.events.latest')
        @include('site.blog.latest')
        @include('site.partials.newsletter')
    @show
</div>

