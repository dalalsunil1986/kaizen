@extends('site.layouts.home')
@section('maincontent')

    {{-- Web site Title --}}
    @section('title')
    {{{ String::title($post->title) }}} ::
    @parent
    @stop

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

    @if(count($post->photos))
    <div class="col-md-12 col-sm-12" style="text-align: center">
        {{ HTML::image('uploads/medium/'.$post->photos[0]->name.'','image1',array('class'=>'img-responsive img-thumbnail')) }}
    </div>
    @endif

    <p class="text-justify">
        {{ $post->content() }}
    </p>

@stop
