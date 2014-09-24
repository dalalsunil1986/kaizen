@extends('admin.master')

@section('content')
<p class="btn btn-default">{{ link_to_action('AdminEventsController@selectType', 'Add New Event / Package') }}</p>

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
                        <td>Event ID</td>
                        <th>Title</th>
                        <th>Start Date</th>
                        <th>Event Settings</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($events as $event)
                        @if(count($event->setting))
                            <tr>
                                <td>{{{ $event->id }}}</td>
                                <td>{{{ $event->title }}}</td>
                                <td>{{{ $event->date_start }}}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                      <a href="{{ URL::action('AdminEventsController@getDetails',$event->id)}}" class="btn btn-default">Details</a>
                                      <a href="{{ URL::action('AdminSettingsController@edit',$event->setting->id)}}" class="btn btn-default">Settings</a>
                                      <a href="{{ URL::action('AdminSettingsController@getAddRoom', $event->setting->id) }}" class="btn btn-default">Add Online Room Number</a>
                                    </div>
                                </td>

                                <td><a href="{{ URL::action('AdminPhotosController@create', ['imageable_type' => $event->setting->settingable_type, 'imageable_id' => $event->setting->settingable_id]) }}" class="btn btn-sm btn-success">Add Photos</a></td>
                                <td><a href="{{ URL::action('AdminEventsController@edit', array($event->id)) }}" class="btn btn-sm btn-warning">Edit</a></td>
                                <td>
                                    {{ Form::open(array('method' => 'DELETE', 'action' => array('AdminEventsController@destroy', $event->id))) }}
                                        {{ Form::submit('Delete', array('class' => 'btn btn-sm btn-danger')) }}
                                    {{ Form::close() }}
                                </td>
                            </tr>
                        @endif
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

                @foreach ($packages as $package)
                    <div class="panel panel-default panel-faq">
                        <div class="panel-heading">
                            <a data-toggle="collapse" data-parent="#accordion-cat-{{ $package->id }}" href="#faq-cat-1-sub-{{ $package->id }}">
                                <h4 class="panel-title">
                                    {{ $package->title_ar }}
                                    <span class="mute">
                                        @if($package->free)
                                            Free Event
                                        @else
                                            {{ $package->price }}
                                        @endif
                                    </span>
                                    <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                                </h4>
                            </a>
                        </div>
                        <div id="faq-cat-1-sub-{{ $package->id }}" class="panel-collapse collapse">
                            <div class="panel-body">

                                {{ Form::open(array('method' => 'DELETE', 'action' => array('AdminPackagesController@destroy', $package->id))) }}
                                    <a href="{{ action('AdminEventsController@create',['package_id'=>$package->id]) }}" class="btn"><i class="glyphicon glyphicon-plus"></i> <strong>Add Sub Events</strong></a>
                                    <a href="{{ action('AdminPackagesController@show',$package->id) }}" class="btn"><i class="glyphicon glyphicon-pencil"></i> <strong>View</strong></a>
                                    <a href="{{ action('AdminPackagesController@edit',$package->id) }}" class="btn"><i class="glyphicon glyphicon-edit"></i> <strong>Edit</strong></a>
                                    <i class="glyphicon glyphicon-trash"></i>{{ Form::submit('Delete', array('class' => 'btn btn-xs')) }}
                                {{ Form::close() }}

                                <table cellpadding="0" cellspacing="0" border="0" class=" table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <td>ID</td>
                                        <th>Title</th>
                                        <th>Date_start</th>
                                        <th>Date_end</th>
                                        <th>Posted</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach ($package->events as $event)
                                    <tr>
                                        <td>{{{ $event->id }}}</td>
                                        <td>{{{ $event->title }}}</td>
                                        <td>{{{ $event->date_start }}}</td>
                                        <td>{{{ $event->date_end }}}</td>
                                        <td>{{{ $event->getHumanCreatedAtAttribute() }}} </td>
                                        <td><a href="{{ URL::action('AdminEventsController@getDetails',$event->id)}}">Details</a>
                                            <a href="{{ URL::action('AdminEventsController@edit', array($event->id)) }}">Edit</a>

                                            {{ Form::open(array('method' => 'DELETE', 'action' => array('AdminEventsController@destroy', $event->id))) }}
                                                {{ Form::submit('Delete', array('class' => 'btn btn-xs btn-danger')) }}
                                            {{ Form::close() }}
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                @endforeach

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
