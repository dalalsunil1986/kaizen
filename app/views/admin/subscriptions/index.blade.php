@extends('admin.master')

{{-- Content --}}
@section('content')
<div class="row " >
    <div class="col-md-12 ">
        <!-- Nav tabs category -->
        <ul class="nav nav-tabs faq-cat-tabs">
            <li class="active"><a href="#event-tab" data-toggle="tab">Event Subscriptions&nbsp;</a></li>
            <li><a href="#package-tab" data-toggle="tab">Package Subscriptions&nbsp;</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content faq-cat-content" style="margin-top:20px;">
            <div class="tab-pane active in fade " id="event-tab">

                <div class="row">
                    <div class="col-md-2">
                        <nav class="nav-sidebar">
                            <ul class="nav tabs">
                                <li class="active"><a href="#tab-single-1" data-toggle="tab">Confirmed</a></li>
                                <li class=""><a href="#tab-single-2" data-toggle="tab">Waiting</a></li>
                                <li class=""><a href="#tab-single-3" data-toggle="tab">Approved</a></li>
                                <li class=""><a href="#tab-single-4" data-toggle="tab">Pending</a></li>
                                <li class=""><a href="#tab-single-5" data-toggle="tab">Rejected</a></li>
                                <li class=""><a href="#tab-single-6" data-toggle="tab">All</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-md-10">
                        <div class="tab-content">
                            <div class="tab-pane active text-style" id="tab-single-1">
                                @if ($subscriptions->count())
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>User</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach ($subscriptions as $subscription)
                                    <tr>
                                        <td>
                                            <a href="{{action('AdminEventsController@getRequests',$subscription->event->id) }}">{{ $subscription->event->title }}</a>
                                        </td>
                                        <td>{{ $subscription->user->username }}</td>
                                        <td>{{ $subscription->status }}</td>
                                        <td>
                                            <a href="{{ URL::action('AdminSubscriptionsController@edit',  array($subscription->id), array('class' => 'btn btn-info')) }}">Edit</a>
                                        </td>
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

                            </div>
                            <div class="tab-pane text-style" id="tab-single-2">
                                <h2>Dolor asit amet</h2>
                                <p>D voluptua.</p>
                            </div>
                            <div class="tab-pane text-style" id="tab-single-3">
                                <h2>Stet clita</h2>
                                <p>Sre te feugait nulla facilisi. Lorem ipsum dolor sit amet,</p>
                            </div>
                            <div class="tab-pane text-style" id="tab-single-4">
                                <h2>Stet clita</h2>
                                <p>Sre te feugait nulla facilisi. Lorem ipsum dolor sit amet,</p>
                            </div>
                            <div class="tab-pane text-style" id="tab-single-5">
                                <h2>Stet clita</h2>
                                <p>Sre te feugait nulla facilisi. Lorem ipsum dolor sit amet,</p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="tab-pane fade" id="package-tab">

                <div class="row">
                    <div class="col-md-2">
                        <nav class="nav-sidebar">
                            <ul class="nav tabs">
                                <li class="active"><a href="#tab-package-1" data-toggle="tab">Confirmed</a></li>
                                <li class=""><a href="#tab-package-2" data-toggle="tab">Waiting</a></li>
                                <li class=""><a href="#tab-package-3" data-toggle="tab">Approved</a></li>
                                <li class=""><a href="#tab-package-4" data-toggle="tab">Pending</a></li>
                                <li class=""><a href="#tab-package-5" data-toggle="tab">Rejected</a></li>
                                <li class=""><a href="#tab-package-6" data-toggle="tab">All</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-md-10">
                        <div class="tab-content">
                            <div class="tab-pane active text-style" id="tab-package-1">
                                @if ($subscriptions->count())
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>User</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach ($subscriptions as $subscription)
                                    <tr>
                                        <td>
                                            <a href="{{action('AdminEventsController@getRequests',$subscription->event->id) }}">{{ $subscription->event->title }}</a>
                                        </td>
                                        <td>{{ $subscription->user->username }}</td>
                                        <td>{{ $subscription->status }}</td>
                                        <td>
                                            <a href="{{ URL::action('AdminSubscriptionsController@edit',  array($subscription->id), array('class' => 'btn btn-info')) }}">Edit</a>
                                        </td>
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

                            </div>
                            <div class="tab-pane text-style" id="tab-package-2">
                                <h2>Dolor asit amet</h2>
                                <p>D voluptua.</p>
                            </div>
                            <div class="tab-pane text-style" id="tab-package-3">
                                <h2>Stet clita</h2>
                                <p>Sre te feugait nulla facilisi. Lorem ipsum dolor sit amet,</p>
                            </div>
                            <div class="tab-pane text-style" id="tab-package-4">
                                <h2>Stet clita</h2>
                                <p>Sre te feugait nulla facilisi. Lorem ipsum dolor sit amet,</p>
                            </div>
                            <div class="tab-pane text-style" id="tab-package-5">
                                <h2>Stet clita</h2>
                                <p>Sre te feugait nulla facilisi. Lorem ipsum dolor sit amet,</p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@stop


