@section('maincontent')
<div class="row">

    <table class="table table-striped">
        <tr>
            <h4>All Events</h4>

        </tr>
        <tr>
            <td>Title</td>
            <td>Category</td>
            <td>Start Date</td>
            <td>End Date</td>
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