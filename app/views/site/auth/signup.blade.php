@extends('site.layouts._one_column')

@section('content')

    <div class="col-md-1"></div>
    <div class="col-md-10">
    <div class="alert alert-info">{{ trans('auth.signup.valid_information')}}</div>

    {{ Form::open(array('method' => 'POST', 'action'=>array('AuthController@postSignup'),'class'=>'form')) }}

    <div class="row">

        <div class="col-xs-6 col-md-6">
            {{ Form::text('name_ar',NULL,array('class'=>'form-control input-lg','placeholder'=> trans('auth.signup.name_ar'))) }}
        </div>
        <div class="col-xs-6 col-md-6">
            {{ Form::text('name_en',NULL,array('class'=>'form-control input-lg','placeholder'=> trans('auth.signup.name_en'))) }}
        </div>

    </div>
    <br>

    {{ Form::text('username',NULL,array('class' => 'form-control input-lg','placeholder' => trans('word.username'))) }}
    <br>

    {{ Form::text('email',NULL,array('class' => 'form-control input-lg','placeholder' => trans('word.email'))) }}
    <br>

    {{ Form::password('password',array('class' => 'form-control input-lg','placeholder' => trans('word.password'))) }}
    <br>

    {{ Form::password('password_confirmation',array('class' => 'form-control input-lg','placeholder' => trans('word.password_confirmation'))) }}
    <br>

    {{ Form::text('mobile',NULL,array('id'=> 'mobile','class'=>'form-control input-lg','placeholder'=> trans('word.mobile'), 'style'=>'float: none; min-width:450px; min-height: 45px; border-radius: 10px; text-indent: 25px;')) }}

    <br><br>

    <button class="btn btn-lg btn-primary btn-block signup-btn" type="submit">
        {{ trans('auth.signup.submit') }}
    </button>
    <br>

    {{ Form::close() }}
    </div>
    <div class="col-md-1"></div>


@stop
@section('script')
@parent
        {{ HTML::script('js/intlTelInput.min.js'); }}
        <script>
          $("#mobile").intlTelInput();
        </script>
@stop
