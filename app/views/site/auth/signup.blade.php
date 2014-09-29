@extends('site.layouts._one_column')

@section('content')

    <div class="col-md-1"></div>
    <div class="col-md-10">
    <div class="alert alert-info">{{ Lang::get('site.general.warning_msg')}}</div>

    {{ Form::open(array('method' => 'POST', 'action'=>array('AuthController@postSignup'),'class'=>'form')) }}

    <div class="row">

        <div class="col-xs-6 col-md-6">
            {{ Form::text('name_ar',NULL,array('class'=>'form-control input-lg','placeholder'=>Lang::get('site.general.first_name'))) }}
        </div>
        <div class="col-xs-6 col-md-6">
            {{ Form::text('name_en',NULL,array('class'=>'form-control input-lg','placeholder'=> Lang::get('site.general.last_name'))) }}
        </div>

    </div>
    <br>

    {{ Form::text('username',NULL,array('class' => 'form-control input-lg','placeholder' => Lang::get('site.general.username'))) }}
    <br>

    {{ Form::text('email',NULL,array('class' => 'form-control input-lg','placeholder' => Lang::get('site.general.email'))) }}
    <br>

    {{ Form::password('password',array('class' => 'form-control input-lg','placeholder' => Lang::get('site.general.pass'))) }}
    <br>

    {{ Form::password('password_confirmation',array('class' => 'form-control input-lg','placeholder' => Lang::get('site.general.pass_confirm'))) }}
    <br>

    {{--{{ Form::text('mobile',NULL,array('class'=>'col-md-10 form-control input-lg','placeholder'=> Lang::get('site.general.mobile'))) }}--}}
    {{ Form::text('mobile',NULL,array('id'=> 'mobile','class'=>'form-control input-lg','placeholder'=> Lang::get('site.general.mobile'), 'style'=>'float: none; min-width:450px; min-height: 45px; border-radius: 10px; text-indent: 25px;')) }}

    <br>

    <button class="btn btn-lg btn-primary btn-block signup-btn" type="submit">
        {{ Lang::get('button.create') }}
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
