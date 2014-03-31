@extends('site.layouts.home')
@section('maincontent')
<style>
    .padded {
        padding:0;
        margin:0 5px 0 5px;
    }
</style>
<div class="row">
    {{ Form::open(array('action' => 'EventsController@index','method'=>'get','class'=>'form-inline')) }}
    <div class="col-md-3 padded">
        <div class="form-group">
            <input type="text" class="form-control" id="search" name="search" value="@if(isset($search)) {{ $search }} @endif "  placeholder="Keyword">
        </div>
    </div>
    <div class="col-md-2 padded">

        <div class="form-group">
            {{ Form::select('country', array('0'=>'Choose Country',$countries), $country ,['class' => 'form-control']) }}
        </div>
    </div>
    <div class="col-md-2 padded">
        <div class="form-group">
            {{ Form::select('category', array('0'=>'Choose Category',$categories), $category ,['class' => 'form-control']) }}
        </div>
    </div>
    <div class="col-md-2 padded">
        <div class="form-group">
            {{ Form::select('author', array(''=>'Choose Author',$authors), $author ,['class' => 'form-control']) }}
        </div>
    </div>
    <div class="col-md-1">

        <button type="submit" class="btn btn-default btn-small">Search</button>

    </div>
    {{ Form::close() }}
</div>
</br>
@if(count($events))
    @foreach($events as $event)
        <div class="row">
            <div class="col-sm-2 col-md-2">
                <div id="event_images">
                    <div id="links">
                        @if($event->photos)
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
            </div>
            <div class="col-sm-10 col-md-10">
                <h3><a href="event/{{$event->id}}">
                    @if ( LaravelLocalization::getCurrentLocaleName() == 'English')
                    @if($event->description_en)
                    {{ $event->title_en }}
                    @else
                    {{ $event->title }}

                    @endif
                    @else
                    {{ $event->title }}
                    @endif
                </a></h3>
                <p>
                    @if ( LaravelLocalization::getCurrentLocaleName() == 'English')

                    @if($event->description_en)
                    {{ Str::limit($event->description, 150) }}
                @else
                    {{ $event->description }}
                @endif
                @else
                    {{ Str::limit($event->description, 150) }}
                @endif
                    <a href="event/{{ $event->id}}">{{ Lang::get('site.general.more')}}</a>
                </p>

            </div>
        </div>

        <div class="row" style="margin: 9px; ">

                <i class="glyphicon glyphicon-user"> {{ $event->author->username }} |</i>
                <i class="glyphicon glyphicon-calendar"></i> {{ $event->date_start->format('Y-m-d')}} -
                 {{ $event->date_end->format('Y-m-d')}} |
                <i class="glyphicon glyphicon-globe"> {{ $event->location->country->name}} |</i>

            @if ( LaravelLocalization::getCurrentLocaleName() == 'English')
            <i class="glyphicon glyphicon-tag"></i>&nbsp;&nbsp;{{ $event->category->name_en }}
            @else
            <i class="glyphicon glyphicon-tag"></i>&nbsp;&nbsp;{{ $event->category->name }}
            @endif</div>
        <hr>
    @endforeach
    <?php echo $events->links(); ?>
@else
    <h1> No Events Returned </h1>
@endif
@stop
