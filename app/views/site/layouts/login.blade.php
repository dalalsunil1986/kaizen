@extends('site.layouts.home')
@section('login')

<div class="nav nav-pills" >

    <ul class="dropdown">
        @if(!Auth::user())

        <a type="button" class="btn btn-default btn-sm dropdown-toggle
                    @if ( LaravelLocalization::getCurrentLocaleName() == 'English')
                        pull-right
                    @else
                        pull-left
                    @endif"
           data-toggle="dropdown" href="#"><i class="glyphicon  glyphicon-lock"></i> &nbsp;{{ Lang::get('site.nav.login') }} <span class="caret"></span>
        </a>
        @else
        <a type="button" class="btn btn-default btn-sm dropdown-toggle
                    @if ( LaravelLocalization::getCurrentLocaleName() == 'English')
                        pull-right
                    @else
                        pull-left
                    @endif"
           data-toggle="dropdown" href="#">
            <i class="glyphicon  glyphicon-cog"></i> &nbsp;{{ Lang::get('site.general.settings') }} <span class="caret"></span>
        </a>
        @endif
        <br>
        <div class="dropdown-menu
                @if ( LaravelLocalization::getCurrentLocaleName() == 'English')
                    pull-right
                @else
                    pull-left
                @endif">
            <div class="row">
                <div class="col-md-12
                        @if ( LaravelLocalization::getCurrentLocaleName() == 'English')
                        pull-right
                        @else
                        pull-left
                        @endif">
                    @if(!Auth::user())
                    <form class="form" role="form" method="POST" action="{{ URL::route('login') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                        <div class="col-sm-12 form-group">
                            <label for="exampleInputEmail1">{{ Lang::get('site.nav.email') }}</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon  glyphicon-user"></i></span>
                                <input type="text" class="form-control" name="email" id="email" value="{{ Input::old('email') }}" placeholder="{{ Lang::get('site.nav.email')}}">

                            </div>
                        </div>
                        <div class="col-sm-12 form-group">
                            <label for="exampleInputEmail1">{{ Lang::get('site.nav.password') }}</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon  glyphicon-lock"></i></span>
                                <input type="password" name="password" id="password" class="form-control" placeholder="{{ Lang::get('site.nav.password')}}">
                            </div>
                        </div>
                        <div class="col-sm-12 form-group">
                            <input type="hidden" name="remember" value="0">
                            <input type="checkbox" id="remember" value="1">&nbsp;{{ Lang::get('site.general.remember')}}
                        </div>
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary">{{ Lang::get('site.nav.login') }}</button>
                            <a href="{{ action('UserController@create') }}" type="submit" class="btn btn-primary">{{ Lang::get('site.nav.register') }}</a>
                            <!--<button type="submit" class="btn btn-default">{{ Lang::get('button.register') }}</button> -->
                        </div>
                    </form>
                    @else
                    <div style="text-align: right">
                        <li class="dropdown-header">
                            <a type="button" class="btn btn-default btn-sm" href="{{ action('UserController@getLogout') }}">
                                <i class="glyphicon glyphicon-log-out" style="font-size: 11px;"></i>&nbsp;{{ Lang::get('site.nav.logout') }}
                            </a>
                        </li>
                        <li class="dropdown-header">
                            <a type="button" class="btn btn-default btn-sm" href="{{ action('UserController@getProfile', Auth::user()->id) }}">
                                <i class="glyphicon glyphicon-user" style="font-size: 11px;"></i>&nbsp;{{ Lang::get('site.general.profile') }}
                            </a>
                        </li>
                        <li class="dropdown-header">
                            {{ (Helper::isMod()) ? '<a type="button" class="btn btn-default btn-sm" href="'. URL::to('admin') .'">
                                <i class="glyphicon glyphicon-user" style="font-size: 11px;"></i>&nbsp;'. Lang::get('site.general.admin_panel') .'
                            </a>' : '' }}
                        </li>
                    </div>


                    @endif
                </div>
            </div>
        </div>
    </ul>
</div>

@stop