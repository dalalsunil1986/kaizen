<ul class="dropdown">
    @if(!Auth::user())
        {{ Form::open(['action' => 'AuthController@postLogin', 'method' => 'post'], ['class'=>'form hidden-xs']) }}
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon  glyphicon-user"></i></span>
                            {{ Form::text('email',null,['class'=>'form-control', 'placeholder'=> trans('word.email')]) }}
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon  glyphicon-lock"></i></span>
                            {{ Form::password('password',['class'=>'form-control', 'placeholder'=> trans('word.password')]) }}
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
                    {{ trans('word.remember')}}
                    <button type="submit" class="btn btn-default">{{ trans('word.login') }}</button>
                    <a href="{{ action('AuthController@getSignup') }}" type="submit" class="btn btn-default">{{ trans('word.register') }}</a>
                </div>
            </div>
        {{ Form::close() }}

        <a type="button" class="btn btn-default btn-sm dropdown-toggle visible-xs
                            @if ( App::getLocale() == 'en')
                                pull-right
                            @else
                                pull-left
                            @endif"
           data-toggle="dropdown" href="#"><i class="glyphicon  glyphicon-lock"></i> &nbsp;{{ trans('word.login') }}
            <span class="caret"></span>
        </a>

    @else
         <div class="pull-left" style="text-align: right">

                <a type="button" class="btn btn-info btn-default btn-sm" href="{{ action('UserController@getProfile', Auth::user()->id) }}">
                    <i class="glyphicon glyphicon-user" style="font-size: 11px;"></i>&nbsp;{{ trans('word.profile') }}
                </a>


                {{ (Helper::isMod()) ? '<a type="button" class="btn btn-default btn-sm" href="'. URL::to('admin') .'">
                    <i class="glyphicon glyphicon-user" style="font-size: 11px;"></i>&nbsp;'. trans('word.admin-panel') .'
                </a>' : '' }}

                <a type="button" class="btn btn-danger btn-default btn-sm" href="{{ action('AuthController@getLogout') }}">
                    <i class="glyphicon glyphicon-log-out" style="font-size: 11px;"></i>&nbsp;{{ trans('word.logout') }}
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
                        <label for="exampleInputEmail1">{{ trans('site.email') }}</label>

                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon  glyphicon-user"></i></span>
                            {{ Form::text('email',null,['class'=>'form-control', 'placeholder'=> trans('word.email')]) }}
                        </div>
                    </div>
                    <div class="col-sm-12 form-group">
                        <label for="exampleInputEmail1">{{ trans('site.password') }}</label>

                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon  glyphicon-lock"></i></span>
                            {{ Form::password('password',['class'=>'form-control', 'placeholder'=> trans('word.password')]) }}
                        </div>
                    </div>
                    <div class="col-sm-12 form-group">
                        {{ Form::checkbox('remember', '1', true,  ['id' => 'remember']) }}
                    </div>
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary">{{ trans('word.login') }}</button>
                        <a href="{{ action('AuthController@getSignup') }}" type="submit" class="btn btn-primary">{{ trans('word.register') }}</a>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</ul>
