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

                var removeButton = Dropzone.createElement('<a class="dz-remove">Remove file</a>');
                var _this = this;

                removeButton.addEventListener("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    var fileInfo = new Array();
                    fileInfo['name']=file.name;

                    $.ajax({
                        type: "POST",
                        url: "{{ url('/delete-image') }}",
                        data: {file: file.name},
                        beforeSend: function () {
                            // before send
                        },
                        success: function (response) {

                            if (response == 'success')
                                alert('deleted');
                        },
                        error: function () {
                            alert("error");
                        }
                    });


                    _this.removeFile(file);

                    // If you want to the delete the file on the server as well,
                    // you can do the AJAX request here.
                });


                // Add the button to the file preview element.
                file.previewElement.appendChild(removeButton);
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

{{ Form::file('filename', ['class' => 'form-control']) }}

{{ Form::submit('Submit', ['class' => 'form-control']) }}

{{ Form::close() }}


@stop
