@extends('site.layouts._two_column')

@section('login')
@stop

@section('content')

<div class="page-header">
    <h1>{{ trans('auth.login.heading')}}</h1>
</div>
{{ Form::open(['action' => 'AuthController@postLogin', 'method' => 'post']) }}
    <label class="col-md-2 control-label" for="email">{{ trans('word.email') }}</label>
    <div class="col-md-10">
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => trans('word.email') ]) }}
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label" for="password">
            {{ trans('word.password')}}
        </label>
        <div class="col-md-10">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                {{ Form::password('password', ['class' => 'form-control', 'placeholder' => trans('word.password') ]) }}
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <div class="checkbox">
                <label class="checkbox">
                    {{ Form::checkbox('remember', '1', true,  ['id' => 'remember']) }}
                    {{ trans('word.remember') }}
                </label>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <button tabindex="3" type="submit" class="btn btn-primary">{{ trans('auth.login.submit') }}</button>
            <a class="btn btn-default" href="forgot">{{ trans('word.forgot-password') }}</a>
            <a href="{{ action('AuthController@getSignup') }}" type="submit" class="btn btn-default">{{ trans('word.register') }}</a>
        </div>
    </div>
</form>

@stop
