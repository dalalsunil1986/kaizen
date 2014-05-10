<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kaizen Courses</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file://
    ==========================
    some hints : Usama : 19-2-2014
    to change or hide a division
    1-  make one blade template with the name of the targeted division
    2- extends this template to site.layouts.home which will be the master template temporarly
    3- add that section of this division within the new template
    ==========================

    -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <!-- arabic and english switcher -->
    {{ HTML::style('css/bootstrap.min.css') }}
    {{ HTML::style('css/font-awesome.min.css') }}

    @if ( LaravelLocalization::getCurrentLocaleName() == 'Arabic')
    {{ HTML::style('css/bootstrap-rtl.min.css') }}
    @endif
    {{ HTML::style('css/customcss.css') }}
    @if ( LaravelLocalization::getCurrentLocaleName() == 'English')
    {{ HTML::style('css/customen.css') }}
    @endif
    {{ HTML::style('css/pongstagr.am.min.css') }}
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/customjs.js') }}"></script>
    <script src="{{ asset('js/pongstagr.am.min.js') }}"></script>
</head>
<body>
<div class="container">
    <!-- header -->
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <a href="/">{{ HTML::image('images/Logo.png','kaizen',array('class'=>'img-responsive')) }}</a>
        </div>
        <div class="col-md-5 col-sm-5 visible-lg visible-md visible-sm top30">
            @yield('login')
        </div>
        <div class="col-md-1 col-sm-1  visible-lg visible-md visible-sm top30">
            @include('site.layouts.locale')
        </div>
    </div>
    <div class="row">
        @yield('nav')
    </div>
    <div class="row visible-xs">
        <div class="col-xs-2">
            @include('site.layouts.locale')
        </div>
        <div class="col-xs-10">
            @yield('login')
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @include('notifications')
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @yield('slider')
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @yield('ads')
        </div>
    </div>
    <div class="row">
        <!-- main content division -->
        <div class="col-md-8">
            @yield('maincontent')
        </div>
        <!-- end of main content-->

        <div class="col-md-4">
            @yield('sidecontent')
        </div>
        <!-- end of sidedivision content-->
    </div>
    <div class="row">
        @yield('footer')
    </div>

</div>


</body>
</html>