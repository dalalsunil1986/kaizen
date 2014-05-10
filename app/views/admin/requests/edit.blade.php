@extends('admin.layouts.default')

{{-- Content --}}
@section('content')

<h1>Edit Request for {{ $request->user->username }} in event {{ $request->event->title }} </h1>

{{ Form::model($request, array('method' => 'PATCH', 'role'=>'form', 'action' => array('AdminStatusesController@update', $request->id))) }}
    <div class="row">
        <div class="form-group col-md-6">
            {{ Form::select('status', array('APPROVED'=>'APPROVED','CONFIRMED'=>'CONFIRMED','PENDING'=>'PENDING','REJECTED'=>'REJECTED'),NULL,array('class'=>'form-control')) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::textarea('reason', NULL,array('class'=>'form-control','placeholder'=>'Your request have been ... ')) }}
        </div>

        <div class="form-group col-md-6">
            {{ Form::submit('Update', array('class' => 'btn btn-info')) }}
            {{ link_to_action('AdminEventsController@getRequests', 'Cancel', $request->event_id, array('class' => 'btn')) }}
        </div>
    </div>

{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop
