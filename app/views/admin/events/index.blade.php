@extends('admin.master')

@section('content')
<p class="btn btn-default">{{ link_to_action('AdminEventsController@selectType', 'Add new event') }}</p>

<div class="row " style="margin-top: 20px;">
    <div class="col-md-12 ">
        <!-- Nav tabs category -->
        <ul class="nav nav-tabs faq-cat-tabs">
            <li class="active"><a href="#event-tab" data-toggle="tab">Events&nbsp;</a></li>
            <li><a href="#package-tab" data-toggle="tab">Packages&nbsp;</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content faq-cat-content" style="margin-top:20px;">
            <div class="tab-pane active in fade " id="event-tab">
                @if ($events->count())
                <table cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered">
                    <thead>
                    <tr>
                        <td>Event Id</td>
                        <th>Category</th>
                        <th>Location</th>
                        <th>Title</th>
                        <th>Date_start</th>
                        <th>Date_end</th>
                        <th>Address</th>
                        <th>Posted</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($events as $event)
                    <tr>
                        <td>{{{ $event->id }}}</td>
                        <td>
                            @if($event->category)
                            {{{ $event->category->name }}}
                            @endif
                        </td>
                        <td>
                            @if($event->location)
                            {{{ $event->location->name }}}
                            @endif
                        </td>
                        <td>{{{ $event->title }}}</td>
                        <td>{{{ $event->date_start }}}</td>
                        <td>{{{ $event->date_end }}}</td>
                        <td>{{{ $event->address }}}</td>
                        <td>{{{ $event->getHumanCreatedAtAttribute() }}} </td>
                        <td><a href="{{ URL::action('AdminEventsController@settings',$event->id)}}">Settings</a>
                            <button class="btn btn-xs btn-info"> <a href="{{ URL::action('AdminEventsController@edit', array($event->id)) }}">Edit</a></button>

                            {{ Form::open(array('method' => 'DELETE', 'action' => array('AdminEventsController@destroy', $event->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-xs btn-danger')) }}
                            {{ Form::close() }}
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-12">
                        {{ $events->links() }}
                    </div>
                </div>
                @else
                <div class="alert alert-danger alert-block">
                    There are no events
                </div>
                @endif

            </div>
            <div class="tab-pane fade" id="package-tab">

                @if ($packages->count())
                <table cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered">
                    <thead>
                    <tr>
                        <td>Package Id</td>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Posted</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($packages as $package)
                    <tr>
                        <td>{{ $package->id }}</td>
                            <td>{{ $package->title }}</td>
                        <td>{{ $package->price }}</td>
                        <td>{{ $package->created_at }} </td>
                        <td><a href="{{ URL::action('AdminEventsController@create',['package_id'=>$package->id])}}">Add Event</a>
                            <button class="btn btn-xs btn-info"> <a href="{{ URL::action('AdminPackagesController@edit', array($package->id)) }}">Edit</a></button>

                            {{ Form::open(array('method' => 'DELETE', 'action' => array('AdminPackagesController@destroy', $package->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-xs btn-danger')) }}
                            {{ Form::close() }}
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-12">
                    </div>
                </div>
                @else
                <div class="alert alert-danger alert-block">
                    There are no Packages
                </div>
                @endif


            </div>
        </div>
    </div>
</div>


@stop
