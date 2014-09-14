@extends('emails.layouts.default')
@section('body')
    <h1> hello, {{ $username }}</h1>
   {{ $body }}
@stop