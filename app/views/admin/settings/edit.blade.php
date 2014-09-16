@extends('admin.master')

@section('style')
    @parent
    {{ HTML::style('assets/css/jquery.datetimepicker.css') }}
    {{ HTML::style('assets/vendors/select2/select2.css') }}
    {{ HTML::style('assets/vendors/select2/select2-bootstrap.css') }}
    {{ HTML::style('assets/css/jquery.datetimepicker.css') }}
@stop

@section('script')
    @parent
    {{ HTML::script('assets/vendors/select2/select2.min.js') }}
    <script>
        $(document).ready(function() {
            $('#registration_types').select2({
                placeholder: "Select Reigstration Types",
                allowClear: true,
                maximumSelectionSize: 3
            });
        });
    </script>
@stop

{{-- Content --}}
@section('content')

    @include('admin.events.breadcrumb',['active'=>'options'])

    {{ Form::model($setting, array('method' => 'PATCH', 'action' => array('AdminSettingsController@update',$setting->id), 'role'=>'form')) }}

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
                        >{{ $approvalType }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-6">
                {{ Form::label('registration_types', 'Registration Type:') }}
                <select id="registration_types" name="registration_types[]" class="form-control" multiple="multiple" >
                    @foreach($registrationTypes as $registrationType)
                        <option value="{{ $registrationType }}"
                            @if(in_array($registrationType,$currentRegistrationTypes))
                            selected="selected"
                            @endif
                        >{{$registrationType}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="form-group col-md-6">
                {{ Form::label('vip_price', 'VIP Price:') }}
                {{ Form::text('vip_price',null,['class'=>'form-control'])}}
            </div>

            <div class="form-group col-md-6">
                {{ Form::label('online_price', 'Online Price:') }}
                {{ Form::text('online_price',null,['class'=>'form-control'])}}
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="form-group col-md-6">
                {{ Form::label('vip_description_en', 'VIP Description in English') }}
                {{ Form::textarea('vip_description_en',null,['class'=>'form-control wysihtml5','rows'=>'5'])}}
            </div>
            <div class="form-group col-md-6">
                {{ Form::label('vip_description_ar', 'VIP Description in Arabic') }}
                {{ Form::textarea('vip_description_ar',null,['class'=>'form-control wysihtml5','rows'=>'5'])}}
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="form-group col-md-6">
                {{ Form::label('online_description_en', 'ONLINE Description in English') }}
                {{ Form::textarea('online_description_en',null,['class'=>'form-control wysihtml5','rows'=>'5'])}}
            </div>
            <div class="form-group col-md-6">
                {{ Form::label('online_description_ar', 'ONLINE Description in Arabic') }}
                {{ Form::textarea('online_description_ar',null,['class'=>'form-control wysihtml5','rows'=>'5'])}}
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


