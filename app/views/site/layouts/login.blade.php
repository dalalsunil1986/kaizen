@extends('site.layouts.home')
@section('login')
    @if(!Auth::user())
        <form class="form-inline" role="form" style="padding:20px;" method="post" action="{{ URL::route('login') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            <div class="form-group">
                <label class="sr-only" for="email">تسجيل | دخول</label>
                <input type="text" class="form-control" size="10" id="email" placeholder="">
            </div>&nbsp;&nbsp;&nbsp;&nbsp;
            <div class="form-group">
                <label class="sr-only" for="password">Password</label>
                <input type="password" class="form-control" size="10" id="password" placeholder="Password">
            </div>&nbsp;&nbsp;
            <div class="checkbox" style="margin: 3px;">
                <label>
                    <input type="checkbox" id="remember">&nbsp;{{ Lang::get('site.general.remember')}}
                </label>
            </div>
            <button type="submit" class="btn btn-default">{{ Lang::get('site.nav.login') }}</button>
        <!--<button type="submit" class="btn btn-default">{{ Lang::get('button.register') }}</button> -->
        </form>
    @else
    <div class="col-md-8" style="border: 1px solid red;">
        <p class="text-left">you are logged in as : {{ Auth::user()->username }} </br>

            <a type="button" class="btn btn-default btn-sm" href="{{ URL::action('UserController@getLogout') }}">
               <i class="glyphicon glyphicon-log-out" style="font-size: 11px;"></i>{{ Lang::get('site.nav.logout') }}
            </a>
        </p>

    </div>
    @endif
@stop