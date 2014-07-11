@extends('admin.master')

@section('style')
@parent
{{ HTML::style('assets/vendors/dropzone/css/dropzone.css') }}
@stop

@section('script')
@parent
{{ HTML::script('assets/vendors/dropzone/dropzone.min.js') }}

<script >


    // myDropzone is the configuration for the element that has an id attribute
    // with the value my-dropzone (or myDropzone)
    Dropzone.options.myDropzone = {
        init: function() {
            this.on("addedfile", function(file) {

            });
        }
    };

</script>

@stop

@section('content')
@include('admin.events.breadcrumb',['active'=>'photos'])

{{ Form::open(array('method' => 'POST', 'action' => array('AdminEventsController@storeImage'), 'class'=>'dropzone', 'id'=>'my-dropzone',  'files'=> true)) }}

<!-- Single file upload
<div class="dz-default dz-message"><span>Drop files here to upload</span></div>
-->
<!-- Multiple file upload-->
<div class="fallback">
    <input name="file" type="file" multiple />
</div>


{{ Form::close() }}


@stop
