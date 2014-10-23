<div class="row top20">
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
            <a href="{{action('EventsController@show',$event->id )}}">{{ Lang::get('site.general.more')}}</a>
        </p>

    </div>
</div>

<div class="row" style="margin: 9px; ">

    <i class="glyphicon glyphicon-user">
        {{ link_to_action('EventsController@index', $event->author->username,array('search'=>'','author'=>$event->author->id)) }}
    |</i>
    <i class="glyphicon glyphicon-calendar"></i> {{ $event->date_start }} -  {{ $event->date_end }} |

    <i class="glyphicon glyphicon-globe">

        {{ link_to_action('EventsController@index', $event->location->country->name ,array('search'=>'','country'=>$event->location->country->id)) }}
    |</i>

    @if($event->category)
        <i class="glyphicon glyphicon-tag"></i>&nbsp;&nbsp;
        {{ link_to_action('EventsController@index', $event->category->name,array('search'=>'','category'=>$event->category->id)) }}
    @endif
</div>
<hr>