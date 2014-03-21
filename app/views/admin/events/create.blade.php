@extends('admin.layouts.default')

{{-- Content --}}
@section('content')

<h1>Edit Event</h1>
{{ Form::open(array('method' => 'POST', 'action' => array('AdminEventsController@store'), 'role'=>'form', 'files' => true)) }}
<div class="row">
    <div class="form-group col-md-4">
        {{ Form::label('user_id', 'Author:',array('class'=>'control-label')) }}
        {{ Form::select('user_id', $author,NULL,array('class'=>'form-control')) }}
    </div>

    <div class="form-group col-md-4">
        {{ Form::label('category_id', 'Category:') }}
        {{ Form::select('category_id', $category,NULL,array('class'=>'form-control')) }}
    </div>

    <div class="form-group col-md-4">
        {{ Form::label('location_id', 'Location:') }}
        {{ Form::select('location_id', $location,NULL,array('class'=>'form-control')) }}
    </div>
</div>
<div class="row">
    <div class="form-group col-md-12">
        {{ Form::label('title', 'Title in Arabic:*') }}
        {{ Form::text('title',NULL,array('class'=>'form-control')) }}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-12">
        {{ Form::label('title_en', 'Title in English:') }}
        {{ Form::text('title_en',NULL,array('class'=>'form-control')) }}
    </div>
</div>


<div class="row">
    <div class="form-group col-md-12">
        {{ Form::label('description', 'Description in Arabic:*') }}
        {{ Form::textarea('description',NULL,array('class'=>'form-control')) }}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-12">
        {{ Form::label('description_en', 'Description in English:') }}
        {{ Form::textarea('description_en',NULL,array('class'=>'form-control')) }}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-2 col-sm-4 col-xs-4">
        {{ Form::label('free_event', 'Free Event ?:') }}
        <br/>
        {{ Form::checkbox('free', '1', true) }}
    </div>
    <div class="form-group col-md-10 col-sm-8 col-xs-8">
        {{ Form::label('price', 'Event Price:') }}
        {{ Form::text('price',NULL,array('class'=>'form-control')) }}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        {{ Form::label('date_start', 'Event Start Date:') }}
        <div class="input-group">
            {{ Form::text('date_start',NULL,array('class'=>'form-control')) }}
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
        </div>
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('date_end', 'Event End Date:') }}
        <div class="input-group">
            {{ Form::text('date_end',NULL,array('class'=>'form-control')) }}
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        {{ Form::label('address', 'Address in Arabic:*') }}
        {{ Form::text('address',NULL,array('class'=>'form-control')) }}
    </div>

    <div class="form-group col-md-6">
        {{ Form::label('street', 'Street Name in Arabic:*') }}
        {{ Form::text('street',NULL,array('class'=>'form-control')) }}
    </div>
</div>
<div class="row">
    <div class="form-group col-md-6">
        {{ Form::label('address_en', 'Address in English:') }}
        {{ Form::text('address_en',NULL,array('class'=>'form-control')) }}
    </div>

    <div class="form-group col-md-6">
        {{ Form::label('street_en', 'Street Name in English:') }}
        {{ Form::text('street_en',NULL,array('class'=>'form-control')) }}
    </div>
</div>
<div class="row">
    <div class="form-group col-md-6">
        {{ Form::label('button', 'Event Button Text in Arabic:') }}
        {{ Form::text('button','سجل',array('class'=>'form-control')) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('button_en', 'Event Button Text English:') }}
        {{ Form::text('button_en','Register',array('class'=>'form-control')) }}
    </div>
</div>
<div class="row">
    <div class="form-group col-md-12">
        {{ Form::label('thumbnail', 'Event Thumbnail:') }}
        {{ Form::file('thumbnail',NULL,array('class'=>'form-control')) }}
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
<script>
    $(function(){
        $('#date_start').datetimepicker({
            format:'Y-m-d H:i',
            onShow:function( ct ){
                this.setOptions({
                    maxDate:$('#date_end').val()?$('#date_end').val():false
                })
            }
        });
        $('#date_end').datetimepicker({
            format:'Y-m-d H:i',
            onShow:function( ct ){
                this.setOptions({
                    minDate:$('#date_start').val()?$('#date_start').val():false
                })
            }
        });

    });

</script>
@stop
