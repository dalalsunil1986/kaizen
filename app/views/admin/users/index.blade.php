@extends('admin.master')

{{-- Web site Title --}}
@section('title')
{{{ $title }}} :: @parent
@stop

{{-- Content --}}
@section('content')

<div class="page-header">
    <h3>
         Manage Users

        <div class="pull-right">
            <a href="{{{ URL::to('admin/users/create') }}}" class="btn btn-small btn-info iframe"><span class="glyphicon glyphicon-plus-sign"></span> Create</a>
        </div>
    </h3>
</div>
<div id="wrap">
    <table cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered">
        <thead>
        <tr>
				<th class="col-md-2">Name in AR</th>
				<th class="col-md-2">Name in EN</th>
				<th class="col-md-2">Email</th>
				<th class="col-md-2">Active</th>
				<th class="col-md-2">Register on</th>
				<th class="col-md-2">Role</th>
				<th class="col-md-2">Action</th>
			</tr>
		</thead>
        <tbody>
        @foreach($users as $user)
        <tr class="gradeX">
            <td>{{ $user->name_ar }}</td>
            <td>{{ $user->name_en }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->active == 1 ? 'true':'false' }}</td>
            <td>{{ $user->created_at }}</td>
            <td>{{ $user->rolename }}</td>
            <td>
                <a href="{{  URL::to('admin/users/' . $user->id . '/print' ) }}" class="iframe btn btn-xs btn-default"><i class="glyphicon glyphicon-print"></i> Print</a>
                <a href="{{  URL::to('admin/users/' . $user->id . '/edit' ) }}" class="iframe btn btn-xs btn-default">{{{ Lang::get('button.edit') }}}</a>
                {{ Form::open(array('method' => 'DELETE', 'action' => array('AdminUsersController@destroy', $user->id))) }}
                    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                {{ Form::close() }}
            </td>
        </tr>
        @endforeach

		</tbody>
	</table>
</div>
@stop