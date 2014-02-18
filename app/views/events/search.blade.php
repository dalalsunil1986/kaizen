@extends('layouts.scaffold')

@section('main')

<h1>Search Event</h1>
{{ Form::open(array('method' => 'GET', 'action' => array('EventsController@search'))) }}
	<ul>
        <li>
            {{ Form::label('search', 'Search:') }}
            {{ Form::text('search',$search) }}

        </li>
        <li>
            {{ Form::label('user', 'Author:') }}
            {{ Form::select('user', $authors) }}
        </li>

        <li>
            {{ Form::label('category', 'Category_id:') }}
            {{ Form::select('category', $categories) }}
        </li>

        <li>
            {{ Form::label('country', 'Country:') }}
            {{ Form::select('country', $countries) }}
        </li>

		<li>
			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop

@if(isset($events))
    @if(count($events) >= 1 )
        @foreach($events as $event) {
            {{ $event->title }}
        }
        @endforeach
    @endif
@endif