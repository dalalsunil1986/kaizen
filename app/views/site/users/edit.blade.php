@extends('site.layouts._one_column')
@section('content')


{{ Form::model($user,array('method' => 'PATCH', 'action'=>array('UserController@update', $user->id),'class'=>'form')) }}
<div class="container">
    <div class="alert alert-info">{{ Lang::get('site.warning_msg')}}</div>
    <div class="row">
        <div class="col-xs-6 col-md-6">
            {{ Form::text('name_ar',NULL,array('class'=>'form-control input-lg','placeholder'=>Lang::get('site.first_name'))) }}
        </div>
        <div class="col-xs-6 col-md-6">
            {{ Form::text('name_en',NULL,array('class'=>'form-control input-lg','placeholder'=> Lang::get('site.last_name'))) }}
        </div>
    </div>
    </br>
    {{ Form::password('password',array('class' => 'form-control input-lg','placeholder' => Lang::get('site.pass'))) }}
    </br>
    {{ Form::password('password_confirmation',array('class' => 'form-control input-lg','placeholder' => Lang::get('site.pass_confirm'))) }}
    </br>
    {{ Form::text('phone',NULL,array('class'=>'form-control input-lg','placeholder'=> Lang::get('site.telelphone'))) }}
    </br>
    {{ Form::text('mobile',NULL,array('id'=> 'mobile','class'=>'form-control input-lg','placeholder'=> Lang::get('site.mobile'), 'style'=>'float: none; min-width:450px; min-height: 45px; border-radius: 10px; text-indent: 25px;')) }}
    </br>
    {{ Form::select('country_id', array_merge([''=> trans('site.select_country')], $countries), NULL ,['class' => 'form-control']) }}

    <br/>

    <label>{{ Lang::get('site.gender') }}</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <label class="radio-inline">
        {{ Form::radio('gender', 'M', null,  ['id' => 'male']) }}
        {{ trans('site.male') }}
    </label>
    <label class="radio-inline">
        {{ Form::radio('gender', 'F', null,  ['id' => 'female']) }}
        {{ trans('site.female') }}

    </label>
    <br/>
    <div class="row">
        <div class="col-xs-6 col-md-6">
            {{ Form::text('twitter',NULL,array('class'=>'form-control input-lg','placeholder'=> Lang::get('site.twitter'))) }}
        </div>
        <div class="col-xs-6 col-md-6">
            {{ Form::text('instagram',NULL,array('class'=>'form-control input-lg','placeholder'=> Lang::get('site.instagram'))) }}
        </div>
    </div>
    </br>
    {{ Form::textarea('prev_event_comment',NULL,array('class'=>'form-control','placeholder'=> Lang::get('site.prev_events'),'rows'=>'3')) }}
    </br>
    <button class="btn btn-lg btn-primary btn-block signup-btn" type="submit">
        {{ trans('site.save') }}
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