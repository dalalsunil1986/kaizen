@extends('admin.master')

{{-- Content --}}
@section('content')

<h1>Subscriptions</h1>


@if ($subscriptions->count())
<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>Event </th>
        <th>User</th>
        <th>Status</th>
    </tr>
    </thead>

    <tbody>
    @foreach ($subscriptions as $subscription)
    <tr>
        <td><a href="{{action('AdminEventsController@getRequests',$subscription->event->id) }}">{{ $subscription->event->title }}</a></td>
        <td>{{ $subscription->user->username }}</td>
        <td>{{ $subscription->status }} </td>
        <td><a href="{{ URL::action('AdminSubscriptionsController@edit',  array($subscription->id), array('class' => 'btn btn-info')) }}">Edit</a></td>
        <td>
            {{ Form::open(array('method' => 'DELETE', 'action' => array('AdminSubscriptionsController@destroy', $subscription->id))) }}
            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
            {{ Form::close() }}
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
@else
No Subscriptions Yet
@endif

@stop
