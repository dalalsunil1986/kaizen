@extends('emails.layouts.default')
@section('body')
    <h2>Password Reset</h2>
    <div>
        To reset your password, complete this form: {{ URL::to('password/reset', array($token)) }}.
    </div>
@stop