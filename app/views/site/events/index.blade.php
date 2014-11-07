@extends('site.layouts._two_column')

@section('sidebar')
    <div class="panel panel-default">
        <div class="panel-heading">{{ trans('word.expired_events') }}</div>
        <div class="panel-body">
            <ul>
                @if($expiredEvents)
                    @foreach($expiredEvents as $event)
                        <li class="unstyled"><i class="glyphicon glyphicon-calendar"></i> <a href="{{URL::action('EventsController@show',$event->id)}}"> {{ $event->title }}</a></li>
                    @endforeach
                    <hr>
                    <a href="{{action('EventsController@index',['past'=>'true'])}}">{{ trans('word.view_all_expired_events') }}</a>
                @endif
            </ul>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">{{ trans('word.category') }}</div>
        <div class="panel-body">
            <ul>
                @if($eventCategories)
                    @foreach($eventCategories as $eventCategory)
                        <li class="unstyled"><i class="glyphicon glyphicon-tag"></i><a href="{{action('CategoriesController@getEvents',$eventCategory->id)}}"> {{ $eventCategory->name }}</a></li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
    @parent
@stop

@section('content')

    {{-- Include Events Search Module --}}
    @include('site.events._search')

    @if(count($events))

        @foreach($events as $event)
            {{-- Include Events Results --}}
            @include('site.events._results')
        @endforeach

        <?php echo $events->appends(Request::except('page'))->links(); ?>

    @else
        <h1> {{ trans('word.no_results') }} </h1>
    @endif

@stop
