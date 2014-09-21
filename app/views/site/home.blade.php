<!-- Extends From Two Column Layou -->
@extends('site.layouts._two_column')

<!-- Include Slider -->
@include('site.events.slider')

<!-- Sidebar Section -->
@section('sidebar')
@parent
@stop

<!-- Content Section -->
@section('content')
@parent
    @include('site.partials.youtube')
    @include('site.partials.instagram')
@stop