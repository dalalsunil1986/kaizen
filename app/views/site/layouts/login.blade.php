@extends('site.layouts.home')
@section('login')
<form class="form-inline" role="form" style="padding:20px;">
    <div class="form-group">
        <label class="sr-only" for="exampleInputEmail2">تسجيل | دخول</label>
        <input type="email" class="form-control" size="10" id="exampleInputEmail2" placeholder="Enter email">
    </div>&nbsp;&nbsp;&nbsp;&nbsp;
    <div class="form-group">
        <label class="sr-only" for="exampleInputPassword2">Password</label>
        <input type="password" class="form-control" size="10" id="exampleInputPassword2" placeholder="Password">
    </div>&nbsp;&nbsp;
    <button type="submit" class="btn btn-default">{{ Lang::get('button.sign') }}</button>
<!--<button type="submit" class="btn btn-default">{{ Lang::get('button.register') }}</button> -->
</form>
@stop