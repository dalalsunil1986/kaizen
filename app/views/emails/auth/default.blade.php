@extends('emails.layouts.default')
@section('body')
    <h2>Hello {{ $name }}, </h2>
    <div>
        {{ $body }}
    </div>
@stop