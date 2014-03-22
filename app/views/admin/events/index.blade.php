@extends('admin.layouts.default')

{{-- Content --}}
@section('content')

<p>{{ link_to_action('AdminEventsController@create', 'Add new event') }}</p>

@if ($events->count())
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
                <td>Event Id</td>
				<th>Category</th>
				<th>Location</th>
				<th>Title</th>
				<th>Date_start</th>
				<th>Date_end</th>
				<th>Address</th>
                <th>Posted</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($events as $event)
				<tr>
                    <td>{{{ $event->id }}}</td>
					<td>{{{ $event->category->name }}}</td>
					<td>{{{ $event->location->name }}}</td>
					<td>{{{ $event->title }}}</td>
					<td>{{{ $event->getHumanEventDateStartAtAttribute() }}}</td>
					<td>{{{ $event->getHumanEventDateEndAtAttribute() }}}</td>
					<td>{{{ $event->address }}}</td>
                    <td>{{{ $event->getHumanCreatedAtAttribute() }}} </td>
                    <td><a href="{{ URL::action('AdminEventsController@edit', array($event->id), array('class' => 'btn btn-info')) }}">Edit</a></td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'action' => array('AdminEventsController@destroy', $event->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no events
@endif

@stop
