@extends('admin.layouts.default')

{{-- Content --}}
@section('content')

<h1>Update Contact-Us Details</h1>

{{ Form::model($contact,array('method' => 'POST','action' => array('AdminContactsController@store'))) }}
        <div class="form-group">
            {{ Form::label('username', 'Name:',array('class'=>'control-label')) }}
            {{ Form::text('username',NULL,array('class'=>'form-control')) }}
        </div>
    <div class="form-group">
        {{ Form::label('address', 'Company Address:',array('class'=>'control-label')) }}
        {{ Form::textarea('address',NULL,array('class'=>'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('email', 'Company Email:',array('class'=>'control-label')) }}
        {{ Form::text('email',NULL,array('class'=>'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('phone', 'Company Phone:',array('class'=>'control-label')) }}
        {{ Form::text('phone',NULL,array('class'=>'form-control')) }}
    </div>
<div class="form-group">
        {{ Form::label('mobile', 'Mobile Phone:',array('class'=>'control-label')) }}
        {{ Form::text('mobile',NULL,array('class'=>'form-control')) }}
    </div>

        <div class="form-group">
            {{ Form::submit('Update', array('class' => 'btn btn-info')) }}
        </div>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop


