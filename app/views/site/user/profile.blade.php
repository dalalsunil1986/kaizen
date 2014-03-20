@extends('site.layouts.home')
@section('maincontent')
<div class="row well">
    <div class="col-lg-3">
        <img class="img-circle" src="http://critterapp.pagodabox.com/img/user.jpg" alt="">
    </div>
    <div class="col-lg-8">
            <h1>{{ Lang::get('site.general.profile') }}</h1>
            <table class="table table-striped">
                <tr>
                    <td>{{ Lang::get('site.general.name') }} : </td>
                    <td>
                    @if(count($user->first_name) > 1)
                   {{ $user->first_name . $user->last_name}}
                    @else
                    {{ Lang::get('site.general.notavail')}}
                   @endif
                    </td>
              </tr>
                <tr>
                    <td>{{ Lang::get('site.general.email') }} : </td>
                    <td>
                        @if(count($user->email) > 1)
                        {{ $user->email}}
                        @else
                        {{ Lang::get('site.general.notavail')}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>{{ Lang::get('site.general.mobile') }} : </td>
                    <td>
                        @if(count($user->mobile) > 1)
                        {{ $user->mobile }}
                        @else
                        {{ Lang::get('site.general.notavail')}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>{{ Lang::get('site.general.phone') }} : </td>
                    <td>
                        @if(count($user->phone) > 1)
                        {{ $user->phone}}
                        @else
                        {{ Lang::get('site.general.notavail')}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>{{ Lang::get('site.general.country') }} : </td>
                    <td>
                        @if(count($user->country) > 1)
                        {{ $user->country}}
                        @else
                        {{ Lang::get('site.general.notavail')}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>{{ Lang::get('site.general.gender') }} : </td>
                    <td>
                        @if(count($user->gender) > 1)
                        {{ $user->gender}}
                        @else
                        {{ Lang::get('site.general.notavail')}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>{{ Lang::get('site.general.dob') }} : </td>
                    <td>
                        @if(count($user->dob) > 1)
                        {{ $user->job}}
                        @else
                        {{ Lang::get('site.general.notavail')}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>{{ Lang::get('site.general.instagram') }} : </td>
                    <td>
                        @if(count($user->instagram) > 1)
                        {{ $user->instagram}}
                        @else
                        {{ Lang::get('site.general.notavail')}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>{{ Lang::get('site.general.twitter') }} : </td>
                    <td>
                        @if(count($user->twitter) > 1)
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
