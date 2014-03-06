@extends('layouts.scaffold')

@section('main')

<h1>Edit Location</h1>
{{ Form::model($location, array('method' => 'PATCH', 'action' => array ('LocationsController@update', $location->id))) }}
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
			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
			{{ link_to('locations.show', 'Cancel', $location->id, array('class' => 'btn')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop
