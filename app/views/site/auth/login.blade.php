@extends('site.layouts._two_column')

@section('login')
@stop

@section('content')

<div class="page-header">
    <h1>{{ Lang::get('site.general.entry')}}</h1>
</div>
{{ Form::open(['action' => 'AuthController@postLogin', 'method' => 'post']) }}
    <div class="form-group">
        <label class="col-md-2 control-label" for="email">{{ Lang::get('confide.username_e_mail') }}</label>
        <div class="col-md-10">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => Lang::get('site.auth.username_e_mail') ]) }}
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label" for="password">
            {{ Lang::get('confide.password') }}
        </label>
        <div class="col-md-10">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                {{ Form::password('password', ['class' => 'form-control', 'placeholder' => Lang::get('site.auth.password') ]) }}
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <div class="checkbox">
                <label class="checkbox">
                    {{ Form::checkbox('remember', '1', true,  ['id' => 'remember']) }}
                    {{ Lang::get('site.auth.login.remember') }}
                </label>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <button tabindex="3" type="submit" class="btn btn-primary">{{ Lang::get('confide.login.submit') }}</button>
            <a class="btn btn-default" href="forgot">{{ Lang::get('confide.login.forgot_password') }}</a>
            <a href="{{ action('AuthController@getSignup') }}" type="submit" class="btn btn-default">{{ Lang::get('site.nav.register') }}</a>
        </div>
    </div>
</form>

@stop
