@extends('site.layouts._one_column')

@section('content')

    <div class="alert alert-info">{{ Lang::get('site.general.warning_msg')}}</div>

    {{ Form::open(array('method' => 'POST', 'action'=>array('AuthController@postRegister'),'class'=>'form')) }}

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

    {{ Form::text('mobile',NULL,array('class'=>'form-control input-lg','placeholder'=> Lang::get('site.general.mobile'))) }}
    <br>

    <button class="btn btn-lg btn-primary btn-block signup-btn" type="submit">
        Create my account
    </button>
    <br>

    {{ Form::close() }}

@stop