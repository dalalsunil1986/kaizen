@extends('admin.master')

@section('style')
@parent
{{ HTML::style('assets/css/jquery.datetimepicker.css') }}
@stop

{{-- Content --}}
@section('content')

@include('admin.events.breadcrumb',['active'=>'info'])
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
        {{ Form::label('description_ar', 'Description in Arabic:*') }}
        {{ Form::textarea('description_ar',NULL,array('class'=>'form-control wysihtml5')) }}
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
        {{ Form::checkbox('free', '1', true,['class'=>'free']) }}
    </div>
    <div class="form-group col-md-10 col-sm-8 col-xs-8">
        {{ Form::label('price', 'Event Price:') }}
        {{ Form::text('price',NULL,array('class'=>'form-control','id'=>'price')) }}
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
    <div class="form-group col-md-12">
        {{ Form::label('button_en', 'Is this a Featured Event ? : (Featured Event Will be included in Slider)') }}
        <br>
        {{ Form::checkbox('featured', '1', false) }}
    </div>
</div>
<div class="row">
    <div class="form-group col-md-6">
        {{ Form::label('button_ar', 'Event Button Text in Arabic:') }}
        {{ Form::text('button_ar','سجل',array('class'=>'form-control')) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('button_en', 'Event Button Text English:') }}
        {{ Form::text('button_en','Register',array('class'=>'form-control')) }}
    </div>
</div>

@if(isset($_GET['package_id']))
{{ Form::hidden('package_id', $_GET['package_id']) }}
@endif

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

<?php
$latitude = '29.357';
$longitude = '47.951';
?>

@stop

@section('script')
@parent
<script src="http://maps.google.com/maps/api/js?sensor=false"></script>

{{HTML::script('assets/js/jquery-ui.min.js') }}
{{HTML::script('assets/js/jquery.datetimepicker.js') }}
{{HTML::script('assets/js/address.picker.js') }}

<script type="text/javascript">

    $('document').ready(function() {
        // initial load
        if ($('.free').is(':checked')) {
            $("#price").prop('disabled', true);
            $("#price").val('0');
        } else if ($('#price').val() == 0) {
            // on a reload
            $('.free').prop('checked', true);
            $("#price").prop('disabled', true);
        }
    });

    $(".free").change(function() {
        if(this.checked) {
            $("#price").val('0');
            $("#price").prop('disabled', true);
        } else {
            $("#price").val('0');
            $("#price").prop('disabled', false);
        }
    });

    $(function() {
        var latitude = '<?php echo $latitude?>';
        var longitude = '<?php echo $longitude ?>';

        get_map(latitude,longitude);

        var addresspickerMap = $( "#addresspicker_map" ).addresspicker({
            updateCallback: showCallback,
            elements: {
                map:      "#map",
                lat:      "#latitude",
                lng:      "#longitude"
            }

        });

        var gmarker = addresspickerMap.addresspicker( "marker");
        gmarker.setVisible(true);
        addresspickerMap.addresspicker("updatePosition");

        $('#reverseGeocode').change(function(){
            $("#addresspicker_map").addresspicker("option", "reverseGeocode", ($(this).val() === 'true'));
        });

        function showCallback(geocodeResult, parsedGeocodeResult) {
            $('#callback_result').text(JSON.stringify(parsedGeocodeResult, null, 4));
        }

    });

    $(function(){
        $('#date_start').datetimepicker({
            format:'Y-m-d H:i'
        });
        $('#date_end').datetimepicker({
            format:'Y-m-d H:i'
        });

    });



</script>

@stop
