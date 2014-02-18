@extends('layouts.scaffold')

@section('main')

<h1>Show Category</h1>

<p>{{ link_to_action('CategoriesController@index', 'Return to all categories') }}</p>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Name</th>
				<th>Type</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>{{{ $category->name }}}</td>
					<td>{{{ $category->type }}}</td>
                    <td>{{ link_to_action('CategoriesController@edit', 'Edit', array($category->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'action' => array('CategoriesController@destroy', $category->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
		</tr>
	</tbody>
</table>

@stop
