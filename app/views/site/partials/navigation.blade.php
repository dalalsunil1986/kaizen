<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header
        @if ( App::getLocale() == 'en')
            col-md-12 pull-left
        @else
            pull-right
        @endif ">
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
                <li class="{{ (Request::is('en') || Request::is('ar') || Request::is('/')) ? 'active' : '' }}" ><a href="{{ route('home') }}">{{ Lang::get('site.nav.home')}}</a></li>
                <li class="dropdown {{ (Request::segment('1') == 'event' ? 'active' :  false ) }}">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">{{ Lang::get('site.nav.events') }}</a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ action('EventsController@index') }}" >{{ Lang::get('site.nav.events') }}</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ action('EventsController@index') }}">{{ Lang::get('site.nav.package') }}</a></li>
                    </ul>
                </li>
                <li class="{{ (Request::segment('1') == 'consultancy' ? 'active' :  false ) }}"><a href="{{ action('BlogsController@consultancy') }}">{{ Lang::get('site.nav.consultancies') }}</a></li>
                <li class="{{ (Request::segment('1') == 'blog' ? 'active' :  false ) }}"><a href="{{ action('BlogsController@index') }}">{{ Lang::get('site.nav.posts') }}</a></li>
                <li class="{{ (Request::segment('1') == 'contact' ? 'active' :  false ) }}"><a href="{{ action('ContactsController@index') }}">{{ Lang::get('site.nav.contactus') }}</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>