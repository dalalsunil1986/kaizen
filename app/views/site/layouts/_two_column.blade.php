<div id="sidecontent" class="col-md-4
    @if ( App::getLocale() == 'ar')
        pull-right
    @else
        pull-left
    @endif
    ">
    @section('sidebar')
        @include('site.partials.twitter')
        @include('site.events.latest')
        @include('site.blog.latest')
        @include('site.partials.newsletter')
    @show
</div>

<div class="col-md-8">
    @section('content')
    @show
</div>
