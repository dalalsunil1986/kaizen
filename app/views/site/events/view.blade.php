@extends('site.layouts.home')
@section('maincontent')

<link rel="stylesheet" href="http://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAvY9Begj4WZQpP8b6IGFBACdnUhulMCok&sensor=false"></script>

{{ HTML::style('css/bootstrap-image-gallery.min.css') }}
<div class="row">
    <div class="col-md-12">

        <!-- gallery Template Divisions that should be load each time we will use the gallery -->
        <div id="blueimp-gallery" class="blueimp-gallery">
            <!-- The container for the modal slides -->
            <div class="slides"></div>
            <!-- Controls for the borderless lightbox -->
            <h3 class="title"></h3>
            <a class="prev">‹</a>
            <a class="next">›</a>
            <a class="close">×</a>
            <a class="play-pause"></a>
            <ol class="indicator"></ol>
            <!-- The modal dialog, which will be used to wrap the lightbox content -->
            <div class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" aria-hidden="true">&times;</button>
                            <h4 class="modal-title"></h4>
                        </div>
                        <div class="modal-body next"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left prev">
                                <i class="glyphicon glyphicon-chevron-left"></i>
                                Previous
                            </button>
                            <button type="button" class="btn btn-primary next">
                                Next
                                <i class="glyphicon glyphicon-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- sidecontent division -->
<div class="row">
    <div class="col-md-7">
        <h1>
            @if ( LaravelLocalization::getCurrentLocaleName() == 'English')
            @if($event->title_en)
            {{ $event->title_en }}
            @else
            {{ $event->title }}
            @endif
            @else
            {{ $event->title }}
            @endif
        </h1>
    </div>

    <div class="col-md-5 {{ !Auth::user()? 'btns_disabled' :'' }}">

        <div class="row top20">
            <button
            {{ !Auth::user()? 'disabled' :'' }} type="button" class="col-md-12 events_btns btn btn-default btn-sm subscribe_btn bg-blue top5 "
            data-toggle="tooltip" data-placement="top" title="{{ $subscribed? Lang::get('site.event.unsubscribe') : Lang::get('site.event.subscribe')  }}">
            <i class="subscribe glyphicon glyphicon-check {{ $subscribed? 'active' :'' ;}}"></i>  </br>
            <span class="buttonText">{{ Lang::get('site.general.subscribe_btn_desc')}}</span></button>

            <button
            {{ !Auth::user()? 'disabled' :'' }} type="button" class="col-md-6 events_btns btn btn-default btn-sm follow_btn bg-blue top5"
            data-toggle="tooltip" data-placement="top" title="{{ $followed? Lang::get('site.event.unfollow') : Lang::get('site.event.follow')  }}">
            <i class="follow glyphicon glyphicon-heart {{ $followed? 'active' :'' ;}}"></i> </br>
            {{ Lang::get('site.general.follow_btn_desc')}}</button>

            <button {{ !Auth::user()? 'disabled' :'' }} type="button" class="col-md-6 events_btns btn btn-default btn-sm  favorite_btn bg-blue top5"
            data-toggle="tooltip" data-placement="top" title="{{ $favorited? Lang::get('site.event.unfavorite') : Lang::get('site.event.favorite')  }}">
            <i class="favorite glyphicon glyphicon-star {{ $favorited? 'active' :'' ;}}"></i></br>
            {{ Lang::get('site.general.fv_btn_desc')}}</button>
        </div>
    </div>

</div>
@if(count($event->photos))
<div class="row" id="event_images">
    <div id="links">
        @foreach($event->photos as $photo)
        <a href="{{ URL::route('base').'/uploads/'.$photo->name }}" data-gallery>
            {{ HTML::image('uploads/thumbnail/'.$photo->name.'',$photo->name,array('class'=>'img-responsive img-thumbnail')) }}
        </a>
        @endforeach
    </div>
</div>
<br><br><br>
@endif
<div class="row">
    <div class="col-md-12">
        <table class="table table-striped">
            <tr>
                <h4>{{ Lang::get('site.event.summaryevent') }}</h4>
            </tr>
            <tr>
                <td><b>{{ Lang::get('site.event.totalseats') }}</b></td>
                <td> {{ $event->total_seats}}</td>
                <td><b> {{ Lang::get('site.event.seatsavail') }} </b></td>
                <td> {{ $event->available_seats}}</td>
            </tr>
            <tr>
                <td><b>{{ Lang::get('site.event.date_start') }}</b></td>
                <td> {{ $event->formatEventDate($event->date_start) }}</td>
                <td><b> {{ Lang::get('site.event.date_end') }} </b></td>
                <td> {{ $event->formatEventDate($event->date_end) }}</td>
            </tr>
            <tr>
                <td><b>{{ Lang::get('site.event.time_start') }}</b></td>
                <td> {{ $event->date_start->format('g a') }}</td>
                <td><b> {{ Lang::get('site.event.time_end') }}</b></td>
                <td> {{ $event->date_end->format('g a') }}</td>
            </tr>
            @if($event->phone || $event->email)
            <tr>
                @if($event->phone)
                <td><b>{{ Lang::get('site.general.phone') }}</b></td>
                <td> {{ $event->phone }}</td>
                @endif
                @if($event->email)
                <td><b>{{ Lang::get('site.general.email') }}</b> </td>
                <td> {{ $event->email }}</td>
                @endif
            </tr>
            @endif
            <tr>
                <td><b>{{ Lang::get('site.event.price') }}</b></td>
                @if($event->price)
                <td>{{ $event->price }} KD</td>
                @else
                <td>{{ Lang::get('site.event.free') }}</td>
                @endif
            </tr>
        </table>
    </div>

    <div class="col-md-12">
        <p>
            @if ( LaravelLocalization::getCurrentLocaleName() == 'English')
            @if($event->description_en)
            {{ $event->description_en }}
            @else
            {{ $event->description }}
            @endif
            @else
            {{ $event->description }}
            @endif
        </p>
    </div>

    @if($event->latitude && $event->longitude)

    <div class="col-md-12">
        <button type="button" class="btn btn-danger" data-toggle="collapse" data-target="#map">
            Show / Hide Map
        </button>
        <div id="map" class="collapse in top10">
            <div id="map_canvas"></div>
        </div>
    </div>

    @endif
    <div class="col-md-12 top15">
        <option selected disabled>Address</option>
        <address>
            <strong> {{ $event->address}} </strong><br>
            @if($event->phone)
            <abbr title="Phone">Phome:</abbr>
            {{ $event->phont }}
            @endif
        </address>
    </div>

    <div class="col-md-12 {{ !Auth::user()? 'btns_disabled' :'' }}">
        <button
        {{ !Auth::user()? 'disabled' :'' }} type="button" class="col-md-12 events_btns btn btn-default btn-sm subscribe_btn bg-blue "
        data-toggle="tooltip" data-placement="top" title="{{ $subscribed? Lang::get('site.event.unsubscribe') : Lang::get('site.event.subscribe')  }}">
        <i class="subscribe glyphicon glyphicon-check {{ $subscribed? 'active' :'' ;}}"></i>  </br>
        <span class="buttonText">{{ Lang::get('site.general.subscribe_btn_desc')}}</span></button>

    </div>
</div>

<div class="row">
    <div class="col-md-12">
        @if(count($event->comments) > 0)
        <h3 class="comments_title"> {{Lang::get('site.event.comment') }}</h3>
        @foreach($event->comments as $comment)
        <div class="comments_dev">
            <p class="text-muted">
                {{ $comment->content }}
            </p>

            <p
            @if ( LaravelLocalization::getCurrentLocaleName() == 'English')
            class="text-right text-primary"
            @else
            class="text-left text-primary"
            @endif
            >{{ $comment->user->username}}</p>
        </div>
        @endforeach
        @endif
    </div>
    <div class="col-md-12">
        @if(Auth::User())
        {{ Form::open(array( 'action' => array('CommentsController@store', $event->id))) }}
        <div class="form-group">
            <label for="comment"></label>
            <textarea type="text"  class="form-control" id="content" name="content" placeholder="{{ Lang::get('site.event.comment')}}"></textarea>
        </div>
        <button type="submit" class="btn btn-default"> {{ Lang::get('site.event.addcomment') }}</button>
        {{ Form::close() }}
        @endif
        @if ($errors->any())
        <ul> {{ implode('', $errors->all('  <li class="error">:message</li> ')) }} </ul>
        @endif
    </div>
</div>

<script src="http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<script src="{{ asset('js/bootstrap-image-gallery.js') }}"></script>

<script>
    var id = '<?php echo $event->id; ?>';

    function toggleTooltip(action) {
        switch (action) {
            case 'favorite':
                var ttip = '{{ Lang::get('site.event.unfavorite') }}'
                $('.favorite_btn')
                    .attr('title', ttip)
                    .tooltip('fixTitle');
                break;
            case 'unfavorite':
                var ttip = '{{ Lang::get('site.event.favorite') }}'
                $('.favorite_btn')
                    .attr('title', ttip)
                    .tooltip('fixTitle');
                break;
            case 'follow':
                var ttip = '{{ Lang::get('site.event.unfollow') }}'
                $('.follow_btn')
                    .attr('title', ttip)
                    .tooltip('fixTitle');
                break;
            case 'unfollow':
                var ttip = '{{ Lang::get('site.event.follow') }}'
                $('.follow_btn')
                    .attr('title', ttip)
                    .tooltip('fixTitle');
                break;
            case 'subscribe':
                var ttip = '{{ Lang::get('site.event.unsubscribe') }}'
                $('.subscribe_btn')
                    .attr('title', ttip)
                    .tooltip('fixTitle');
                break;
            case 'unsubscribe':
                var ttip = '{{ Lang::get('site.event.subscribe') }}'
                $('.subsribe_btn')
                    .attr('title', ttip)
                    .tooltip('fixTitle');
                break;
            default:
        }
    }

</script>

@if($event->latitude && $event->longitude)
<script>
    var latitude = '<?php echo $event->latitude?>';
    var longitude = '<?php echo $event->longitude ?>';
    function initialize() {
        var myLatlng = new google.maps.LatLng(latitude,longitude);
        var mapOptions  = {
            zoom: 10,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map
        });

        // collapse the map div
        $('.collapse').collapse();
    }

    google.maps.event.addDomListener(window, 'load', initialize);

</script>
@endif
@stop