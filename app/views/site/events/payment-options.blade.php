@extends('site.layouts._two_column')

@section('content')

        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="mute">{{ trans('site.payment_options') }}</span>
            </div>
            <div class="panel-body bg-white">
                @include('site.events._results')
            </div>
            <div class="panel-footer">
                <div class="row text-center">
                    <div class="col-xs-9">
                        <h4 class="text-right">{{trans('site.total')}} : <strong>{{ $event->convertPrice }}</strong></h4>
                    </div>
                    <div class="col-xs-3">
                        {{ Form::open(['class' => 'form', 'method' => 'post', 'action' => ['PaymentsController@postPayment']]) }}
                            {{ Form::hidden('event_id',$event->id) }}
                            {{ Form::hidden('token', Input::get('token')) }}
                            <div class='form-actions'>
                                <input class="btn btn btn-success" name="commit" type="submit" value="{{trans('site.pay-with-payapl')}}" />
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>


@stop
