extends('site.layouts.home')
@section('nav')
<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar">test her</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>


        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <a class="navbar-brand" href="#"> {{Lang::get('site.nav.home') }}</a>
                <a class="navbar-brand" href="#"> {{Lang::get('site.nav.home') }}</a>
                <li><a class="navbar-brand" href="#"> {{Lang::get('site.nav.home') }}</a></li>
                <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> {{Lang::get('site.nav.home') }} <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a class="navbar-brand" href="#" style="color:blue;"> {{Lang::get('site.nav.home') }}</a></li>
                        <li><a class="navbar-brand" href="#"> {{Lang::get('site.nav.home') }}</a></li>
                        <li><a class="navbar-brand" href="#"> {{Lang::get('site.nav.home') }}</a></li>
                    </ul>
                </li>
            </ul>
            <form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
@stop