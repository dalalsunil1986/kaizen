@extends('admin.master')

@section('content')

    <div class="row">

        {{ Form::model($user, array('method' => 'PATCH', 'action' => array('AdminUsersController@update', $user->id), 'role'=>'form')) }}

                    <!-- username -->
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="username">Username</label>
                        <div class="col-md-10">
                            {{ Form::text('username',null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <!-- ./ username -->

                    <!-- Email -->
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="email">Email</label>
                        <div class="col-md-10">
                            {{ Form::text('email',null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <!-- ./ email -->

                    <!-- Password -->
                    <div class="form-group ">
                        <label class="col-md-2 control-label" for="password">Password</label>
                        <div class="col-md-10">
                            {{ Form::password('password',array('class' => 'form-control input-lg')) }}
                        </div>
                    </div>
                    <!-- ./ password -->

                    <!-- Password Confirm -->
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="password_confirmation">Password Confirm</label>
                        <div class="col-md-10">
                            {{ Form::password('password_confirmation',array('class' => 'form-control input-lg')) }}
                        </div>
                    </div>
                    <!-- ./ password confirm -->

                    <!-- Activation Status -->
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="confirm">Activate User?</label>
                        <div class="col-md-6">
                            @if ($mode == 'create')
                                <select class="form-control" name="confirm" id="confirm">
                                    <option value="1"{{{ (Input::old('confirm', 0) === 1 ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.yes') }}}</option>
                                    <option value="0"{{{ (Input::old('confirm', 0) === 0 ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.no') }}}</option>
                                </select>
                            @else
                                <select class="form-control" {{{ ($user->id === Confide::user()->id ? ' disabled="disabled"' : '') }}} name="confirm" id="confirm">
                                    <option value="1"{{{ ($user->confirmed ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.yes') }}}</option>
                                    <option value="0"{{{ ( ! $user->confirmed ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.no') }}}</option>
                                </select>
                            @endif
                        </div>
                    </div>
                    <!-- ./ activation status -->

                    <!-- Groups -->
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="roles">Roles</label>
                        <div class="col-md-6">
                            <select class="form-control" name="roles[]" id="roles[]" multiple>
                                @foreach ($roles as $role)
                                    @if ($mode == 'create')
                                        <option value="{{{ $role->id }}}"{{{ ( in_array($role->id, $selectedRoles) ? ' selected="selected"' : '') }}}>{{{ $role->name }}}</option>
                                    @else
                                        <option value="{{{ $role->id }}}"{{{ ( array_search($role->id, $user->currentRoleIds()) !== false && array_search($role->id, $user->currentRoleIds()) >= 0 ? ' selected="selected"' : '') }}}>{{{ $role->name }}}</option>
                                    @endif
                                @endforeach
                            </select>

                            <span class="help-block">
                                Select a group to assign to the user, remember that a user takes on the permissions of the group they are assigned.
                            </span>
                        </div>
                    </div>

                <!-- Form Actions -->
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <element class="btn-cancel close_popup">Cancel</element>
                        <button type="reset" class="btn btn-default">Reset</button>
                        <button type="submit" class="btn btn-success">OK</button>
                    </div>
                </div>
            <!-- ./ form actions -->
        {{ Form::close() }}
    </div>
@stop