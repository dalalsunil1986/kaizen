extends('site.layouts.home')
@section('nav')
<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="{{ action('EventsController@slider') }}">{{ Lang::get('site.nav.main')}}</a></li>
                <li><a href="{{ action('EventsController@index') }}">{{ Lang::get('site.nav.events') }}</a></li>
                <li><a href="#">{{ Lang::get('site.nav.consultancies') }}</a></li>
                <li><a href="{{ URL::to('blog') }}">{{ Lang::get('site.nav.posts') }}</a></li>
                <li><a href="{{ URL::to('contactus') }}">{{ Lang::get('site.nav.contactus') }}</a></li>
            </ul>
            @if ( LaravelLocalization::getCurrentLocaleName() == 'English')
            {{  '<ul class="nav navbar-nav navbar-right">'; }}
            @else
            {{ '<ul class="nav navbar-nav navbar-left">'; }}
            @endif
                <li><form class="navbar-form navbar-left" role="search">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="{{ Lang::get('site.nav.search') }}">
                        </div>
                        <button type="submit" class="btn btn-default">{{ Lang::get('site.nav.search') }}</button>
                    </form>
               </li>
            </ul>

        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
@stop