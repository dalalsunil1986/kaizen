@extends('site.layouts.home')
@section('maincontent')

<div class="row">
    <div class="alert alert-warning">{{ Lang::get('site.general.warning_msg')}}</div>

    {{ Form::open(array('method' => 'POST', 'action'=>array('UserController@store'),'class'=>'form')) }}

    @if ( Session::get('errors') )
    <div class="alert alert-danger">Please fix the Errors<br/>{{ implode('', $errors->all('<p> - :message</p>')) }}</div>
    @endif

    <div class="row">
        <div class="col-xs-6 col-md-6">
            {{ Form::text('first_name',NULL,array('class'=>'form-control input-lg','placeholder'=>Lang::get('site.general.first_name'))) }}

        </div>
        <!--            {{ $errors->first('first_name', '<span class="error">:message</span>') }}-->
        <div class="col-xs-6 col-md-6">
            {{ Form::text('last_name',NULL,array('class'=>'form-control input-lg','placeholder'=> Lang::get('site.general.last_name'))) }}
        </div>
        <!--            {{ $errors->first('last_name', '<span class="error">:message</span>') }}-->
    </div>
    <br/>
        {{ Form::text('username',NULL,array('class' => 'form-control input-lg','placeholder' => Lang::get('site.general.username'))) }}
    <br/>
        {{ Form::text('email',NULL,array('class' => 'form-control input-lg','placeholder' => Lang::get('site.general.email'))) }}


    </br>
    {{ Form::password('password',array('class' => 'form-control input-lg','placeholder' => Lang::get('site.general.pass'))) }}

    </br>
    <!--        {{ $errors->first('password', '<span class="error">:message</span>') }}-->
    {{ Form::password('password_confirmation',array('class' => 'form-control input-lg','placeholder' => Lang::get('site.general.pass_confirm'))) }}
    </br>
    <!--        {{ $errors->first('password_confirmation', '<span class="error">:message</span>') }}-->
    {{ Form::text('phone',NULL,array('class'=>'form-control input-lg','placeholder'=> Lang::get('site.general.mobile'))) }}

    </br>
    <!--        {{ $errors->first('mobile', '<span class="error">:message</span>') }}-->
    {{ Form::text('mobile',NULL,array('class'=>'form-control input-lg','placeholder'=> Lang::get('site.general.telelphone'))) }}
    </br>

    {{ Form::select('country_id', array('0'=>'Choose Country',$countries), NULL ,['class' => 'form-control']) }}

    </br>
    <label>{{ Lang::get('site.general.gender') }}</label>
    <label class="radio-inline">
        {{ Form::radio('gender', 'M', true,  ['id' => 'male']) }}
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
        <!--            {{ $errors->first('twitter', '<span class="error">:message</span>') }}-->
        <div class="col-xs-6 col-md-6">
            {{ Form::text('instagram',NULL,array('class'=>'form-control input-lg','placeholder'=> Lang::get('site.general.instagram'))) }}
        </div>
        <!--            {{ $errors->first('instagram', '<span class="error">:message</span>') }}-->
    </div>
    </br>
    {{ Form::textarea('prev_event_comment',NULL,array('class'=>'form-control','placeholder'=> Lang::get('site.general.prev_events'),'rows'=>'3')) }}

    <!--        {{ $errors->first('prev_event_comment', '<span class="error">:message</span>') }}-->
    </br>
    <button class="btn btn-lg btn-primary btn-block signup-btn" type="submit">
        Create my account
    </button>
    <br>
    {{ Form::close() }}


</div>
@stop