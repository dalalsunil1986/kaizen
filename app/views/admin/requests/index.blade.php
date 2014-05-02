@extends('admin.layouts.default')

{{-- Content --}}
@section('content')

<h1>All Requests</h1>


@if ($requests->count())
<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>Event Title</th>
        <th>User</th>
        <th>Status</th>
    </tr>
    </thead>

    <tbody>
    @foreach ($requests as $request)
    <tr>
        <td>{{ $request->event->title }}</td>
        <td>{{ $request->user->username }}</td>
        <td>{{ $request->status }} </td>
        <td><a href="{{ URL::action('AdminStatusesController@edit',  array($request->id), array('class' => 'btn btn-info')) }}">Edit</a></td>
        <td>
            {{ Form::open(array('method' => 'DELETE', 'action' => array('AdminStatusesController@destroy', $request->id))) }}
            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
            {{ Form::close() }}
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
@else
There are no categories
@endif

@stop
