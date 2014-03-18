@extends('site.layouts.home')
@section('maincontent')
<div class="row">
    {{ Form::open(array('action'=>'UserController@postIndex','method'=>'post','class'=>'form')) }}
        <legend>Sign Up</legend>
        <div class="row">
            <div class="col-xs-6 col-md-6">
                <input type="text" name="first_name" value="" class="form-control input-lg" placeholder="First Name"/>
            </div>
            <div class="col-xs-6 col-md-6">
                <input type="text" name="last_name" value="" class="form-control input-lg" placeholder="Last Name"/>
            </div>
        </div>
        </br>
        <input type="text" name="username" value="" class="form-control input-lg" placeholder="Username"
               />
        {{{ $errors->first('username', '<span class="help-inline">:message</span>') }}}
        </br>
        <input type="email" name="email" value="" class="form-control input-lg" placeholder="Your Email"
               />
        </br>
        <input type="password" name="password" value="" class="form-control input-lg" placeholder="Password"
               />
        </br>
        <input type="password" name="password_confirmation" value="" class="form-control input-lg"
               placeholder="Confirm Password" />
        </br>
        <input type="text" name="mobile" value="" class="form-control input-lg" placeholder="Mobile Telephone"/>
        </br>
        <input type="text" name="phone" value="" class="form-control input-lg" placeholder="Telphone"/>
        </br>
        {{ Form::select('country', $countries, null ,['class' => 'form-control input-lg']) }}
        </br>
        <label>Birth Date</label>
        <div class="row">
            <div class="col-xs-4 col-md-4">
                <select name="month" class="form-control input-lg">
                    <option value="01">Jan</option>
                    <option value="02">Feb</option>
                    <option value="03">Mar</option>
                    <option value="04">Apr</option>
                    <option value="05">May</option>
                    <option value="06">Jun</option>
                    <option value="07">Jul</option>
                    <option value="08">Aug</option>
                    <option value="09">Sep</option>
                    <option value="10">Oct</option>
                    <option value="11">Nov</option>
                    <option value="12">Dec</option>
                </select></div>
            <div class="col-xs-4 col-md-4">
                <select name="day" class="form-control input-lg">
                    @for($i=1;$i<=31;$i++)
                    <option value="{{ $i }}"> {{ $i }}</option>
                    @endfor
                </select></div>
            <div class="col-xs-4 col-md-4">
                <select name="year" class="form-control input-lg">
                    @for($i=1930;$i<=2014;$i++)
                    <option value="{{ $i }}"> {{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>
        <br/>
        <label>Gender : </label> <label class="radio-inline">
            <input type="radio" name="gender" value="M" id=male/> Male
        </label>
        <label class="radio-inline">
            <input type="radio" name="gender" value="F" id=female/> Female
        </label>
        <br/>
        <div class="row">
            <div class="col-xs-6 col-md-6">
                <input type="text" name="twitter" value="" class="form-control input-lg" placeholder="Twitter Account"/>
            </div>
            <div class="col-xs-6 col-md-6">
                <input type="text" name="instagram" value="" class="form-control input-lg" placeholder="Istagram Account"/>
            </div>
        </div>
        </br>
        <textarea name="prev_event_comment" class="form-control" rows="3" placeholder="Previous Events in Kaizen"></textarea>
        </br>
        <button class="btn btn-lg btn-primary btn-block signup-btn" type="submit">
            Create my account
        </button>
        <br>
    {{ Form::close() }}
    @if ($errors->any())
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
    @endif
</div>
@stop