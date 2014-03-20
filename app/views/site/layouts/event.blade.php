@extends('site.layouts.home')
@section('slider')

<div class="row">

<div class="col-md-4 visible-lg">
        <span class="tag tag-gray active-tab-slide" id="slide0" style="cursor: pointer; font-size: 18px;"> Text 1 </span>
        <span class="tag tag-gray" id="slide1" style="cursor: pointer; font-size: 18px;"> Text 2 </span>
        <span class="tag tag-gray" id="slide2" style="cursor: pointer; font-size: 18px;"> Text 3 </span>
        <span class="tag tag-gray" id="slide3" style="cursor: pointer; font-size: 18px;"> Text 4 </span>
        <span class="tag tag-gray" id="slide4" style="cursor: pointer; font-size: 18px;"> Text 5 </span>
</div>

    <div id="myCarousel" class="carousel slide col-md-8"  data-ride="carousel">
        <ol class="carousel-indicators" style="display: none;">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
            <li data-target="#myCarousel" data-slide-to="3"></li>
            <li data-target="#myCarousel" data-slide-to="4"></li>
          </ol>

        <div class="carousel-inner">

            @if($events)
            <?php $first="active"; $order=0;?>
                @foreach ($events as $event)
                    <div class="item {{$first}}" data-order="{{$order}}">
                        <!-- <img alt="" src="{{ URL::asset($event->name) }}"> -->
                        <img alt="" width="400" height="400" src="../images/events.gif">
                        @if ( LaravelLocalization::getCurrentLocaleName() == 'English')
                            <div class="carousel-caption" style="background:#502d8a;height:400px;padding-left: 3px; padding-right: 3px;">
                                <h3><a href="event/{{ $event->id}}" style="color:white;font-size: 14px;"> {{ $event->description_en }}</a></h3>
                                <p><a href="event/{{ $event->id}}" style="color:white;font-size: 15px;"> {{ $event->title_en }}</a></p>
                                <a class="kaizen-button kaizen-button-right" href="http://localhost:8000/en/user/register">Button</a>
                            </div>
                        @else
                            <div class="carousel-caption" style="background:#502d8a;width: 40%; height:400px;margin-right: 40%;padding-left: 3px; padding-right: 3px;">
                                <h3><a href="event/{{ $event->id}}" style="color:white;font-size: 14px;"> {{ $event->description }}></a></h3>
                                <p><a href="event/{{ $event->id}}" style="color:white;font-size: 15px;"> {{ $event->title }}</a></p>
                                <a class="kaizen-button" href="http://localhost:8000/en/user/register">Register</a>
                            </div>
                        @endif
                    </div>

                    <?php $first=""; $order++;?>
                @endforeach
            @endif
        </div>
        
        <ol class="carousel-indicators">
            <?php $first="active";?>
            @if($events)
                @for($i =0; $i < count($events); $i++)
                    <li data-target="#myCarousel" data-slide-to="{{$i}}" class="{{$first}}" style="display: none;"></li>
                    <?php $first="";?>
                @endfor
            @endif
        </ol>
    </div>

</div>

</br>
@stop
