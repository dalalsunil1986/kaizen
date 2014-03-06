@extends('layouts.scaffold')

@section('main')

<h1>All Categories</h1>

<p>{{ link_to_action('CategoriesController@create', 'Add new category') }}</p>

@if ($categories->count())
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Name</th>
				<th>Type</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($categories as $category)
				<tr>
					<td>{{ link_to_action('CategoriesController@show', $category->name, $category->id, array('class' => 'btn')) }}</td>
					<td>{{{ $category->type }}}</td>
                    <td><a href="{{ URL::action('CategoriesController@edit',  array($category->id), array('class' => 'btn btn-info')) }}">Edit</a></td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'action' => array('CategoriesController@destroy', $category->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no categories
@endif

@stop
