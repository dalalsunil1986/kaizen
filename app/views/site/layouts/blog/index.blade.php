@extends('site.layouts.home')
@section('maincontent')
@foreach ($posts as $post)
<div class="row">

        <!-- Post Title -->
        <div class="row">

                <h4><strong><a href="blog/{{$post->slug}}">{{ String::title($post->title) }}</a></strong></h4>

        </div>
        <!-- ./ post title -->

        <!-- Post Content -->
        <div class="row">
            <div class="col-md-2">
                <a href="blog/{{$post->slug}}" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a>
            </div>

                <p>
                    {{ String::tidy(Str::limit($post->content, 200)) }}
                </p>
                <p><a class="btn btn-mini btn-default" href="blog/{{$post->slug}}">Read more</a></p>

        </div>
        <!-- ./ post content -->

        <!-- Post Footer -->
        <div class="row">

                <p></p>
                <p>
                    <span class="glyphicon glyphicon-user"></span> by <span class="muted">{{{ $post->author->username }}}</span>
                    | <span class="glyphicon glyphicon-calendar"></span> <!--Sept 16th, 2012-->{{{ $post->date() }}}
                    | <span class="glyphicon glyphicon-comment"></span> <a href="blog/{{$post->slug}}#comments">{{$post->comments()->count()}} {{ \Illuminate\Support\Pluralizer::plural('Comment', $post->comments()->count()) }}</a>
                </p>

        </div>
        <!-- ./ post footer -->
</div>

<hr />
@endforeach

{{ $posts->links() }}

@stop
