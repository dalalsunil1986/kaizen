@extends('site.layouts.home')
@section('maincontent')

@foreach ($posts as $post)
    <!-- Post Title -->
    <div class="row">
        <h4><strong><a href="{{action('BlogsController@show',$post->slug) }}">{{ String::title($post->title) }}</a></strong></h4>
    </div>
    <!-- ./ post title -->

    <!-- Post Content -->
    <div class="row">
        <div class="col-md-2">
            @if(count($post->photos))
                {{ HTML::image('uploads/medium/'.$post->photos[0]->name.'','image1',array('class'=>'img-responsive img-thumbnail')) }}
            @else
            <a href="{{action('BlogsController@show',$post->slug) }}">
                <img src="http://placehold.it/100x100/2980b9/ffffff&text={{ $post->category->name }}" class="img-responsive img-thumbnail" />
            </a>
            @endif
        </div>
        <p style="width: 98%;">
            {{ String::tidy(Str::limit($post->content, 200)) }}
        </p>
        <p><a class="btn btn-mini btn-default" href="{{action('BlogsController@show',$post->slug) }}">Read more</a></p>
    </div>
    <!-- ./ post content -->

    <!-- Post Footer -->
    <div class="row">
        <p>
            <i class="glyphicon glyphicon-user"></i> by <span class="muted">{{{ $post->author->username }}}</span>
            | <i class="glyphicon glyphicon-calendar"></i> <!--Sept 16th, 2012-->{{{ $post->created_at->format('Y-m-d') }}}
        </p>
    </div>
    <!-- ./ post footer -->
<hr />
@endforeach

{{ $posts->links() }}

@stop
