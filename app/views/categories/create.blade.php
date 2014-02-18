@extends('layouts.scaffold')

@section('main')

<h1>Create Category</h1>

{{ Form::open(array('action' => 'CategoriesController@store')) }}
	<ul>
        <li>
            {{ Form::label('name', 'Name:') }}
            {{ Form::text('name') }}
        </li>

        <li>
            {{ Form::label('type', 'Type:') }}
            {{ Form::select('type',['EventModel' => 'Event','Post' => 'Blog']) }}
        </li>

		<li>
			{{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop


