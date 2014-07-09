@extends('admin.master')

@section('style')
@parent
{{ HTML::style('assets/css/jquery.datetimepicker.css') }}
@stop

{{-- Content --}}
@section('content')

<h1>Edit Event</h1>
{{ Form::model($setting, array('method' => 'POST', 'action' => array('AdminEventsController@store'), 'role'=>'form')) }}
<div class="row">

    <div class="form-group col-md-6">
        {{ Form::label('approval_type', 'Approval Type:') }}
        <select name="approval_type" id="approval_type" class="form-control">
            <option value="">Select one</option>
            @foreach($approvalTypes as $approvalType)
            <option value="{{ $approvalType }}"
            @if( Form::getValueAttribute('approval_type') == $approvalType)
            selected = "selected"
            @endif
            >{{ $approvalType }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-6">
        {{ Form::label('approval_type', 'Registration Type:') }}
        <select name="approval_type" id="approval_type" class="form-control">
            <option value="">Select one</option>
            @foreach($approvalTypes as $approvalType)
            <option value="{{ $approvalType }}"
            @if( Form::getValueAttribute('approval_type') == $approvalType)
            selected = "selected"
            @endif
            >{{ $approvalType }}</option>
            @endforeach
        </select>
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
