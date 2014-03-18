@extends('site.layouts.home')
@section('maincontent')
<div class="row">
    <form class="form-inline" role="form">
        <div class="form-group">
            <label class="sr-only" for="exampleInputEmail2">Keyword</label>
            <input type="text" class="form-control" id="exampleInputEmail2" placeholder="Keyword">
        </div>
        <div class="form-group">
            <select class="form-control">
                <option selected disabled>Countries</option>
                <option>Kuwait</option>
                <option>Egypt</option>
                <option>USA</option>
                <option>UAE</option>
            </select>
        </div>
        <div class="form-group">
            <select class="form-control">
                <option selected disabled>Categories</option>
                <option>Workshops</option>
                <option>Conferences</option>
                <option>Courses</option>
            </select>
        </div>
        <div class="form-group">
            <select class="form-control">
                <option selected disabled>Author</option>
                <option>Workshops</option>
                <option>Conferences</option>
                <option>Courses</option>
            </select>
        </div>
        <button type="submit" class="btn btn-default">Sign in</button>
    </form>
</div>
</br>

@foreach($events as $event)
<div class="row">
    <div class="col-sm-2 col-md-2">
        <img src="http://thetransformedmale.files.wordpress.com/2011/06/bruce-wayne-armani.jpg"
             alt="" class="img-rounded img-responsive" />
    </div>
    <div class="col-sm-10 col-md-10">
        <h3><a href="event/{{$event->id}}">
            @if ( LaravelLocalization::getCurrentLocaleName() == 'English')
            @if($event->description_en)
            {{ $event->title_en }}
            @else
            {{ $event->title }}

            @endif
            @else
            {{ $event->title_en }}
            @endif
        </a></h3>
        <small>
            <i class="glyphicon glyphicon-user"></i> {{ $event->author}} |
            <i class="glyphicon glyphicon-calendar"></i> {{ $event->date_start }} }} |
            <i class="glyphicon glyphicon-tags"></i> {{  @if ( LaravelLocalization::getCurrentLocaleName() == 'English')  ? $event->name_en:$event->name }}
        </small>
        <p>
            @if ( LaravelLocalization::getCurrentLocaleName() == 'English')

            @if($event->description_en)
            {{ Str::limit($event->description, 30) }}
        @else
            {{ $event->description }}
        @endif
        @else
            {{ Str::limit($event->description, 100) }}
        @endif
            <a href="event/{{ $event->id}}">المزيد</a>
        </p>
    </div>
</div>
</br>
@endforeach
@stop
