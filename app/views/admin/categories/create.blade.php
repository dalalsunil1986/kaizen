@extends('admin.layouts.default')

{{-- Content --}}
@section('content')

<h1>Create Category</h1>

{{ Form::open(array('action' => 'AdminCategoriesController@store')) }}
        <div class="form-group">
            {{ Form::label('name', 'Category Name:',array('class'=>'control-label')) }}
            {{ Form::text('name',NULL,array('class'=>'form-control')) }}
        </div>

        <div class="form-group">
            {{ Form::label('type', 'Type:') }}
            {{ Form::select('type',['EventModel' => 'Event','Post' => 'Blog'],NULL,array('class'=>'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
        </div>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop


