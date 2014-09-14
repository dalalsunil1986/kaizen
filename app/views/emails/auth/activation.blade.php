@extends('emails.layouts.default')
@section('body')
    <h2>Hello {{ $name }}, </h2>
    <div>
        Please Click <a href="{{ $link }}"> this link </a> to Activate your Account.
    </div>
@stop