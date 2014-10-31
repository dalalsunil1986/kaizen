@extends('site.layouts._one_column')

@section('style')
@parent
<style>
.panel-primary {
    border-color: rgba(232, 241, 242, 1);
    border-top:none;
}
.panel > .list-group {
    margin: 10px;
    border:#cccccc 1px ;
}


</style>
@stop
@section('content')

@if($user->isOwner())

    <div class="col-md-12">
        <ul class="nav nav-tabs" id="myTab">
            <li class="active"><a href="#profile" data-toggle="tab">{{ trans('site.profile') }}</a></li>
            <li><a href="#favorites" data-toggle="tab">{{ trans('site.favorites') }}</a></li>
            <li><a href="#subscriptions" data-toggle="tab">{{ trans('site.subscriptions') }}</a></li>
            <li><a href="#followings" data-toggle="tab">{{ trans('site.followings') }}</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="profile">
                <h1>{{ Lang::get('site.profile') }}</h1>
                <div class="col-lg-3">
                    <img class="img-circle" src="http://critterapp.pagodabox.com/img/user.jpg" alt="">
                    <p><a href="{{ action('UserController@edit',$user->id)}}">{{ trans('button.edit') }}</a></p>
                </div>
                <div class="col-lg-8">
                    <table class="table table-striped">
                        <tr>
                            <td>{{ Lang::get('site.name_en') }} : </td>
                            <td>
                                @if($user->name_en || $user->name_ar)
                                {{ ($user->name_ar) ? $user->name_ar : $user->name_en }}
                                {{ ($user->last_name) ? $user->last_name :'' }}
                                @else
                                {{ Lang::get('site.notavail')}}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>{{ Lang::get('site.email') }} : </td>
                            <td>
                                @if($user->email)
                                {{ $user->email }}
                                @else
                                {{ Lang::get('site.notavail')}}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>{{ Lang::get('site.mobile') }} : </td>
                            <td>
                                @if($user->mobile)
                                {{ $user->mobile }}
                                @else
                                {{ Lang::get('site.notavail')}}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>{{ Lang::get('site.phone') }} : </td>
                            <td>
                                @if($user->phone)
                                {{ $user->phone}}
                                @else
                                {{ Lang::get('site.notavail')}}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>{{ Lang::get('site.country') }} : </td>
                            <td>
                                @if($user->country_id)
                                {{ $user->country->name}}
                                @else
                                {{ Lang::get('site.notavail')}}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>{{ Lang::get('site.gender') }} : </td>
                            <td>
                                @if($user->gender)
                                {{ $user->gender}}
                                @else
                                {{ Lang::get('site.notavail')}}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>{{ Lang::get('site.instagram') }} : </td>
                            <td>
                                @if($user->instagram)
                                {{ $user->instagram}}
                                @else
                                {{ Lang::get('site.notavail')}}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>{{ Lang::get('site.twitter') }} : </td>
                            <td>
                                @if($user->twitter)
                                {{ $user->twitter}}
                                @else
                                {{ Lang::get('site.notavail')}}
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>

            </div>
            <div class="tab-pane" id="favorites">
                <div class="panel panel-primary">
                    <ul class="list-group">
                        @foreach($user->favorites as $event)
                            <div class="row top10">
                                <div class="col-sm-2 col-md-2 ">
                                    <div id="links">
                                        @if(count($event->photos))
                                        <a href="{{ action('EventsController@show',$event->id) }}">
                                            {{ HTML::image('uploads/thumbnail/'.$event->photos[0]->name.'','image1',array('class'=>'img-responsive img-thumbnail')) }}
                                        </a>
                                        @else
                                        <a href="{{ action('EventsController@show',$event->id) }}">
                                            <img src="http://placehold.it/70x70" class="img-thumbnail">
                                        </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-10 col-md-10">
                                    <span class="event-title">
                                        <a href="{{action('EventsController@show',$event->id )}}">
                                            {{ $event->title }}
                                        </a>
                                    </span>
                                    <p>
                                        {{ Str::limit($event->description, 150) }}
                                        <a href="{{action('EventsController@show',$event->id )}}">{{ Lang::get('site.more')}}</a>

                                    </p>

                                </div>
                            </div>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="tab-pane" id="subscriptions">
                <div class="panel panel-primary">
                    <ul class="list-group">
                        @foreach($user->subscriptions as $event)
                            <div class="row top10">
                                <div class="col-sm-2 col-md-2 ">
                                    <div id="links">
                                        @if(count($event->photos))
                                        <a href="{{ action('EventsController@show',$event->id) }}">
                                            {{ HTML::image('uploads/thumbnail/'.$event->photos[0]->name.'','image1',array('class'=>'img-responsive img-thumbnail')) }}
                                        </a>
                                        @else
                                        <a href="{{ action('EventsController@show',$event->id) }}">
                                            <img src="http://placehold.it/70x70" class="img-thumbnail">
                                        </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-10 col-md-10">
                                    <span class="event-title">
                                        <a href="{{action('EventsController@show',$event->id )}}">
                                            {{ $event->title }}
                                        </a>
                                    </span>
                                    <p>
                                        {{ Str::limit($event->description, 150) }}
                                        <a href="{{action('EventsController@show',$event->id )}}">{{ Lang::get('site.more')}}</a>

                                    </p>

                                </div>
                            </div>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="tab-pane" id="followings">
                <div class="panel panel-primary">
                    <ul class="list-group">
                        @foreach($user->followings as $event)
                            <div class="row top10">
                                <div class="col-sm-2 col-md-2 ">
                                    <div id="links">
                                        @if(count($event->photos))
                                        <a href="{{ action('EventsController@show',$event->id) }}">
                                            {{ HTML::image('uploads/thumbnail/'.$event->photos[0]->name.'','image1',array('class'=>'img-responsive img-thumbnail')) }}
                                        </a>
                                        @else
                                        <a href="{{ action('EventsController@show',$event->id) }}">
                                            <img src="http://placehold.it/70x70" class="img-thumbnail">
                                        </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-10 col-md-10">
                                    <span class="event-title">
                                        <a href="{{action('EventsController@show',$event->id )}}">
                                            {{ $event->title }}
                                        </a>
                                    </span>
                                    <p>
                                        {{ Str::limit($event->description, 150) }}
                                        <a href="{{action('EventsController@show',$event->id )}}">{{ Lang::get('site.more')}}</a>

                                    </p>

                                </div>
                            </div>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="row well">
        <div class="col-lg-3">
            <img class="img-circle" src="http://critterapp.pagodabox.com/img/user.jpg" alt="">
        </div>
        <div class="col-lg-8">
            <table class="table table-striped">
                <tr>
                    <td>{{ Lang::get('site.name') }} : </td>
                    <td>
                        @if($user->first_name || $user->last_name)
                        {{ ($user->first_name) ? $user->first_name : $user->last_name }}
                        {{ ($user->last_name) ? $user->last_name :'' }}
                        @else
                        {{ Lang::get('site.notavail')}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>{{ Lang::get('site.email') }} : </td>
                    <td>
                        @if($user->email)
                        {{ $user->email }}
                        @else
                        {{ Lang::get('site.notavail')}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>{{ Lang::get('site.mobile') }} : </td>
                    <td>
                        @if($user->mobile)
                        {{ $user->mobile }}
                        @else
                        {{ Lang::get('site.notavail')}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>{{ Lang::get('site.phone') }} : </td>
                    <td>
                        @if($user->phone)
                        {{ $user->phone}}
                        @else
                        {{ Lang::get('site.notavail')}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>{{ Lang::get('site.country') }} : </td>
                    <td>
                        @if($user->country_id)
                        {{ $user->country->name}}
                        @else
                        {{ Lang::get('site.notavail')}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>{{ Lang::get('site.gender') }} : </td>
                    <td>
                        @if($user->gender)
                        {{ $user->gender}}
                        @else
                        {{ Lang::get('site.notavail')}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>{{ Lang::get('site.dob') }} : </td>
                    <td>
                        @if($user->dob)
                        {{ $user->dob->format("j-n-Y") }}
                        @else
                        {{ Lang::get('site.notavail')}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>{{ Lang::get('site.instagram') }} : </td>
                    <td>
                        @if($user->instagram)
                        {{ $user->instagram}}
                        @else
                        {{ Lang::get('site.notavail')}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>{{ Lang::get('site.twitter') }} : </td>
                    <td>
                        @if($user->twitter)
                        {{ $user->twitter}}
                        @else
                        {{ Lang::get('site.notavail')}}
                        @endif
                    </td>
                </tr>
            </table>

        </div>
    </div>
@endif
<script>
    $(function () {
        $('#myTab a:last').tab('show')
    })
</script>
@stop
