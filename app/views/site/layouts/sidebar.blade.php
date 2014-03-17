extends('site.layouts.home')
@section('sidecontent')

<div id="twitter">
    <div class="panel panel-default">
        <div class="panel-heading">تويتر</div>
        <div class="panel-body">
            <a class="twitter-timeline" href="https://twitter.com/UsamaIIAhmed" data-widget-id="352804064125415424">Tweets by @UsamaIIAhmed</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
        </div>
    </div>
</div>

<div id="side-1">
    <div class="panel panel-default">
        <div class="panel-heading">
            العنوان الاول
        </div>
        <div class="panel-body">
            <ul>
                @foreach($latest_event_posts as $event)
                <li><a href="{{URL::action('EventsController@show',$event->id)}}"> {{ (LaravelLocalization::getCurrentLocaleName() == 'English') ? $event->title_en : $event->title }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<div id="side-2">
    <div class="panel panel-default">
        <div class="panel-heading">العنوان العنوان</div>
        <div class="panel-body">
            <ul>
                @foreach($latest_blog_posts as $post)
                <li><a href="{{URL::action('BlogController@getView',$post->slug)}}"> {{ $post->title }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<div id="side-3">
    <div class="panel panel-default">
        <div class="panel-heading">
            القائمة البريدية
        </div>
        <div class="panel-body">
            {{ Form::open(array('action'=>'NewslettersController@store')) }}
                {{Form::input('email','email',NULL,array('class'=>'form-control'))}}
                {{Form::submit('Subscribe',array('class'=>'btn btn-primary'))}}
            {{Form::close()}}
        </div>
    </div>
</div>
@stop