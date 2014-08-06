@extends('admin.master')

{{-- Content --}}
@section('content')
<h2>User Requests for {{ $event->title }}</h2>
@if(count($event->subscriptions))
    <h3>Total {{count($event->subscriptions)}} User Requests</h3>
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
    @if(count($event->subscriptions))
        @foreach($event->subscriptions as $subscription)
        <tr>
            <td><a href="">{{{ $subscription->user->username }}} ({{ $subscription->user->email }})</a></td>
            <td><span class=""> {{{ $subscription->status }}} </span></td>
            <td><a href="{{ URL::action('AdminSubscriptionsController@edit', array($subscription->id), array('class' => 'btn btn-info')) }}">Edit</a></td>
        </tr>
        @endforeach
    @endif
    </tbody>
</table>

@stop