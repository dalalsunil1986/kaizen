@extends('site.layouts.home')
@section('login')
    <div class="col-md-12">
        <div class="row">
            @if(!Auth::user())
                <form class="form-inline {{ ( LaravelLocalization::getCurrentLocaleName() == 'English') ? 'pull-right' : 'pull-left' }}
                    " role="form" style="padding:18px;" method="POST" action="{{ URL::route('login') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <div class="form-group">
                        <input type="text" class="form-control" size="13"  name="email" id="email" value="{{ Input::old('email') }}" placeholder="{{ Lang::get('site.nav.email')}}">
                    </div>&nbsp;&nbsp;&nbsp;&nbsp;
                    <div class="form-group">
                        <input type="password" name="password" id="password" class="form-control" size="13" placeholder="{{ Lang::get('site.nav.password')}}">
                    </div>&nbsp;&nbsp;
                    <div class="checkbox" style="margin: 3px;">
                        <label>
                            <input type="hidden" name="remember" value="0">
                            <input type="checkbox" id="remember" value="1">&nbsp;{{ Lang::get('site.general.remember')}}
                        </label>
                    </div>
                    <button type="submit" class="btn btn-default">{{ Lang::get('site.nav.login') }}</button>
                    <a href="{{ action('UserController@create') }}" type="submit" class="btn btn-default">{{ Lang::get('site.nav.register') }}</a>
                <!--<button type="submit" class="btn btn-default">{{ Lang::get('button.register') }}</button> -->
                </form>
            @else
                <div class="col-md-7
                @if ( LaravelLocalization::getCurrentLocaleName() == 'English')
                    pull-right
                @else
                    pull-left
                @endif
                " >
                    <p class="
                    {{ ( LaravelLocalization::getCurrentLocaleName() == 'English') ? 'pull-right' : 'pull-left' }}

                    " style="padding-top:10px">{{ Lang::get('site.general.youlog') }} : {{ Auth::user()->username }}
                        <a type="button" class="btn btn-default btn-sm" href="{{ action('UserController@getLogout') }}">
                           <i class="glyphicon glyphicon-log-out" style="font-size: 11px;"></i>{{ Lang::get('site.nav.logout') }}
                        </a>

                        <a type="button" class="btn btn-default btn-sm" href="{{ action('UserController@getProfile', Auth::user()->id) }}">
                            <i class="glyphicon glyphicon-user" style="font-size: 11px;"></i>{{ Lang::get('site.general.profile') }}
                        </a>
                        {{ (Helper::isMod()) ? '<a type="button" class="btn btn-default btn-sm" href="'. URL::to('admin') .'">
                            <i class="glyphicon glyphicon-user" style="font-size: 11px;"></i>'. Lang::get('site.general.admin_panel') .'
                        </a>' : '' }}
                    </p>

                </div>
            @endif

            @if ($errors->any())
                <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
            @endif
        </div>
    </div>
    <div class="col-md-12">
        @if ( LaravelLocalization::getCurrentLocaleName() == 'English')
            <ul class="nav navbar-nav navbar-right">
        @else
            <ul class="nav navbar-nav navbar-left">
        @endif
        <li>
            <form class="navbar-form navbar-left" role="search" method="GET" action="{{ URL::action('EventsController@index') }}">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="{{ Lang::get('site.nav.search') }}" value="@if(isset($_GET['search'])) {{ $_GET['search'] }} @endif " name="search" >
                </div>
                <input type="submit" class="btn btn-default" value="{{ Lang::get('site.nav.search') }}">
            </form>
        </li>
        </ul>
    </div>
@stop