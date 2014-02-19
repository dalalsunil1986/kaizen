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
    @if ( LaravelLocalization::getCurrentLocaleName() == 'Arabic')
    {{ HTML::style('css/bootstrap-rtl.min.css') }}
    @endif
    <link href="{{ asset('css/customcss.css') }}" rel="stylesheet">

</head>
<body>
<div class="container">
    @yield('header')

    <!--content-->
    <div id="content" class="row">
        @yield('slider')
        @yield('ads')

        <div id="main">
            <div class="row"><br></div>
            @yield('rightside')
            @yield('leftside')
        </div> <!-- end of Maincontent -->
    </div><!-- end of content-->

    @yield('footer')
</div> <!-- end of container -->


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script>
    $('.carousel').carousel();
</script>
</body>
</html>