@extends('admin.master')

@section('style')
@parent

@stop

{{-- Content --}}
@section('content')
<div class="row form-group">
    <div class="col-xs-12">
        <ul class="nav nav-pills nav-justified thumbnail setup-panel">
            <li class="active"><a href="#step-1">
                    <h4 class="list-group-item-heading">Step 1</h4>
                    <p class="list-group-item-text">Select Event Type</p>
                </a></li>
            <li class="disabled"><a href="#step-2">
                    <h4 class="list-group-item-heading">Step 2</h4>
                    <p class="list-group-item-text">Fill up Event Information</p>
                </a></li>
            <li class="disabled"><a href="#step-3">
                    <h4 class="list-group-item-heading">Step 3</h4>
                    <p class="list-group-item-text">Fill up Event Options</p>
                </a></li>
        </ul>
    </div>
</div>
<div class="row setup-content" id="step-1">
    <div class="col-xs-12">
        <div class="col-md-12 well text-center">
            <div class="ui-group-buttons">
                <a href="{{ action('AdminEventsController@create') }}" class="btn  btn-success" role="button"><span class="fa fa-calendar"></span> Event</a>
                <div class="or"></div>
                <a href="{{ action('AdminPackagesController@create') }}" class="btn btn-success" role="button"><span class="fa fa-database"></span> Package</a>
            </div>
        </div>
    </div>
</div>

@stop
