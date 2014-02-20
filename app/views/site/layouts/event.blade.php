@extends('site.layouts.home')
@section('slider')
<div class="carousel slide" id="myCarousel">
    <div class="carousel-inner">
        <div class="item">
            <img alt="" src="http://placehold.it/1250x400/F3kji3">
            <div class="carousel-caption">
                <h3><a href="event/{{ $events[0]->id}}"> {{ $events[0]->description }}</a></h3>
                <p><a href="event/{{ $events[0]->id}}"> {{ $events[0]->title }}</a></p>
            </div>
        </div>
        @if ( LaravelLocalization::getCurrentLocaleName() == 'English')
        <div class="item">
            <img alt="" src="http://placehold.it/1250x400/NE24KI">
            <div class="carousel-caption">

                <h3><a href="event/{{ $events[1]->id}}"> {{ $events[1]->description_en }}</a></h3>
                <p><a href="event/{{ $events[1]->id}}"> {{ $events[1]->title_en }}</a></p>
            </div>
        </div>
        <div class="item active">
            <img alt="" src="http://placehold.it/1250x400/OK3KFS">
            <div class="carousel-caption">
                <h3><a href="event/{{ $events[2]->id}}"> {{ $events[2]->description_en }}</a></h3>
                <p><a href="event/{{ $events[2]->id}}"> {{ $events[1]->title_en }}</a></p>
            </div>
        </div>
        <div class="item">
            <img alt="" src="http://placehold.it/1250x400/MK3KFS">
            <div class="carousel-caption">
                <h3><a href="event/{{ $events[3]->id}}">{{ $events[3]->description_en }}</a></h3>
                <p><a href="event/{{ $events[3]->id}}"> {{ $events[3]->title_en }}</a></p>
            </div>
        </div>
        <div class="item">
            <img alt="" src="http://placehold.it/1250x400/NE24KI">
            <div class="carousel-caption">
                <h3><a href="event/{{ $events[4]->id}}">{{ $events[4]->description_en }}</a></h3>
                <p><a href="event/{{ $events[4]->id}}">{{ $events[4]->title_en }}</a></p>
            </div>
        </div>
        @else
        <div class="item">
            <img alt="" src="http://placehold.it/1250x400/NE24KI">
            <div class="carousel-caption">

                <h3><a href="event/{{ $events[1]->id}}"> {{ $events[1]->description_en }}</a></h3>
                <p><a href="event/{{ $events[1]->id}}"> {{ $events[1]->title }}</a></p>
            </div>
        </div>
        <div class="item active">
            <img alt="" src="http://placehold.it/1250x400/OK3KFS">
            <div class="carousel-caption">
                <h3><a href="event/{{ $events[2]->id}}"> {{ $events[2]->description }}</a></h3>
                <p><a href="event/{{ $events[2]->id}}"> {{ $events[1]->title }}</a></p>
            </div>
        </div>
        <div class="item">
            <img alt="" src="http://placehold.it/1250x400/MK3KFS">
            <div class="carousel-caption">
                <h3><a href="event/{{ $events[3]->id}}">{{ $events[3]->description }}</a></h3>
                <p><a href="event/{{ $events[3]->id}}"> {{ $events[3]->title }}</a></p>
            </div>
        </div>
        <div class="item">
            <img alt="" src="http://placehold.it/1250x400/NE24KI">
            <div class="carousel-caption">
                <h3><a href="event/{{ $events[4]->id}}">{{ $events[4]->description }}</a></h3>
                <p><a href="event/{{ $events[4]->id}}">{{ $events[4]->title }}</a></p>
            </div>
        </div>
        @endif

    </div>
    <a data-slide="prev" href="#myCarousel" class="left carousel-control">‹</a>
    <a data-slide="next" href="#myCarousel" class="right carousel-control">›</a>
    <ol class="carousel-indicators">
        <li data-target=""#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target=""#myCarousel" data-slide-to="1"></li>
        <li data-target=""#myCarousel" data-slide-to="2"></li>
        <li data-target=""#myCarousel" data-slide-to="3"></li>
        <li data-target=""#myCarousel" data-slide-to="4"></li>
    </ol>
</div></br>
@stop
