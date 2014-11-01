@extends('site.layouts._one_column')
@section('content')

{{ Form::model($user,array('method' => 'PATCH', 'action'=>array('UserController@update', $user->id),'class'=>'form')) }}
<div class="container">
    <div class="alert alert-info">{{ trans('auth.signup.valid_information')}}</div>
    <div class="row">
        <div class="col-xs-6 col-md-6">
            {{ Form::text('name_ar',NULL,array('class'=>'form-control input-lg','placeholder'=>trans('auth.signup.name_ar'))) }}
        </div>
        <div class="col-xs-6 col-md-6">
            {{ Form::text('name_en',NULL,array('class'=>'form-control input-lg','placeholder'=> trans('auth.signup.name_en'))) }}
        </div>
    </div>
    </br>
    {{ Form::password('password',array('class' => 'form-control input-lg','placeholder' => trans('word.password'))) }}
    </br>
    {{ Form::password('password_confirmation',array('class' => 'form-control input-lg','placeholder' => trans('word.password_confirmation'))) }}
    </br>
    {{ Form::text('phone',NULL,array('class'=>'form-control input-lg','placeholder'=> trans('word.telelphone'))) }}
    </br>
    {{ Form::text('mobile',NULL,array('id'=> 'mobile','class'=>'form-control input-lg','placeholder'=> trans('word.mobile'), 'style'=>'float: none; min-width:450px; min-height: 45px; border-radius: 10px; text-indent: 25px;')) }}
    </br>
    {{ Form::select('country_id', $countries, NULL ,['class' => 'form-control']) }}
    <br/>

    <label>{{ trans('site.gender') }}</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <label class="radio-inline">
        {{ Form::radio('gender', 'Male', null,  ['id' => 'male']) }}
        {{ trans('word.male') }}
    </label>
    <label class="radio-inline">
        {{ Form::radio('gender', 'Female', null,  ['id' => 'female']) }}
        {{ trans('word.female') }}

    </label>
    <br/>
    <div class="row">
        <div class="col-xs-6 col-md-6">
            {{ Form::text('twitter',NULL,array('class'=>'form-control input-lg','placeholder'=> trans('word.twitter'))) }}
        </div>
        <div class="col-xs-6 col-md-6">
            {{ Form::text('instagram',NULL,array('class'=>'form-control input-lg','placeholder'=> trans('word.instagram'))) }}
        </div>
    </div>
    </br>
    {{ Form::textarea('previous_event_comment',NULL,array('class'=>'form-control','placeholder'=> trans('auth.signup.previous_event_participation'),'rows'=>'3')) }}
    </br>
    <button class="btn btn-lg btn-primary btn-block signup-btn" type="submit">
        {{ trans('word.save') }}
    </button>
    <br>
{{ Form::close() }}
</div>
@stop
@section('script')
@parent
    {{ HTML::script('js/intlTelInput.min.js'); }}
    <script>
      $("#mobile").intlTelInput();
    </script>
@stop