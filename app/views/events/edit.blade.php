@extends('layouts.scaffold')

@section('main')

<h1>Edit Event</h1>
{{ Form::model($event, array('method' => 'PATCH', 'action' => array('EventsController@update', $event->id), 'files' => true)) }}
	<ul>
        <li>
            {{ Form::label('user_id', 'Author:') }}
            {{ Form::select('user_id', $author) }}
        </li>

        <li>
            {{ Form::label('category_id', 'Category_id:') }}
            {{ Form::select('category_id', $category) }}
        </li>

        <li>
            {{ Form::label('location_id', 'Location:') }}
            {{ Form::select('location_id', $location) }}
        </li>

        <li>
            {{ Form::label('title', 'Title:') }}
            {{ Form::textarea('title') }}
        </li>

        <li>
            {{ Form::label('title_en', 'Title_en:') }}
            {{ Form::textarea('title_en') }}
        </li>

        <li>
            {{ Form::label('description', 'Description:') }}
            {{ Form::textarea('description') }}
        </li>

        <li>
            {{ Form::label('description_en', 'Description_en:') }}
            {{ Form::textarea('description_en') }}
        </li>

        <li>
            {{ Form::label('date_start', 'Date_start:') }}
            {{ Form::textarea('date_start') }}
        </li>

        <li>
            {{ Form::label('date_end', 'Date_end:') }}
            {{ Form::textarea('date_end') }}
        </li>

        <li>
            {{ Form::label('time_start', 'Time_start:') }}
            {{ Form::textarea('time_start') }}
        </li>

        <li>
            {{ Form::label('time_end', 'Time_end:') }}
            {{ Form::textarea('time_end') }}
        </li>

        <li>
            {{ Form::label('address', 'Address:') }}
            {{ Form::text('address') }}
        </li>

        <li>
            {{ Form::label('address_en', 'Address_en:') }}
            {{ Form::text('address_en') }}
        </li>

        <li>
            {{ Form::label('street', 'Street:') }}
            {{ Form::textarea('street') }}
        </li>

        <li>
            {{ Form::label('street_en', 'Street_en:') }}
            {{ Form::text('street_en') }}
        </li>
        <li>
            {{ Form::label('thumbnail', 'Thumbnail:') }}
            {{ Form::file('thumbnail') }}
        </li>

		<li>
			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
			{{ link_to_action('EventsController@show', 'Cancel', $event->id, array('class' => 'btn')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop
