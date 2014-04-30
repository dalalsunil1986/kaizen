extends('site.layouts.home')
@section('sidecontent')
<div id="twitter">
    <div class="panel panel-default">
        <div class="panel-heading">{{ Lang::get('site.general.twitter') }}</div>
        <div class="panel-body">
            <a class="twitter-timeline" href="https://twitter.com/UsamaIIAhmed" data-widget-id="352804064125415424">Tweets by @UsamaIIAhmed</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
        </div>
    </div>
</div>

<div id="side-1">
    <div class="panel panel-default">
        <div class="panel-heading">
           {{ Lang::get('site.general.latest_events') }}
        </div>
        <div class="panel-body">
            <ul>
                @if($latest_event_posts)
                    @foreach($latest_event_posts as $event)
                    <li class="unstyled"><i class="glyphicon glyphicon-calendar"></i> <a href="{{URL::action('EventsController@show',$event->id)}}"> {{ (LaravelLocalization::getCurrentLocaleName() == 'English') ? $event->title_en : $event->title }}</a></li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
</div>

<div id="side-2">
    <div class="panel panel-default">
        <div class="panel-heading">{{ Lang::get('site.general.latest_blog') }}</div>
        <div class="panel-body">
            <ul>
                @if($latest_blog_posts)
                    @foreach($latest_blog_posts as $post)
                    <li class="unstyled"><i class="glyphicon glyphicon-book"></i><a href="{{URL::action('BlogsController@show',$post->slug)}}"> {{ $post->title }}</a></li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
</div>

<div id="side-3">
    <div class="panel panel-default">
        <div class="panel-heading">
            {{ Lang::get('site.general.newsletter') }}
        </div>
        <div class="panel-body">
            <div class="col-md-12">
                <div class="form-group">
                    <span class="mute">{{ Lang::get('site.general.newsletter_subscribe') }}</span>
                    {{ Form::open(array('action'=>'NewslettersController@store')) }}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-envelope"></i>
                            </span>
                            {{Form::input('email','email',NULL,array('class'=>'form-control','placeholder'=>'Email','required'=>'"required"'))}}
                            <span class="input-group-btn">
                                <button id="submit" class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-arrow-left glyphicon-fw"></i> </button>
                            </span>
                        </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
</div>
@stop