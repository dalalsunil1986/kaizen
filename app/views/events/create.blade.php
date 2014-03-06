@extends('layouts.scaffold')

@section('main')

<h1>Create Event</h1>

{{ Form::open(array('action' => 'EventsController@store','files' => true)) }}
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
            {{ Form::text('title') }}
        </li>

        <li>
            {{ Form::label('title_en', 'Title_en:') }}
            {{ Form::text('title_en') }}
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
            {{ Form::label('price', 'Price:') }}
            {{ Form::text('description_en') }}
        </li>

        <li>
            {{ Form::label('date_start', 'Date_start:') }}
            {{ Form::text('date_start') }}
        </li>

        <li>
            {{ Form::label('date_end', 'Date_end:') }}
            {{ Form::textarea('date_end') }}
        </li>

        <li>
            {{ Form::label('time_start', 'Time_start:') }}
            {{ Form::text('time_start') }}
        </li>

        <li>
            {{ Form::label('time_end', 'Time_end:') }}
            {{ Form::text('time_end') }}
        </li>

        <li>
            {{ Form::label('address', 'Address:') }}
            {{ Form::textarea('address') }}
        </li>

        <li>
            {{ Form::label('address_en', 'Address_en:') }}
            {{ Form::textarea('address_en') }}
        </li>

        <li>
            {{ Form::label('street', 'Street:') }}
            {{ Form::text('street') }}
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
            {{ Form::label('Free', 'Free:') }}
            {{ Form::checkbox('free','1',false) }}
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


