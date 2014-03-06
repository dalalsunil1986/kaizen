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
    {{ HTML::style('css/customcss.css') }}
    @if ( LaravelLocalization::getCurrentLocaleName() == 'English')
    {{ HTML::style('css/customen.css') }}
    @endif

</head>
<body>
<div class="container">
    <div class="col-md-1" ></div>
    <div class="col-md-10" >
        <!-- header -->
        <div id="header" class="row">
            <div class="row">
                <div class="col-md-4">
                    {{ HTML::image('images/Logo.png') }}
                </div>
                <div class="col-md-8">
                    @yield('login')
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                @yield('nav')
                </div>
            </div> <!-- end of row-->
        </div>
        <!-- end header-->

        <!--content-->
        <div id="content" class="row">
            @yield('slider')
            @yield('ads')
            <div class="row"></div>
            <!-- main content division -->
            <div id="maincontent" class="col-md-8">
                @yield('maincontent')
            </div>
            <!-- end of main content-->

            <!-- sidecontent division -->
            <div id="sidecontent" class="col-md-4">
                @yield('sidecontent')
            </div>
            <!-- end of sidedivision content-->
        </div><!-- end of content-->

        @yield('footer')
    </div>
    <div class="col-md-1"></div>

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