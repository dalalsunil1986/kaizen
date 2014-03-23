@extends('admin.layouts.default')

{{-- Content --}}
@section('content')
<h1>Events</h1>
<p>{{ link_to_action('AdminEventsController@create', 'Add new event') }}</p>

@if ($event->count())
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
                <td>Event Id</td>
				<th>Title</th>
				<th>Date_start</th>
				<th>Date_end</th>
                <th>Posted</th>
                <th>View Followers</th>
                <th>View Subscribers</th>
                <th>View Favorites</th>
			</tr>
		</thead>

		<tbody>
        <tr>
            <td>{{{ $event->id }}}</td>
            <td>{{{ $event->title }}}</td>
            <td>{{{ $event->date_start }}}</td>
            <td>{{{ $event->date_end }}}</td>
            <td>{{{ $event->getHumanCreatedAtAttribute() }}} </td>
            <td><a href="{{action('AdminEventsController@getFollowers',$event->id) }}">View</a></td>
            <td><a href="{{action('AdminEventsController@getSubscriptions',$event->id) }}">View</a></td>
            <td><a href="{{action('AdminEventsController@getFavorites',$event->id) }}">View</a></td>
            <td><a href="{{ URL::action('AdminEventsController@edit', array($event->id), array('class' => 'btn btn-info')) }}">Edit</a></td>
            <td>
                {{ Form::open(array('method' => 'DELETE', 'action' => array('AdminEventsController@destroy', $event->id))) }}
                    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                {{ Form::close() }}
            </td>
        </tr>

		</tbody>
	</table>
@else
	There are no events
@endif

@stop
