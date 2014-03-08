@section('maincontent')
<div class="row">

    @if(Auth::user())
    <div class="row" id="statistic_feed">

        <button  id="fav_btn" type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="{{ Lang::get('site.event.fav') }}"><i class="glyphicon glyphicon-star"></i></button>&nbsp;
        <button  id="fallow_btn" type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="{{ Lang::get('site.event.fallow') }}"><i class="glyphicon glyphicon-plus"></i></button>&nbsp;
        <button  id="subscribe_btn" type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="{{ Lang::get('site.event.subscribe') }}"><i class="glyphicon glyphicon-check"></i></button>&nbsp;

    </div>
    @endif

    @if ( LaravelLocalization::getCurrentLocaleName() == 'English')
    <h1>{{ $event->title_en}}</h1>
    <div id="event_images">
        <div id="links">
            @foreach($event->photos as $photo)
            <a href="{{ $photo->name }}" data-gallery>
                <img src=" {{ $photo->name }}" alt="{{ $photo->name }}" class="img-thumbnail">
            </a>
            @endforeach
        </div>
    </div>
</br>
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
            @foreach($event->photos as $photo)
            <a href="{{ $photo->name }}" data-gallery>
                <img src=" {{ $photo->name }}" alt="{{ $photo->name }}" class="img-thumbnail">
            </a>
            @endforeach
        </div>
    </div>
    </br>
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