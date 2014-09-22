<ul class="dropdown">
    @if(!Auth::user())
        {{ Form::open(['action' => 'AuthController@postLogin', 'method' => 'post'], ['class'=>'form hidden-xs']) }}
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon  glyphicon-user"></i></span>
                            <input type="text" class="form-control" name="email" id="email" value="{{ Input::old('email') }}" placeholder="{{ Lang::get('site.nav.email')}}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon  glyphicon-lock"></i></span>
                            <input type="password" name="password" id="password" class="form-control" placeholder="{{ Lang::get('site.nav.password')}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 form-group
                            @if ( App::getLocale() == 'en')
                                pull-right
                            @else
                                pull-left
                            @endif
                            ">
                    {{ Form::checkbox('remember', '1', true,  ['id' => 'remember']) }}
                    {{ Lang::get('site.general.remember')}}

                    <button type="submit" class="btn btn-default">{{ Lang::get('site.nav.login') }}</button>
                    <a href="{{ action('AuthController@getSignup') }}" type="submit" class="btn btn-default">{{ Lang::get('site.nav.register') }}</a>
                   <!--<button type="submit" class="btn btn-default">{{ Lang::get('button.register') }}</button> -->
                </div>
            </div>
        {{ Form::close() }}

        <a type="button" class="btn btn-default btn-sm dropdown-toggle visible-xs
                            @if ( App::getLocale() == 'en')
                                pull-right
                            @else
                                pull-left
                            @endif"
           data-toggle="dropdown" href="#"><i class="glyphicon  glyphicon-lock"></i> &nbsp;{{ Lang::get('site.nav.login') }}
            <span class="caret"></span>
        </a>

    @else
         <div class="pull-left" style="text-align: right">

                <a type="button" class="btn btn-info btn-default btn-sm" href="{{ action('UserController@getProfile', Auth::user()->id) }}">
                    <i class="glyphicon glyphicon-user" style="font-size: 11px;"></i>&nbsp;{{ Lang::get('site.general.profile') }}
                </a>


                {{ (Helper::isMod()) ? '<a type="button" class="btn btn-default btn-sm" href="'. URL::to('admin') .'">
                    <i class="glyphicon glyphicon-user" style="font-size: 11px;"></i>&nbsp;'. Lang::get('site.general.admin_panel') .'
                </a>' : '' }}

                <a type="button" class="btn btn-danger btn-default btn-sm" href="{{ action('AuthController@getLogout') }}">
                    <i class="glyphicon glyphicon-log-out" style="font-size: 11px;"></i>&nbsp;{{ Lang::get('site.nav.logout') }}
                </a>

        </div>
    @endif

    <br>

    <div class="dropdown-menu
                @if ( App::getLocale() == 'en')
                    pull-right
                @else
                    pull-left
                @endif">
        <div class="row">
            <div class="col-md-12
                        @if ( App::getLocale() == 'en')
                            pull-right
                        @else
                            pull-left
                        @endif">
                @if(!Auth::user())
                {{ Form::open(['action' => 'AuthController@postLogin', 'method' => 'post'], ['class'=>'form hidden-lg hidden-md hidden-sm']) }}

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
                        <a href="{{ action('AuthController@getSignup') }}" type="submit" class="btn btn-primary">{{ Lang::get('site.nav.register') }}</a>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</ul>
