@extends('site.layouts._one_column')

@section('content')

    <div class="row">
    <div class="col-md-1"></div>
       <div class="col-md-10">
           <address>
               <h2 style="background-color: rgba(221, 220, 219, 0.83); padding:10px;">Contact Us</h2>
               @if($contact)
               <b>{{ Lang::get('site.general.email')  }}</b> : {{ $contact->email }}</br>
               <b>{{ Lang::get('site.general.address')}}</b> : {{ $contact->address_en }}</br>
               <b>{{ Lang::get('site.general.phone')  }}</b> : {{ $contact->phone }} </br>
               <b>{{ Lang::get('site.general.mobile') }}</b> : {{ $contact->mobile }} </br>
               @endif
           </address>
       </div>
       <div class="col-md-1"></div>
    </div>


    <div class="row">
    <div class="col-md-1"></div>
        <div class="col-md-10">
            {{ Form::open(array('method' => 'POST', 'action' => array('ContactsController@contact'), 'role'=>'form')) }}

            <div class="form-group">
                <label for="exampleInputEmail">{{ Lang::get('site.general.email') }}</label>
                {{ Form::text('sender_email', null , ['class' => 'form-control', 'placeholder' => Lang::get('site.general.email') ]) }}
            </div>
            <div class="form-group">
                <label for="name">{{ Lang::get('site.general.name') }}</label>
                {{ Form::text('sender_name', null , ['class' => 'form-control', 'placeholder' => Lang::get('site.general.name') ]) }}
            </div>
            <div class="form-group">
                <label for="comment">{{ Lang::get('site.general.comment') }}</label>
                {{ Form::textarea('body', null , ['class' => 'form-control', 'placeholder' => Lang::get('site.general.comment')]) }}
            </div>
            <button type="submit" class="btn btn-default">{{ Lang::get('site.general.submit') }}</button>
            {{ Form::close() }}
        </div>
        <div class="col-md-1"></div>
    </div>

@stop