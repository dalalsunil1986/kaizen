@extends('site.layouts.home')
@section('slider')

<div class="row">
    @if($events)
        <div class="col-md-3 hidden-xs">
            <?php $i = 0; ?>
            @foreach($events as $event)
                <span class="tag tag-gray {{ ($i == 0) ? 'active-tab-slide' : '' }}" id="slide{{ $i }}" style="cursor: pointer; font-size: 15px;">
                    @if ( LaravelLocalization::getCurrentLocaleName() == 'English')
                        {{  ($event->title_en ) ? $event->title_en  : $event->title  }}
                    @else
                        {{   $event->title  }}
                     @endif
                </span>
                <?php $i++; ?>
            @endforeach
        </div>

        <div id="myCarousel" class="carousel slide col-md-9 col-xs-12"  data-ride="carousel">

            <ol class="carousel-indicators" style="display: none;">
                <?php $i = 0; ?>
                @foreach($events as $event)
                    <li data-target="#myCarousel" data-slide-to="{{ $i }}" {{ ($i == 0) ? 'class="active"' : '' }} ></li>
                <?php $i++; ?>
                @endforeach
              </ol>

            <div class="carousel-inner ">
                <?php $char_limit = 100; ?>
                <?php $first="active"; $order=0;?>
                @foreach ($events as $event)
                <div class="slider item {{$first}}" data-order="{{$order}}">
                    <!-- <img alt="" src="{{ URL::asset($event->name) }}"> -->
                    <a href="{{ action('EventsController@show',$event->id) }}"> {{ HTML::image('uploads/medium/'.$event->name.'','image2',array('class'=>'img-responsive','style'=>'width:400,height:400')) }} </a>

                    @if ( LaravelLocalization::getCurrentLocaleName() == 'English')
                        <div class="carousel-caption hidden-xs" >
                            <span class="slider-title {{ ($event->title_en) ? 'text-left':'text-right' }}">
                                <a href="{{ action('EventsController@show',$event->id) }}">
                                    {{  ($event->title_en ) ? $event->title_en  : $event->title  }}
                                </a>
                            </span>
                            <span class="slider-description {{ ($event->description_en) ? 'text-left':'text-right' }}">
                                    {{ ($event->description_en) ? Str::limit($event->description_en,$char_limit) : Str::limit($event->description,$char_limit) }}
                            </span>
                            <a class="kaizen-button" href="{{ action('EventsController@show',$event->id) }}">
                                {{ ($event->button_en) ? $event->button_en : $event->button }}
                            </a>
                        </div>
                    @else
                    <div class="carousel-caption hidden-xs" >
                            <span class="slider-title {{ ($event->title_en) ? 'text-left':'text-right' }}">
                                <a href="{{ action('EventsController@show',$event->id) }}">
                                    {{  $event->title }}
                                </a>
                            </span>
                            <span class="slider-description {{ ($event->description_en) ? 'text-left':'text-right' }}">
                                    {{ Str::limit($event->description,$char_limit) }}
                            </span>
                            <a class="kaizen-button" href="{{ action('EventsController@show',$event->id) }}">
                                {{ $event->button }}
                            </a>
                    </div>
                    @endif
                </div>
                <?php $first=""; $order++;?>
                @endforeach
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
    @endif

</div>

</br>
@stop
