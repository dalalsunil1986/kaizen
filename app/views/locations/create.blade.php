@extends('layouts.scaffold')

@section('main')

<h1>Create Location</h1>

{{ Form::open(array('action' => 'LocationsController@store')) }}
	<ul>
        <li>
            {{ Form::label('name', 'Name:') }}
            {{ Form::text('name') }}
        </li>

        <li>
            {{ Form::label('country_id', 'Country_id:') }}
            {{ Form::select('country_id', $countries) }}
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