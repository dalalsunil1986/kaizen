@extends('site.layouts.home')
@section('slider')

<div class="carousel slide" id="myCarousel">
    <div class="carousel-inner">
        <a href="{{ URL::action('EventsController@show',$events[0]->id) }}"><img alt="" src="{{ URL::asset('/images/' . $events[0]->name) }}"></a>

<!--        @foreach ($events as $event )-->
<!--            <div class="item">-->
<!--                <img alt="" src="{{ URL::asset('/images/' . $event->name) }}">-->
<!--                @if ( LaravelLocalization::getCurrentLocaleName() == 'English')-->
<!--                    <div class="carousel-caption">-->
<!--                        <h3><a href="event/{{ $event->id}}"> {{ $event->description_en }}</a></h3>-->
<!--                        <p><a href="event/{{ $event->id}}"> {{ $event->title_en }}</a></p>-->
<!--                    </div>-->
<!--                @else-->
<!--                    <div class="carousel-caption">-->
<!--                        <h3><a href="event/{{ $event->id}}"> {{ $event->description }}></a></h3>-->
<!--                        <p><a href="event/{{ $event->id}}"> {{ $event->title }}</a></p>-->
<!--                    </div>-->
<!--                @endif-->
<!--            </div>-->
<!--        @endforeach-->
    </div>
    <a data-slide="prev" href="#myCarousel" class="left carousel-control">‹</a>
    <a data-slide="next" href="#myCarousel" class="right carousel-control">›</a>
    <ol class="carousel-indicators">
        @for($i =0; $i < count($events); $i++)
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        @endfor
    </ol>
</div>
</br>
@stop
