@extends('admin.master')

{{-- Content --}}
@section('content')

<h1>Add Images</h1>
{{ Form::open(array('method' => 'POST', 'action' => array('AdminAdsController@store'), 'role'=>'form', 'files' => true)) }}

<div class="row">
    <div class="form-group col-md-12">
        {{ Form::label('ad1', 'Ad 1:') }}
        {{ Form::file('ad1',NULL,array('class'=>'form-control')) }}
    </div>
</div>
<div class="row">
    <div class="form-group col-md-12">
        {{ Form::label('ad2', 'Ad 2:') }}
        {{ Form::file('ad2',NULL,array('class'=>'form-control')) }}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-12">
        {{ Form::submit('Save', array('class' => 'btn btn-info')) }}
    </div>
</div>

{{ Form::close() }}
@if ($errors->any())
<div class="row">
    <div class="alert alert-danger">
        <ul>
            {{ implode('', $errors->all('<li class="error"> - :message</li>')) }}
        </ul>
    </div>
</div>
@endif
@stop
