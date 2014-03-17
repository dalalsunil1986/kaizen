@extends('site.layouts.home')
@section('maincontent')
<div class="row">
    @if(isset($search))
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
    @endif
    <table class="table table-striped">
        <tr>
            <h4>{{ Lang::get('site.event.all')}} {{Lang::get('site.event.events')}}</h4>

        </tr>
        <tr>
            <td>{{ Lang::get('site.event.title')}}</td>
            <td>{{ Lang::get('site.event.category') }}</td>
            <td>{{ Lang::get('site.event.date_start')}}</td>
            <td>{{ Lang::get('site.event.date_end')}}</td>
        </tr>
        @foreach($events as $event)
        <tr data-link="{{ action('EventsController@show',$event->id) }}">
            @if ( LaravelLocalization::getCurrentLocaleName() == 'English')

                @if($event->description_en)
                <td>{{ $event->title_en }} </td>
                <td>{{ $event->category->name_en }} </td>
                <td> {{ $event->date_start}}</td>
                <td>{{ $event->date_end}}</td>
                @else
                <td>{{ $event->title }} </td>
                <td>{{ $event->category->name }} </td>
                <td> {{ $event->date_start}}</td>
                <td>{{ $event->date_end}}</td>
                @endif
            @else
            <td>{{ $event->title_en }} </td>
            <td>{{ $event->category->name_en }} </td>
            <td> {{ $event->date_start}}</td>
            <td>{{ $event->date_end}}</td>
            @endif

        </tr>
        @endforeach

    </table>
    <?php echo $events->links(); ?>
</div>
@stop