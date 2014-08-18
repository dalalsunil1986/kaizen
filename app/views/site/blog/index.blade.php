@extends('site.layouts._one_column')
@section('content')

@foreach ($posts as $post)
    <!-- Post Title -->

    <h4><strong><a href="{{action('BlogsController@show',$post->id) }}">{{ $post->title }}</a></strong></h4>

    <!-- ./ post title -->

    <!-- Post Content -->

        <div class="col-md-2">
            @if(count($post->photos))
                {{ HTML::image('uploads/medium/'.$post->photos[0]->name.'','image1',array('class'=>'img-responsive img-thumbnail')) }}
            @else
            <a href="{{action('BlogsController@show',$post->id) }}">
                <img src="http://placehold.it/100x100/2980b9/ffffff&text={{ $post->category->name }}" class="img-responsive img-thumbnail" />
            </a>
            @endif
        </div>
        <p style="width: 98%;">
            {{ Str::limit($post->content, 200) }}
        </p>
        <p><a class="btn btn-mini btn-default" href="{{action('BlogsController@show',$post->id) }}">Read more</a></p>

    <!-- ./ post content -->

    <!-- Post Footer -->

        <p>
            <i class="glyphicon glyphicon-user"></i> by <span class="muted">{{{ $post->author->username }}}</span>
            | <i class="glyphicon glyphicon-calendar"></i> <!--Sept 16th, 2012-->{{{ $post->created_at }}}
        </p>

    <!-- ./ post footer -->
<hr />
@endforeach

{{ $posts->links() }}

@stop
