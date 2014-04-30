@extends('admin.layouts.default')

{{-- Content --}}
@section('content')
<h2>User Requests for {{ $event->title }}</h2>
@if(count($event->statuses))
    <h3>Total {{count($event->statuses)}} User Requests</h3>
@else
    <h3>No User Requests Yet</h3>
@endif

<h3></h3>
<br>
<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>Username</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    </thead>

    <tbody>
    @if(count($event->statuses))
        @foreach($event->statuses as $user)
        <tr>
            <td><a href="">{{{ $user->username }}} ({{ $user->email }})</a></td>
            <td><span class=""> {{{ $user->pivot->status }}} </span></td>
            <td><a href="{{ URL::action('AdminStatusesController@edit', array($user->pivot->id), array('class' => 'btn btn-info')) }}">Edit</a></td>
        </tr>
        @endforeach
    @endif
    </tbody>
</table>

@stop