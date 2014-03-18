@extends('site.layouts.home')
@section('maincontent')
<div class="row">

    <ul class="timeline">
        <?php $i=0; ?>
        @foreach($events as $event)
        <li {{ (($i = !$i)? '':'class="timeline-inverted"') }} >
            <div class="timeline-badge">
                <span class="timeline-balloon-date-day">18 </span>
                <span class="timeline-balloon-date-month">Dec</span>
            </div>
            <div class="timeline-panel">
                <div class="timeline-heading">
                    <h4 class="timeline-title"><a href="{{ URL::action('EventsController@show',$event->id)}}">{{ $event->title }}</a></h4>
                    <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> at 2:am</small></p>
                        <i class="glyphicon glyphicon-calendar"></i>{{ $event->getEventDate() }}|
                        <i class="glyphicon glyphicon-comment"></i><a href="#">&nbsp;{{ count($event->comments) }}</a>
                </div>
                <div class="timeline-body">
                    <p>{{ $event->description }}</p>
                </div>
            </div>
        </li>

        <?php $i++; ?>
        @endforeach
    </ul>
</div>
<?php echo $events->links(); ?>
@stop