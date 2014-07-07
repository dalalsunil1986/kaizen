@extends('site.layouts._two_column')

@section('content')
<style>
    .padded {
        padding:0;
        margin:0 5px 0 5px;
    }
</style>

</br>
@if(count($events))
@foreach($events as $event)
<div class="row">
    <div class="col-sm-2 col-md-2">
        <div id="links">
            @if(count($event->photos))
            <a href="{{ action('EventsController@show',$event->id) }}" >
                {{ HTML::image('uploads/thumbnail/'.$event->photos[0]->name.'','image1',array('class'=>'img-responsive img-thumbnail')) }}
            </a>
            @else
            <a href="{{ action('EventsController@show',$event->id) }}">
                <img src="http://placehold.it/70x70" class="img-thumbnail">
            </a>
            @endif
        </div>
    </div>
    <div class="col-sm-10 col-md-10">
                <span class="event-title">
                    <a href="event/{{$event->id}}">
                    @if ( App::getLocale() == 'en')
                        @if($event->title_en)
                            {{ $event->title_en }}
                        @else
                        {{ $event->title_ar }}
                        @endif
                    @else
                        {{ $event->title_ar }}
                    @endif
                    </a>
                </span>

        <p>
            @if ( App::getLocale() == 'en')
                @if($event->description_en)
                    {{ Str::limit($event->description_en, 150) }}
                @else
                    {{ $event->description_ar }}
                @endif
            @else
                {{ Str::limit($event->description_ar, 150) }}
            @endif
            <a href="event/{{ $event->id}}">{{ Lang::get('site.general.more')}}</a>
        </p>

    </div>
</div>

<div class="row" style="margin: 9px; ">

    <i class="glyphicon glyphicon-user">
        {{ link_to_action('EventsController@index', $event->author->username,array('search'=>'','author'=>$event->author->id))  }}
        |</i>
    <i class="glyphicon glyphicon-calendar"></i> {{ $event->date_start->format('Y-m-d')}} -
    {{ $event->date_end->format('Y-m-d')}} |

    <i class="glyphicon glyphicon-globe">
        @if ( App::getLocale() == 'en')
            <?php $country =  ($event->location->country->name_en) ? $event->location->country->name_en : $event->location->country->name_ar ;?>
            <?php $category =  ($event->category->name_en) ? $event->category->name_en : $event->category->name_ar ;?>
        @else
            <?php $country =  ($event->location->country->name_ar) ? $event->location->country->name_ar : $event->location->country->name_en ;?>
            <?php $category =  ($event->category->name_ar) ? $event->category->name_ar : $event->category->name_en ;?>
        @endif
        {{ link_to_action('EventsController@index', $country ,array('search'=>'','country'=>$event->location->country->id))  }}
        |</i>
    @if ( App::getLocale() == 'en')
    <i class="glyphicon glyphicon-tag"></i>&nbsp;&nbsp;
    {{ link_to_action('EventsController@index', $event->category->name_en,array('search'=>'','category'=>$event->category->id))  }}
    @else
    <i class="glyphicon glyphicon-tag"></i>&nbsp;&nbsp;
    {{ link_to_action('EventsController@index', $category,array('search'=>'','category'=>$event->category->id))  }}
    @endif</div>
<hr>
@endforeach
<?php echo $events->appends(Request::except('page'))->links(); ?>
@else
<h1> No Events Returned </h1>
@endif
@stop
