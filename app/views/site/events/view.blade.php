@extends('site.layouts.home')
@section('maincontent')
<div class="row">
    @if(Auth::user())
        <div class="row" id="statistic_feed">
            <button  id="favorite_btn" type="button" class="btn btn-default btn-sm " data-toggle="tooltip" data-placement="top" title="{{ Lang::get('site.event.favorite') }}"><i id="favorite" class="glyphicon glyphicon-star {{ $favorited? 'active' :'' ;}}"></i></button>&nbsp;
            <button  id="follow_btn" type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="{{ Lang::get('site.event.follow') }}"><i id="follow" class="glyphicon glyphicon-plus {{ $followed? 'active' :'' ;}}"></i></button>&nbsp;
            <button  id="subscribe_btn" type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="{{ Lang::get('site.event.subscribe') }}"><i id="subscribe" class="glyphicon glyphicon-check {{ $subscribed? 'active' :'' ;}}"></i></button>&nbsp;
        </div>
    @endif

    <h1>
        @if ( LaravelLocalization::getCurrentLocaleName() == 'English')
            @if($event->title_en)
                {{ $event->title_en }}
            @else
                {{ $event->title }}
            @endif
        @else
        {{ $event->title }}
        @endif
    </h1>
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
            <td> {{ $event->formatEventDate($event->date_start) }}</td>
            <td> {{ Lang::get('site.event.date_end') }}</td>
            <td> {{ $event->formatEventDate($event->date_end) }}</td>
        </tr>
        <tr>
            <td><b>{{ Lang::get('site.event.time_start') }}</b></td>
            <td> {{ $event->formatEventTime($event->time_start) }}</td>
            <td> {{ Lang::get('site.event.time_end') }}</td>
            <td> {{ $event->formatEventTime($event->time_end) }}</td>
        </tr>
    </table>

    <p>
       @if ( LaravelLocalization::getCurrentLocaleName() == 'English')
            @if($event->description_en)
                {{ $event->description_en }}
            @else
                {{ $event->description }}
            @endif
       @else
            {{ $event->description }}
       @endif
   </p>


    @if($event->latitude && $event->longitude)
        <div id="map_canvas"></div>
    @endif
<option selected disabled>first option</option>
    <address>
        <strong> {{ $event->address}} </strong><br>
        795 Folsom Ave, Suite 600<br>
        San Francisco, CA 94107<br>
        <abbr title="Phone">P:</abbr> (123) 456-7890
    </address>

        @if(count($event->comments) > 0)
            <h3 class="comments_title"> {{Lang::get('site.event.comment') }}</h3>
            @foreach($event->comments as $comment)
            <div class="comments_dev">
                <p class="text-muted">
                    {{ $comment->content }}
                </p>
                <p
                @if ( LaravelLocalization::getCurrentLocaleName() == 'English')
                   class="text-right text-primary"
                @else
                    class="text-left text-primary"
                @endif
                >{{ $comment->user->username}}</span>
            </div>
            @endforeach
        @endif

        @if(Auth::User())

            {{ Form::open(array( 'action' => array('CommentsController@store', $event->id),'class'=>'row')) }}
                <div class="form-group">
                    <label for="comment"></label>
                    <textarea type="text"  class="form-control" id="content" name="content" placeholder="{{ Lang::get('site.event.comment')}}"></textarea>
                </div>
                <button type="submit" class="btn btn-default"> {{ Lang::get('site.event.addcomment') }} </button>
            {{ Form::close() }}
            @if ($errors->any())
            <ul>
                {{ implode('', $errors->all('<li class="error">:message</li>')) }}
            </ul>
            @endif
    </br>
        @endif

</div>

@if($event->latitude && $event->longitude)
    <script>



        var id = '<?php echo $event->id; ?>';

        function initialize() {
            var myLatlng = new google.maps.LatLng({{ $event->latitude }},{{ $event->longitude}});
            var myOptions = {
                zoom: 10,
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
@endif
@stop