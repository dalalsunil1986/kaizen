@extends('site.layouts.home')
@section('maincontent')
@foreach ($posts as $post)


        <!-- Post Title -->
        <div class="row">

                <h4><strong><a href="blog/{{$post->slug}}">{{ String::title($post->title) }}</a></strong></h4>

        </div>
        <!-- ./ post title -->

        <!-- Post Content -->
        <div class="row">
            <div class="col-md-2">
                @if(count($post->photos))
                    {{ HTML::image('uploads/medium/'.$post->photos[0]->name.'','image1',array('class'=>'img-responsive img-thumbnail')) }}
                @else
                    <img src="http://placehold.it/260x180/2980b9/ffffff&text={{ $post->category->name }}" class="img-responsive img-thumbnail" />
                @endif

<!--                <a href="{{action('BlogController@getView',$post->slug) }}" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a>-->
            </div>
            <p style="width: 98%;">
                {{ String::tidy(Str::limit($post->content, 200)) }}
            </p>
            <p><a class="btn btn-mini btn-default" href="blog/{{$post->slug}}">Read more</a></p>

        </div>
        <!-- ./ post content -->

        <!-- Post Footer -->
        <div class="row">

                <p></p>
                <p>
                    <i class="glyphicon glyphicon-user"></i> by <span class="muted">{{{ $post->author->username }}}</span>
                    | <i class="glyphicon glyphicon-calendar"></i> <!--Sept 16th, 2012-->{{{ $post->created_at->format('Y-m-d') }}}
                    | <i class="glyphicon glyphicon-comment"></i> <a href="blog/{{$post->slug}}#comments">{{$post->comments()->count()}} {{ \Illuminate\Support\Pluralizer::plural('Comment', $post->comments()->count()) }}</a>
                </p>

        </div>
        <!-- ./ post footer -->
<hr />
@endforeach

{{ $posts->links() }}

@stop
