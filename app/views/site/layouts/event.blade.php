@extends('site.layouts.home')
@section('slider')

<div class="row">

<div class="col-md-4">
        <span class="tag tag-gray active-tab-slide" id="slide0" style="cursor: pointer;"></span>
        <span class="tag tag-gray" id="slide1" style="cursor: pointer;"></span>
        <span class="tag tag-gray" id="slide2" style="cursor: pointer;"></span>
        <span class="tag tag-gray" id="slide3" style="cursor: pointer;"></span>
        <span class="tag tag-gray" id="slide4" style="cursor: pointer;"></span>
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
                        <img alt="" src="../images/events.jpg">
                        @if ( LaravelLocalization::getCurrentLocaleName() == 'English')
                            <div class="carousel-caption">
                                <h3><a href="event/{{ $event->id}}"> {{ $event->description_en }}</a></h3>
                                <p><a href="event/{{ $event->id}}"> {{ $event->title_en }}</a></p>
                            </div>
                        @else
                            <div class="carousel-caption" style="width: 40%; margin-right: 40%;">
                                <h3><a href="event/{{ $event->id}}"> {{ $event->description }}></a></h3>
                                <p><a href="event/{{ $event->id}}"> {{ $event->title }}</a></p>
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
