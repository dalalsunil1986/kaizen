@extends('layouts.scaffold')

@section('main')

<h1>Show Event</h1>

<p>{{ link_to_action('EventsController@index', 'Return to all events') }}</p>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Category_id</th>
				<th>Location_id</th>
				<th>Title</th>
				<th>Title_en</th>
				<th>Description</th>
				<th>Description_en</th>
				<th>Date_start</th>
				<th>Date_end</th>
				<th>Time_start</th>
				<th>Time_end</th>
				<th>Address</th>
				<th>Address_en</th>
				<th>Street</th>
				<th>Street_en</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>{{{ $event->category_id }}}</td>
					<td>{{{ $event->location_id }}}</td>
					<td>{{{ $event->title }}}</td>
					<td>{{{ $event->title_en }}}</td>
					<td>{{{ $event->description }}}</td>
					<td>{{{ $event->description_en }}}</td>
					<td>{{{ $event->date_start }}}</td>
					<td>{{{ $event->date_end }}}</td>
					<td>{{{ $event->time_start }}}</td>
					<td>{{{ $event->time_end }}}</td>
					<td>{{{ $event->address }}}</td>
					<td>{{{ $event->address_en }}}</td>
					<td>{{{ $event->street }}}</td>
					<td>{{{ $event->street_en }}}</td>
                    <td>{{ link_to_action('EventsController@edit', 'Edit', array($event->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'action' => array('EventsController@destroy', $event->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
		</tr>
	</tbody>
</table>

@stop
