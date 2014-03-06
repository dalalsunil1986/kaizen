@section('maincontent')
<div class="row">
    <div class="row">

        <button type="button" class="btn btn-info">Info</button>
        <button type="button" class="btn btn-info">Info</button>
        <button type="button" class="btn btn-info">Info</button>
    </div>

    @if ( LaravelLocalization::getCurrentLocaleName() == 'English')
    <h1>{{ $event->title_en}}</h1>


    <p> {{ $event->description_en }}</p>
    <address>
        <strong> {{ $event->address}} </strong><br>
        795 Folsom Ave, Suite 600<br>
        San Francisco, CA 94107<br>
        <abbr title="Phone">P:</abbr> (123) 456-7890
    </address>



    @else
    <h1>{{ $event->title}}</h1>
    <table class="table table-striped">
        <tr>
           <h4>{{ Lang::get('site.event.summaryevent') }}</h4>
        </tr>
        <tr>
            <td><b>{{ Lang::get('site.event.totalseats') }}</b></td>
            <td> {{ $event->total_seats}}</td>
            <td> {{ Lang::get('site.event.seatsavail') }}</td>
            <td > {{ $event->available_seats}} </td>

        </tr>
        <tr>
            <td><b>{{ Lang::get('site.event.date_start') }}</b></td>
            <td> {{ $event->date_start }}</td>
            <td> {{ Lang::get('site.event.date_end') }}</td>
            <td > {{ $event->date_end }} </td>

        </tr>
        <tr>
            <td><b>{{ Lang::get('site.event.time_start') }}</b></td>
            <td> {{ $event->time_start }}</td>
            <td> {{ Lang::get('site.event.time_end') }}</td>
            <td > {{ $event->time_end }} </td>

        </tr>
    </table>

    <p> {{ $event->description }}</p>


    <iframe style="width: 100%; height: auto; min-height: 35%;" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
            src="https://maps.google.com/?ie=UTF8&amp;ll={{ $event->latitude }}, {{ $event->longitude}} &amp;spn=0.006804,0.013078&amp;t=h&amp;z=17&amp;iwloc=lyrftr:h,13915458150213254177,29.275525,48.049972&amp;output=embed">

            </iframe>

    <address>
        <strong> {{ $event->address}} </strong><br>
       {{ $event->street }}<br>
        <abbr title="Phone">39483498</abbr>
    </address>
    @endif


</div>
@stop