@extends('site.layouts._one_column')
@section('content')

@if($user->isOwner())

    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active"><a href="#profile" data-toggle="tab">Profile</a></li>
                <li><a href="#favorites" data-toggle="tab">Favorites</a></li>
                <li><a href="#subscriptions" data-toggle="tab">Subscriptions</a></li>
                <li><a href="#followings" data-toggle="tab">Followings</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="profile">
                    <h1>{{ Lang::get('site.general.profile') }}</h1>
                    <div class="col-lg-3">
                        <img class="img-circle" src="http://critterapp.pagodabox.com/img/user.jpg" alt="">
                        <p><a href="{{ action('UserController@edit',$user->id)}}">Edit Profile</a></p>
                    </div>
                    <div class="col-lg-8">
                        <table class="table table-striped">
                            <tr>
                                <td>{{ Lang::get('site.general.name') }} : </td>
                                <td>
                                    @if($user->first_name || $user->last_name)
                                    {{ ($user->first_name) ? $user->first_name : $user->last_name }}
                                    {{ ($user->last_name) ? $user->last_name :'' }}
                                    @else
                                    {{ Lang::get('site.general.notavail')}}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>{{ Lang::get('site.general.email') }} : </td>
                                <td>
                                    @if($user->email)
                                    {{ $user->email }}
                                    @else
                                    {{ Lang::get('site.general.notavail')}}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>{{ Lang::get('site.general.mobile') }} : </td>
                                <td>
                                    @if($user->mobile)
                                    {{ $user->mobile }}
                                    @else
                                    {{ Lang::get('site.general.notavail')}}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>{{ Lang::get('site.general.phone') }} : </td>
                                <td>
                                    @if($user->phone)
                                    {{ $user->phone}}
                                    @else
                                    {{ Lang::get('site.general.notavail')}}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>{{ Lang::get('site.general.country') }} : </td>
                                <td>
                                    @if($user->country_id)
                                    {{ $user->country->name}}
                                    @else
                                    {{ Lang::get('site.general.notavail')}}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>{{ Lang::get('site.general.gender') }} : </td>
                                <td>
                                    @if($user->gender)
                                    {{ $user->gender}}
                                    @else
                                    {{ Lang::get('site.general.notavail')}}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>{{ Lang::get('site.general.dob') }} : </td>
                                <td>
                                    @if($user->dob)
                                    {{ $user->dob->format("j-n-Y") }}
                                    @else
                                    {{ Lang::get('site.general.notavail')}}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>{{ Lang::get('site.general.instagram') }} : </td>
                                <td>
                                    @if($user->instagram)
                                    {{ $user->instagram}}
                                    @else
                                    {{ Lang::get('site.general.notavail')}}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>{{ Lang::get('site.general.twitter') }} : </td>
                                <td>
                                    @if($user->twitter)
                                    {{ $user->twitter}}
                                    @else
                                    {{ Lang::get('site.general.notavail')}}
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
                                {{ link_to_action('EventsController@show',$event->title,$event->id,array('class'=>'list-group-item')) }}
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="tab-pane" id="subscriptions">
                    <div class="panel panel-primary">
                        <ul class="list-group">
                            @foreach($user->subscriptions as $event)
                                {{ link_to_action('EventsController@show',$event->title,$event->id,array('class'=>'list-group-item')) }}
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="tab-pane" id="followings">
                    <div class="panel panel-primary">
                        <ul class="list-group">
                            @foreach($user->followings as $event)
                                {{ link_to_action('EventsController@show',$event->title,$event->id,array('class'=>'list-group-item')) }}
                            @endforeach
                        </ul>
                    </div>
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
                    <td>{{ Lang::get('site.general.name') }} : </td>
                    <td>
                        @if($user->first_name || $user->last_name)
                        {{ ($user->first_name) ? $user->first_name : $user->last_name }}
                        {{ ($user->last_name) ? $user->last_name :'' }}
                        @else
                        {{ Lang::get('site.general.notavail')}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>{{ Lang::get('site.general.email') }} : </td>
                    <td>
                        @if($user->email)
                        {{ $user->email }}
                        @else
                        {{ Lang::get('site.general.notavail')}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>{{ Lang::get('site.general.mobile') }} : </td>
                    <td>
                        @if($user->mobile)
                        {{ $user->mobile }}
                        @else
                        {{ Lang::get('site.general.notavail')}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>{{ Lang::get('site.general.phone') }} : </td>
                    <td>
                        @if($user->phone)
                        {{ $user->phone}}
                        @else
                        {{ Lang::get('site.general.notavail')}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>{{ Lang::get('site.general.country') }} : </td>
                    <td>
                        @if($user->country_id)
                        {{ $user->country->name}}
                        @else
                        {{ Lang::get('site.general.notavail')}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>{{ Lang::get('site.general.gender') }} : </td>
                    <td>
                        @if($user->gender)
                        {{ $user->gender}}
                        @else
                        {{ Lang::get('site.general.notavail')}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>{{ Lang::get('site.general.dob') }} : </td>
                    <td>
                        @if($user->dob)
                        {{ $user->dob->format("j-n-Y") }}
                        @else
                        {{ Lang::get('site.general.notavail')}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>{{ Lang::get('site.general.instagram') }} : </td>
                    <td>
                        @if($user->instagram)
                        {{ $user->instagram}}
                        @else
                        {{ Lang::get('site.general.notavail')}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>{{ Lang::get('site.general.twitter') }} : </td>
                    <td>
                        @if($user->twitter)
                        {{ $user->twitter}}
                        @else
                        {{ Lang::get('site.general.notavail')}}
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
