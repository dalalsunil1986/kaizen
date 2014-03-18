@extends('site.layouts.home')
@section('slider')

<style type="text/css">
        
            span.tag {
             margin:14px 5px;
             position:relative;
             border-radius:0px;
             background:red;
             display:block;
             height: 76px;
             width: 275px;
             padding:.6em 4.5em;
             text-align:center;
            }

            span.tag:hover, .active-tab-slide{
                background: #502d8a !important; /* Old browsers */
                background: -moz-linear-gradient(top, #502d8a 0%, #502d8a 50%, #502d8a 51%, #502d8a 100%) !important; /* FF3.6+ */
                background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#502d8a), color-stop(50%,#502d8a), color-stop(51%,#502d8a), color-stop(100%,#502d8a)) !important; /* Chrome,Safari4+ */
                background: -webkit-linear-gradient(top, #502d8a 0%,#502d8a 50%,#502d8a 51%,#502d8a 100%) !important; /* Chrome10+,Safari5.1+ */
                background: -o-linear-gradient(top, #502d8a 0%,#502d8a 50%,#502d8a 51%,#502d8a 100%) !important; /* Opera 11.10+ */
                background: -ms-linear-gradient(top, #502d8a 0%,#502d8a 50%,#502d8a 51%,#502d8a 100%) !important; /* IE10+ */
                background: linear-gradient(top, #502d8a 0%,#502d8a 50%,#502d8a 51%,#502d8a 100%) !important; /* W3C */
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#502d8a', endColorstr='#502d8a',GradientType=0 ) !important; /* IE6-9 */
            }

            span.tag-gray {
             background: #C5C5C5; /* Old browsers */
             background: -moz-linear-gradient(top, #C5C5C5 0%, #C5C5C5 50%, #C5C5C5 51%, #C5C5C5 100%); /* FF3.6+ */
             background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#C5C5C5), color-stop(50%,#C5C5C5), color-stop(51%,#C5C5C5), color-stop(100%,#C5C5C5)); /* Chrome,Safari4+ */
             background: -webkit-linear-gradient(top, #C5C5C5 0%,#C5C5C5 50%,#C5C5C5 51%,#C5C5C5 100%); /* Chrome10+,Safari5.1+ */
             background: -o-linear-gradient(top, #C5C5C5 0%,#C5C5C5 50%,#C5C5C5 51%,#C5C5C5 100%); /* Opera 11.10+ */
             background: -ms-linear-gradient(top, #C5C5C5 0%,#C5C5C5 50%,#C5C5C5 51%,#C5C5C5 100%); /* IE10+ */
             background: linear-gradient(top, #C5C5C5 0%,#C5C5C5 50%,#C5C5C5 51%,#C5C5C5 100%); /* W3C */
             filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#C5C5C5', endColorstr='#C5C5C5',GradientType=0 ); /* IE6-9 */
             color:#fff;
             font-family:sans-serif;
             font-size:.7em;
             font-weight:bold;
            }
            span.tag:after {
             /* right, height, and width should equal eachother */
             right:182px;
             height:37px;
             width:80px;
             border-radius: 0px 32px 0px 0px;
             content:".";
             display:block;
             position:absolute;
             top:8px;
             font-size:0;
             overflow:hidden;
             background:#fff;
             -moz-transform-origin:0 0;
             -moz-transform:rotate(-43deg) translate(-60%, -49%);
             -webkit-transform-origin:0 0;
             -webkit-transform:rotate(-43deg) translate(-60%, -49%);
             transform-origin:0 0;
             transform:rotate(-43deg) translate(-60%, -49%);
            }
    </style>

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
