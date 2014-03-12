@extends('site.layouts.home')
@section('maincontent')
<div class="row" xmlns="http://www.w3.org/1999/html">
    <address>
    <h2 style="background-color: rgba(221, 220, 219, 0.83); padding:10px;">Contact Us</h2>
    Phone : 394893247 </br>
    Address : Address Address Address Address,</br>
    Mobile : 34324234 </br>
    email address : kjdkfj@kjdfjkd.com
    </address>

    <div class="row col-md-8">
        <form role="form">
            <div class="form-group">
                <label for="exampleInputEmail">{{ Lang::get('site.general.email') }}</label>
                <input type="email" class="form-control" id="exampleInputEmail" placeholder="{{ Lang::get('site.general.email') }}">
            </div>
            <div class="form-group">
                <label for="name">{{ Lang::get('site.general.name') }}</label>
                <input type="text" class="form-control" id="name" placeholder="{{ Lang::get('site.general.name') }}">
            </div>
            <div class="form-group">
                <label for="comment">{{ Lang::get('site.general.name') }}</label>
                <textarea class="form-control" id="comment" placeholder="{{ Lang::get('site.general.comment') }}"></textarea>
            </div>
            <button type="submit" class="btn btn-default">{{ Lang::get('site.general.submit') }}</button>
        </form>


    </div>
</div>
@stop