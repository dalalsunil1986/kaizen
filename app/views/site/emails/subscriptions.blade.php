<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kaizen Courses - usama ??? `</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"/>

    <style type="text/css">
        @import url(http://fonts.googleapis.com/earlyaccess/droidarabickufi.css);
        html,body,p,h1,h2,h3,h4,div,span {
            font-family: 'Droid Arabic Kufi', serif !important;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row" style="border:1px solid #939393; border-radius: 5px; padding:15px; width: 58%; margin-right:20%; margin-right:20%;">
        <div class="panel panel-default">
            <div class="panel-heading"> <h2 style="background-color: #C3CBD2; color: #b271d2;">{{ $title_en }} </h2></div>
            <div class="panel-body" style="padding:5px;">
                <h3>{{ $body }}</br></h3>
              <h2>{{  $description_en }}</h2>
                <a href="{{ URL::action('EventsController@show',$id) }}" class="btn btn-primary" role="button">Go to Event</a>
                </br></br>
                <img src="{{ asset(app_path().'images/logo.png', $title_en, array('width'=>'50%', 'height'=>'auto')) }}" />
            </div>
        </div>
    </div>
</div>

</body>
</html>