@extends('site.layouts.home')
@section('maincontent')

    {{-- Web site Title --}}
    @section('title')
    {{{ String::title($post->title) }}} ::
    @parent
    @stop

    {{-- Content --}}
    <div class="well well-sm" style="margin-bottom: 10px;">
        <b>{{ $post->title }} </b>
        <span class="label label-default
        @if ( LaravelLocalization::getCurrentLocaleName() == 'English')
        pull-right
        @else
        pull-left
        @endif
        " style=" padding: 5px; margin:0px; margin-bottom: 5px;">
            Posted {{{ $post->created_at->format('Y-m-d') }}}
        </span>
    </div>

    <p class="text-justify">
        {{ $post->content() }}
    </p>




@stop
