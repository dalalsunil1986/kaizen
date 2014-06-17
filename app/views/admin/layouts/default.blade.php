<!DOCTYPE html>

<html lang="en">

<head id="Starter-Site">

    <meta charset="UTF-8">

    <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>
        @section('title')
        Administration
        @show
    </title>

    <meta name="keywords" content="@yield('keywords')" />
    <meta name="author" content="@yield('author')" />
    <!-- Google will often use this as its description of your page/site. Make it good. -->
    <meta name="description" content="@yield('description')" />

    <!-- Speaking of Google, don't forget to set your site up: http://google.com/webmasters -->
    <meta name="google-site-verification" content="">

    <!-- Dublin Core Metadata : http://dublincore.org/ -->
    <meta name="DC.title" content="Project Name">
    <meta name="DC.subject" content="@yield('description')">
    <meta name="DC.creator" content="@yield('author')">

    <!--  Mobile Viewport Fix -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <!-- This is the traditional favicon.
     - size: 16x16 or 32x32
     - transparency is OK
     - see wikipedia for info on browser support: http://mky.be/favicon/ -->
    <link rel="shortcut icon" href="{{{ asset('assets/ico/favicon.png') }}}">

    <!-- iOS favicons. -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{{ asset('assets/ico/apple-touch-icon-144-precomposed.png') }}}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{{ asset('assets/ico/apple-touch-icon-114-precomposed.png') }}}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{{ asset('assets/ico/apple-touch-icon-72-precomposed.png') }}}">
    <link rel="apple-touch-icon-precomposed" href="{{{ asset('assets/ico/apple-touch-icon-57-precomposed.png') }}}">

    <!-- CSS -->
    {{ Basset::show('admin.css') }}
    <!--    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">-->
    <style>
        body {
            font-size:1.2em;
            margin: 50px 0;
        }
        .nav > li > a {
            padding-right:0px;
        }
        .alert {
            margin:15px 0 0 0;
        }


    </style>

    @yield('styles')
    <style>
        ul {list-style-type: none}
        li {list-style-type: none}
    </style>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="http://code.jquery.com/jquery.min.js" type="text/javascript"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js" type="text/javascript"></script>

    <!-- Asynchronous google analytics; this is the official snippet.
     Replace UA-XXXXXX-XX with your site's ID and uncomment to enable.
    <script type="text/javascript">
        var _gaq = _gaq || [];
          _gaq.push(['_setAccount', 'UA-31122385-3']);
          _gaq.push(['_trackPageview']);

          (function() {
               var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
          })();

    </script> -->

</head>

<body>
<!-- Container -->
<div class="container">
    <!-- Navbar -->
    <div class="navbar navbar-default navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <li{{ (Request::is('admin/event*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/') }}}"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                    <li{{ (Request::is('admin/requests*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/requests') }}}"><span class="glyphicon glyphicon-lock"></span> Requests</a></li>
                    <li{{ (Request::is('admin/blogs*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/blogs') }}}"><span class="glyphicon glyphicon-list-alt"></span> Blog</a></li>
                    <li{{ (Request::is('admin/category*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/category') }}}"><span class="glyphicon glyphicon-tag"></span> Category</a></li>
                    <li{{ (Request::is('admin/locations*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/locations') }}}"><span class="glyphicon glyphicon-map-marker"></span> Locations</a></li>
                    <li{{ (Request::is('admin/country*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/country') }}}"><span class="glyphicon glyphicon-globe"></span> Country</a></li>
                    <li{{ (Request::is('admin/comments*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/comments') }}}"><span class="glyphicon glyphicon-comment"></span> Comments</a></li>
                    <li{{ (Request::is('admin/ads*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/ads') }}}"><span class="glyphicon glyphicon-pushpin"></span> Ads</a></li>
                    <li{{ (Request::is('admin/contact-us*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/contact-us') }}}"><span class="glyphicon glyphicon-envelope"></span> Contact</a></li>
                    <li class="dropdown{{ (Request::is('admin/users*|admin/roles*') ? ' active' : '') }}">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="{{{ URL::to('admin/users') }}}">
                            <span class="glyphicon glyphicon-user"></span> Users <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li{{ (Request::is('admin/users*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/users') }}}"><span class="glyphicon glyphicon-user"></span> Users</a></li>
                    <li{{ (Request::is('admin/roles*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/roles') }}}"><span class="glyphicon glyphicon-user"></span> Roles</a></li>
                </ul>
                </li>
                </ul>
                <ul class="nav navbar-nav pull-right">
                    <li><a href="{{{ URL::to('/') }}}"><span class="glyphicon glyphicon-upload"></span> View Homepage</a></li>
                    <li class="divider-vertical"></li>
                    <li class="dropdown">
                        <ul class="dropdown-menu">
                            <li><a href="{{{ URL::to('user/'.Auth::user()->id.'/profile') }}}"><span class="glyphicon glyphicon-wrench"></span> Settings</a></li>
                            <li class="divider"></li>
                            <li><a href="{{{ URL::to('user/logout') }}}"><span class="glyphicon glyphicon-share"></span> Logout</a></li>
                        </ul>

                    </li>

                </ul>
            </div>
        </div>
    </div>
    <!-- ./ navbar -->

    <!-- Notifications -->
    @include('notifications')
    <!-- ./ notifications -->

    <!-- Content -->
    @yield('content')
    <!-- ./ content -->

    <!-- Footer -->
    <footer class="clearfix">
        @yield('footer')
    </footer>
    <!-- ./ Footer -->

</div>
<!-- ./ container -->

<!-- Javascripts -->
<!--    <script src="http://code.jquery.com/jquery.min.js" type="text/javascript"></script>-->

{{ Basset::show('admin.js') }}

<script type="text/javascript">
    $('.wysihtml5').wysihtml5();
    $(prettyPrint);
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.datatable').dataTable({
            "sPaginationType": "bs_four_button"
        });
        $('.datatable').each(function(){
            var datatable = $(this);
            // SEARCH - Add the placeholder for Search and Turn this into in-line form control
            var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
            search_input.attr('placeholder', 'Search');
            search_input.addClass('form-control');
            // LENGTH - Inline-Form control
            var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
            length_sel.addClass('form-control input-sm');
        });
    });
</script>
@yield('scripts')

</body>

</html>