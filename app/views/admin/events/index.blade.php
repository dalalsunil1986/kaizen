@extends('admin.master')

@section('content')
<h1>Events</h1>
<p>{{ link_to_action('AdminEventsController@create', 'Add new event') }}</p>

@if ($events->count())
<div id="wrap">
    <table cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered">

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
                <th>Action</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($events as $event)
				<tr>
                    <td>{{{ $event->id }}}</td>
					<td>
                        @if($event->category)
                            {{{ $event->category->name }}}
                        @endif
                    </td>
					<td>
                        @if($event->location)
                            {{{ $event->location->name }}}
                        @endif
                    </td>
					<td>{{{ $event->title }}}</td>
					<td>{{{ $event->date_start }}}</td>
					<td>{{{ $event->date_end }}}</td>
					<td>{{{ $event->address }}}</td>
                    <td>{{{ $event->getHumanCreatedAtAttribute() }}} </td>
                    <td><a href="{{ URL::action('AdminEventsController@settings',$event->id)}}">Settings</a>
                    <button class="btn btn-xs btn-info"> <a href="{{ URL::action('AdminEventsController@edit', array($event->id)) }}">Edit</a></button>

                        {{ Form::open(array('method' => 'DELETE', 'action' => array('AdminEventsController@destroy', $event->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-xs btn-danger')) }}
                        {{ Form::close() }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
    <div class="row">
        <div class="col-md-12">
            {{ $events->links() }}
        </div>
    </div>
@else
	There are no events
@endif

@stop
