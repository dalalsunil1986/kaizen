@extends('site.layouts._two_column')
@section('content')

<div class="page-header">
    <h1>{{ trans('auth.forgot.title') }}</h1>
</div>

<form method="POST" action="{{ URL::action('AuthController@postForgot') }}" accept-charset="UTF-8">
    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">

    <div class="form-group">
        <label for="email">{{{ trans('word.email') }}}</label>
        <div class="input-append input-group">
            {{ Form::text('email',null,['class'=>'form-control', 'placeholder'=> trans('word.email')]) }}

            <span class="input-group-btn">
                <input class="btn btn-primary" type="submit" value="{{{ trans('word.submit') }}}">
            </span>
        </div>
    </div>

</form>

@stop
