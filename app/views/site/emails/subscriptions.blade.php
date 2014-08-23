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
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"> <h2>{{ $title_en }} </h2></div>
            <div class="panel-body">
                <a href="#" class="thumbnail">
                    <img style="width: 50%; height: 50%; border:1px solid #c8c8c8; border-radius: 3px;" src="http://placehold.it/150x150" alt="...">
                </a>
                <h3>Please Note that  your subscription request is pending .. waiting for adminstrator approval .. once it's approved, you will be notified .. thanks for using Kaizen Website </br></h3>
              <h2>{{  $description_en }}</h2>
                <a href="{{ URL::action('EventsController@show',$id) }}" class="btn btn-primary" role="button">Go to Event</a>

            </div>
        </div>
    </div>
</div>

</body>
</html>