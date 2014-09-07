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

<div class="col-md-8" style="border: 1px solid rgba(181, 164, 173, 0.16); border-radius: 5px;">
    @section('content')
    @show
</div>
