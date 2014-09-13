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
				<th class="col-md-2">{{{ Lang::get('admin/users/table.username') }}}</th>
				<th class="col-md-2">{{{ Lang::get('admin/users/table.email') }}}</th>
				<th class="col-md-2">{{{ Lang::get('admin/users/table.roles') }}}</th>
				<th class="col-md-2">{{{ Lang::get('admin/users/table.activated') }}}</th>
				<th class="col-md-2">{{{ Lang::get('admin/users/table.created_at') }}}</th>
				<th class="col-md-2">{{{ Lang::get('table.actions') }}}</th>
			</tr>
		</thead>
        <tbody>
        @foreach($users as $user)
        <tr class="gradeX">
            <td>{{ $user->username }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->rolename }}</td>
            <td>{{ $user->active == 1 ? 'true':'false' }}</td>
            <td>{{ $user->created_at }}</td>

            <td>
                <a href="{{  URL::to('admin/users/' . $user->id . '/print' ) }}" class="iframe btn btn-xs btn-default"><i class="glyphicon glyphicon-print"></i> Print</a>
                <a href="{{  URL::to('admin/users/' . $user->id . '/edit' ) }}" class="iframe btn btn-xs btn-default">{{{ Lang::get('button.edit') }}}</a>
                <a href="{{  URL::to('admin/users/' . $user->id . '/delete' ) }}" class="iframe btn btn-xs btn-danger">{{{ Lang::get('button.delete') }}}</a>
            </td>
        </tr>
        @endforeach

		</tbody>
	</table>
</div>
@stop