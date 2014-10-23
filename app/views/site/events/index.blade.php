@extends('site.layouts._two_column')

@section('sidebar')
    <div class="panel panel-default">
        <div class="panel-heading">{{ Lang::get('site.event.category') }}</div>
        <div class="panel-body">
            <ul>
                @if($eventCategories)
                    @foreach($eventCategories as $eventCategory)
                        <li class="unstyled"><i class="glyphicon glyphicon-tag"></i><a href="{{URL::action('CategoriesController@getEvents',$eventCategory->id)}}"> {{ $eventCategory->name }}</a></li>
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
        <h1> {{ trans('site.general.no-results') }} </h1>
    @endif

@stop
