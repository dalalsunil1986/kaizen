@extends('admin.layouts.default')

{{-- Content --}}
@section('content')
<h1>Subscriptions For {{ $event->title }}</h1>
<p>{{ link_to_action('AdminEventsController@create', 'Add new event') }}</p>

@if(count($users))
<h3>Total {{count($users) }} Users Subscribed for This Event</h3>
@else
<h3>No Users Have Subscribed for This Event Yet</h3>
@endif

<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>Username</th>
        <th>Email</th>
    </tr>
    </thead>

    <tbody>
    @foreach($users as $user)
    <tr>
        <td><a href="{{ action('UserController@getProfile',$user->id) }}">{{{ $user->username }}}</a></td>
        <td>{{{ $user->email }}} </td>
    </tr>
    @endforeach
    </tbody>
</table>

@stop