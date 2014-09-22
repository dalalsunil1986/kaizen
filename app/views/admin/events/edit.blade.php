@extends('admin.master')

@section('style')
@parent
{{ HTML::style('assets/css/jquery.datetimepicker.css') }}
@stop

{{-- Content --}}
@section('content')

@include('admin.events.breadcrumb',['active'=>'info'])


<h1>Edit Event</h1>
{{ Form::model($event, array('method' => 'PATCH', 'action' => array('AdminEventsController@update', $event->id), 'role'=>'form', 'files' => true)) }}
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
        {{ Form::label('title_ar', 'Title in Arabic:*') }}
        {{ Form::text('title_ar',NULL,array('class'=>'form-control')) }}
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
        <p>{{ Form::label('tags', 'Tags:', array('class','pull-left')) }}</p>
            @foreach($tags as $tag)
                <div class="controls col-md-3">
                    @if(in_array($tag->id, $tags_array))
                        {{ Form::checkbox('tag[]', $tag->id, 'checked')  }}
                    @else
                        {{ Form::checkbox('tag[]', $tag->id, false)  }}
                    @endif
                    {{ Form::label($tag->name, $tag->name) }}
                </div>
            @endforeach
    </div>
</div>

<div class="row">
    <div class="form-group col-md-12">
        {{ Form::label('description_ar', 'Description in Arabic:*') }}
        {{ Form::textarea('description_ar',NULL,array('class'=>'form-control')) }}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-12">
        {{ Form::label('description_en', 'Description in English:') }}
        {{ Form::textarea('description_en',NULL,array('class'=>'form-control wysihtml5')) }}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-12">
        {{ Form::label('total_seats', 'Total Seats For this Event:') }}
        {{ Form::text('total_seats',NULL,array('class'=>'form-control')) }}
    </div>
</div>
<div class="row">
    <div class="form-group col-md-2 col-sm-4 col-xs-4">
        {{ Form::label('free_event', 'Is this a Free Event ?:') }}
        <br/>
        {{ Form::checkbox('free', '1', null ,['class'=>'free']) }}

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
        {{ Form::label('address_ar', 'Address in Arabic:*') }}
        {{ Form::text('address_ar',NULL,array('class'=>'form-control')) }}
    </div>

    <div class="form-group col-md-6">
        {{ Form::label('street_ar', 'Street Name in Arabic:*') }}
        {{ Form::text('street_ar',NULL,array('class'=>'form-control')) }}
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
        {{ Form::label('Phone', 'Phone:') }}
        <div class="input-group">
            {{ Form::text('phone',NULL,array('class'=>'form-control')) }}
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
        </div>
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('email', 'Email:') }}
        <div class="input-group">
            {{ Form::text('email',NULL,array('class'=>'form-control')) }}
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-12">
        {{ Form::label('featured', 'Is this a Featured Event ? : (Featured Event Will be included in Slider)') }}
        <br>
        {{ Form::checkbox('featured', '1', false) }}
    </div>
</div>
<div class="row">
    <div class="form-group col-md-12">
        <div class="map-wrapper">
            <div id="map" style="height: 400px;"></div>
            <div class="small">You can drag and drop the marker to the correct location</div>
            <input id="addresspicker_map" name="addresspicker_map" class="form-control"  placeholder="Type the Street Address or drag and drop the map marker to the correct location">
            {{ Form::hidden('latitude',NULL, array('id' => 'latitude')) }}
            {{ Form::hidden('longitude',NULL, array('id' => 'longitude')) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-6">
        {{ Form::label('button_ar', 'Event Button Text in Arabic:') }}
        {{ Form::text('button_ar',NULL,array('class'=>'form-control')) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('button_en', 'Event Button Text English:') }}
        {{ Form::text('button_en',NULL,array('class'=>'form-control')) }}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-12">
        {{ Form::submit('Update', array('class' => 'btn btn-info')) }}
        {{ link_to_action('EventsController@show', 'Cancel', $event->id, array('class' => 'btn')) }}
    </div>
</div>
{{ Form::close() }}
<div class="row">
    <div class="col-md-12">
        <table class="table table-striped custab">
            <thead>
            <a href="#" class="btn btn-primary btn-xs"> Delete Photos </a>
            <tr>
                <th>Image </th>
                <th class="text-center">Action</th>
            </tr>
            @foreach($event->photos as $photo)
               <tr>
                   <td> {{ HTML::image('uploads/thumbnail/'.$photo->name.'','image1',array('class'=>'img-responsive img-thumbnail')) }} </td>
                   <td>

                   {{ Form::open(array('method' => 'DELETE', 'action' => array('AdminPhotosController@destroy', $photo->id))) }}
                   {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                   {{ Form::close() }}
                   </td>
               </tr>

            @endforeach
        </table>
    </div>
</div>
@if ($errors->any())
<div class="row">
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</div>')) }}
    </ul>
</div>
@endif
<?php
$latitude = $event->latitude ? $event->latitude : '29.357';
$longitude =  $event->longitude ? $event->longitude : '47.951';
?>
@stop

@section('script')
@parent
<script src="http://maps.google.com/maps/api/js?sensor=false"></script>

{{HTML::script('assets/js/jquery-ui.min.js') }}
{{HTML::script('assets/js/jquery.datetimepicker.js') }}
{{HTML::script('assets/js/address.picker.js') }}

<script>
    $('document').ready(function() {

//        var free = '{{ $event->free }}';
//        var price = '{{ $event->price }}';

        // initial load
//        if ($('.free').is(':checked')) {
//            $("#price").prop('disabled', true);
//            $("#price").val('0');
//        } else
          if ($('#price').val() > 0) {
//              alert('price is greater than 0');
              $('.free').prop('checked', false);

          }
//              alert('price is greater than 0');
//            // on a reload
//            $('.free').prop('checked', false);
//            $("#price").prop('disabled', true);
//        }
    });
//
    $(".free").change(function() {
        alert('free');
        if(this.checked) {
            $("#price").val('0');
//            $("#price").prop('disabled', true);
        } else {
            $("#price").val('0');
//            $("#price").prop('disabled', false);
        }
    });

    $(function() {
        var latitude = '{{ $latitude }}';
        var longitude = '{{ $longitude }}';

//        get_map(latitude,longitude);

        var addresspicker = $( "#addresspicker" ).addresspicker();
        var addresspickerMap = $( "#addresspicker_map" ).addresspicker({
            updateCallback: showCallback,
            elements: {
                map:      "#map",
                lat:      "#latitude",
                lng:      "#longitude"
            }

        });

        var gmarker = addresspickerMap.addresspicker( "marker");
//        gmarker.setVisible(true);
//        addresspickerMap.addresspicker("updatePosition");

        $('#reverseGeocode').change(function(){
            $("#addresspicker_map").addresspicker("option", "reverseGeocode", ($(this).val() === 'true'));
        });

        function showCallback(geocodeResult, parsedGeocodeResult) {
            $('#callback_result').text(JSON.stringify(parsedGeocodeResult, null, 4));
        }
    });

    $(function(){
        $('#date_start').datetimepicker({
            format:'Y-m-d H:i',
            onShow:function( ct ){
            }
        });
        $('#date_end').datetimepicker({
            format:'Y-m-d H:i',
            onShow:function( ct ){
            }
        });

    });

</script>

@stop

