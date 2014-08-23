<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kaizen Courses - usama ??? `</title>
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
    @if ( App::getLocale() == 'ar')
    {{ HTML::style('css/bootstrap-rtl.min.css') }}
    <style type="text/css">
        @import url(http://fonts.googleapis.com/earlyaccess/droidarabickufi.css);
        html,body,p,h1,h2,h3,h4,div,span {
            font-family: 'Droid Arabic Kufi', serif !important;
        }
    </style>
    @endif
    {{ HTML::style('css/customcss.css') }}
    @if ( App::getLocale() == 'en')
    {{ HTML::style('css/customen.css') }}
    @endif

</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-xs-18 col-sm-6 col-md-3">
            <div class="thumbnail">
                <img src="http://placehold.it/500x300" alt="">
                <div class="caption">
                    <h4>{{ $title_en }} - Kaizen</h4>
                    <p>{{ $description_en }}</p>
                    <p><a href="{{ URL::action('EventsController@show', $id) }}" class="btn btn-info btn-xs" role="button">Go to Event Details</a> <a href="#" class="btn btn-default btn-xs" role="button">Button</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>