@section('maincontent')
<div class="row">
    <div class="row" id="statistic_feed">

        <a><i id="fav" class="glyphicon glyphicon-star-empty"></i></a>
        <i id="fav" class="glyphicon glyphicon-align-left"></i>
        <i id="fav" class="glyphicon glyphicon-arrow-down"></i>

    </div>

    @if ( LaravelLocalization::getCurrentLocaleName() == 'English')
    <h1>{{ $event->title_en}}</h1>
    <div id="event_images">
        <div id="links">
            @foreach($event->photos as $photo) {
            <a href="{{ $photo->name }}" data-gallery>
                <img src=" {{ $photo->featured }}" alt="{{ $photo->name }}" class="img-thumbnail">
            </a>
            }
            @endforeach
        </div>
    </div>

    <table class="table table-striped">
        <tr>
            <h4>{{ Lang::get('site.event.summaryevent') }}</h4>

        </tr>
        <tr>
            <td><b>{{ Lang::get('site.event.totalseats') }}</b></td>
            <td> {{ $event->total_seats}}</td>
            <td> {{ Lang::get('site.event.seatsavail') }}</td>
            <td > {{ $event->available_seats}} </td>

        </tr>
        <tr>
            <td><b>{{ Lang::get('site.event.date_start') }}</b></td>
            <td> {{ $event->date_start }}</td>
            <td> {{ Lang::get('site.event.date_end') }}</td>
            <td > {{ $event->date_end }} </td>

        </tr>
        <tr>
            <td><b>{{ Lang::get('site.event.time_start') }}</b></td>
            <td> {{ $event->time_start }}</td>
            <td> {{ Lang::get('site.event.time_end') }}</td>
            <td > {{ $event->time_end }} </td>

        </tr>

    </table>

    <p> {{ $event->description_en }}</p>


    <script>
        function initialize() {
            var myLatlng = new google.maps.LatLng({{ $event->latitude }},{{ $event->longitude}});
        var myOptions = {
            zoom: 4,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
        }

        function loadScript() {
            var script = document.createElement("script");
            script.type = "text/javascript";
            script.src = "http://maps.google.com/maps/api/js?sensor=false&callback=initialize";
            document.body.appendChild(script);
        }

        window.onload = loadScript;


    </script>
    <div id="map_canvas"></div>
    <address>
        <strong> {{ $event->address}} </strong><br>
        795 Folsom Ave, Suite 600<br>
        San Francisco, CA 94107<br>
        <abbr title="Phone">P:</abbr> (123) 456-7890
    </address>



    @else
    <h1>{{ $event->title}}</h1>

    <div id="event_images">
        <div id="links">
            <a href="{{ asset('images/Instagram.png') }}" title="Banana" data-gallery>
                <img src="http://placehold.it/100x100" alt="Banana" class="img-thumbnail">
            </a>
            <a href="http://placehold.it/100x100" title="Apple" data-gallery>
                <img src="http://placehold.it/100x100" alt="Apple"  class="img-thumbnail">
            </a>
            <a href="http://placehold.it/100x100" title="Orange" data-gallery>
                <img src="http://placehold.it/100x100" alt="Orange"  class="img-thumbnail">
            </a>
        </div>
    </div>

    <table class="table table-striped">
        <tr>
            <h4>{{ Lang::get('site.event.summaryevent') }}</h4>
        </tr>
        <tr>
            <td><b>{{ Lang::get('site.event.totalseats') }}</b></td>
            <td> {{ $event->total_seats}}</td>
            <td> {{ Lang::get('site.event.seatsavail') }}</td>
            <td > {{ $event->available_seats}} </td>

        </tr>
        <tr>
            <td><b>{{ Lang::get('site.event.date_start') }}</b></td>
            <td> {{ $event->date_start }}</td>
            <td> {{ Lang::get('site.event.date_end') }}</td>
            <td > {{ $event->date_end }} </td>

        </tr>
        <tr>
            <td><b>{{ Lang::get('site.event.time_start') }}</b></td>
            <td> {{ $event->time_start }}</td>
            <td> {{ Lang::get('site.event.time_end') }}</td>
            <td > {{ $event->time_end }} </td>

        </tr>

    </table>

    <p> {{ $event->description }}</p>


    <script>
        function initialize() {
            var myLatlng = new google.maps.LatLng({{ $event->latitude }},{{ $event->longitude}});
        var myOptions = {
            zoom: 4,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
        }

        function loadScript() {
            var script = document.createElement("script");
            script.type = "text/javascript";
            script.src = "http://maps.google.com/maps/api/js?sensor=false&callback=initialize";
            document.body.appendChild(script);
        }

        window.onload = loadScript;


    </script>
    <div id="map_canvas"></div>
    <address>
        <strong> {{ $event->address}} </strong><br>
        795 Folsom Ave, Suite 600<br>
        San Francisco, CA 94107<br>
        <abbr title="Phone">P:</abbr> (123) 456-7890
    </address>

    @endif


</div>
@stop