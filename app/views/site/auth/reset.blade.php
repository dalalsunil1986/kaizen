@extends('site.layouts._two_column')
@section('content')
<div class="page-header">
	<h1>Forgot Password</h1>
</div>
{{ Form::open(['action' => 'AuthController@postReset', 'method' => 'post']) }}
    <input type="hidden" name="token" value="{{ $token }}">

    <div class="form-group">
        <label for="email">{{{ Lang::get('confide.e_mail') }}}</label>
        {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => Lang::get('confide.e_mail') ]) }}
    </div>
    <div class="form-group">
        <label for="password">{{{ Lang::get('confide.password') }}}</label>
        {{ Form::password('password', ['class' => 'form-control', 'placeholder' =>Lang::get('confide.password') ]) }}
    </div>
    <div class="form-group">
        <label for="password_confirmation">{{{ Lang::get('confide.password_confirmation') }}}</label>
        {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' =>Lang::get('confide.password_confirmation') ]) }}
    </div>

    @if ( Session::get('error') )
    <div class="alert alert-error alert-danger">{{{ Session::get('error') }}}</div>
    @endif

    @if ( Session::get('notice') )
    <div class="alert">{{{ Session::get('notice') }}}</div>
    @endif

    <div class="form-actions form-group">
        <button type="submit" class="btn btn-primary">{{{ Lang::get('confide.forgot.submit') }}}</button>
    </div>
{{ Form::close() }}
@stop
