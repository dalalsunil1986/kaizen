@extends('site.layouts._one_column')
@section('content')

<div class="alert alert-info">{{ Lang::get('site.general.warning_msg')}}</div>

{{ Form::model($user,array('method' => 'PATCH', 'action'=>array('UserController@update', $user->id),'class'=>'form')) }}

    <div class="row">
        <div class="col-xs-6 col-md-6">
            {{ Form::text('name_ar',NULL,array('class'=>'form-control input-lg','placeholder'=>Lang::get('site.general.first_name'))) }}
        </div>
        <div class="col-xs-6 col-md-6">
            {{ Form::text('name_en',NULL,array('class'=>'form-control input-lg','placeholder'=> Lang::get('site.general.last_name'))) }}
        </div>
    </div>
    </br>
    {{ Form::password('password',array('class' => 'form-control input-lg','placeholder' => Lang::get('site.general.pass'))) }}
    </br>
    {{ Form::password('password_confirmation',array('class' => 'form-control input-lg','placeholder' => Lang::get('site.general.pass_confirm'))) }}
    </br>
    {{ Form::text('phone',NULL,array('class'=>'form-control input-lg','placeholder'=> Lang::get('site.general.mobile'))) }}
    </br>
    {{ Form::text('mobile',NULL,array('class'=>'form-control input-lg','placeholder'=> Lang::get('site.general.telelphone'))) }}
    </br>
        {{ Form::select('country_id', array('0'=>'Choose Country',$countries), NULL ,['class' => 'form-control']) }}
    <br/>
    <label>{{ Lang::get('site.general.gender') }}</label>
    <label class="radio-inline">
        {{ Form::radio('gender', 'M', null,  ['id' => 'male']) }}
        Male
    </label>
    <label class="radio-inline">
        {{ Form::radio('gender', 'F', null,  ['id' => 'female']) }}
        Female
    </label>
    <br/>
    <div class="row">
        <div class="col-xs-6 col-md-6">
            {{ Form::text('twitter',NULL,array('class'=>'form-control input-lg','placeholder'=> Lang::get('site.general.twitter'))) }}
        </div>
        <div class="col-xs-6 col-md-6">
            {{ Form::text('instagram',NULL,array('class'=>'form-control input-lg','placeholder'=> Lang::get('site.general.instagram'))) }}
        </div>
    </div>
    </br>
    {{ Form::textarea('prev_event_comment',NULL,array('class'=>'form-control','placeholder'=> Lang::get('site.general.prev_events'),'rows'=>'3')) }}
    </br>
    <button class="btn btn-lg btn-primary btn-block signup-btn" type="submit">
        Create my account
    </button>
    <br>
{{ Form::close() }}

@stop