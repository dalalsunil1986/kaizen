@extends('site.layouts.home')
@section('maincontent')
<div class="row well">
    <div class="col-lg-3">
        <img class="img-circle" src="http://critterapp.pagodabox.com/img/user.jpg" alt="">

        @if(Helper::isOwner($user->id))
            <br>
            <a href="{{ action('UserController@edit',$user->id)}}">Edit Profile</a>
        @endif

    </div>
    <div class="col-lg-8">
            <h1>{{ Lang::get('site.general.profile') }}</h1>
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
                        @if($user->country))
                        {{ $user->country}}
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
                        {{ $user->job}}
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
@stop
