@extends('admin.layouts.default')

{{-- Content --}}
@section('content')
<h1>Events</h1>
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

			@endforeach
		</tbody>
	</table>
    <div class="row">
        <div class="col-md-12">
            {{ $events->links() }}
        </div>
    </div>
@else
	There are no events
@endif

@stop
