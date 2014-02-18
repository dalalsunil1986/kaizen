@extends('layouts.scaffold')

@section('main')

<h1>Edit Country</h1>
{{ Form::model($country, array('method' => 'PATCH', 'route' => array('countries.update', $country->id))) }}
	<ul>
        <li>
            {{ Form::label('name', 'Name:') }}
            {{ Form::text('name') }}
        </li>

		<li>
			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
			{{ link_to_route(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), '/countries/'), 'Cancel', $country->id, array('class' => 'btn')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop
