@extends('admin.layouts.default')

{{-- Content --}}
@section('content')

<h1>Edit Country</h1>
{{ Form::model($country, array('method' => 'PATCH', 'action' => array('AdminCountriesController@update', $country->id))) }}

<div class="form-group">
    {{ Form::label('name', 'Name:') }}
    {{ Form::text('name', NULL,array('class'=>'form-control')) }}
</div>

{{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
{{ link_to_action('AdminCountriesController@show', 'Cancel', $country->id, array('class' => 'btn')) }}
<!-- ./ form actions -->
{{ Form::close() }}


{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop
