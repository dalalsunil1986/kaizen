@extends('site.layouts.home')
@section('maincontent')

<div class="row">

    @foreach (array_chunk($posts->all(),2) as $row)
        <div class="row">
            @foreach($row as $post)
            <?php $colors = ['e67e22','2980b9','47A447']; ?>
                <div class="col-sm-6 col-md-6">
                    <div class="post">
                        <div class="post-img-content">
                            <a href="{{ action('BlogController@getView',$post->slug) }}" >
                            @if(count($post->photos))
                                {{ HTML::image('uploads/medium/'.$post->photos[0]->name.'','image1',array('class'=>'img-responsive img-thumbnail')) }}
                            @else
                                <img src="http://placehold.it/460x250/{{ $colors[array_rand($colors)] }}/ffffff&text={{ $post->category->name }}" class="img-responsive img-thumbnail" />
                            @endif
                            </a>
                        </div>
                        <div class="content">
                            <div class="post-title-wrapper">
                                <div class="post-title"><a href="{{ action('BlogController@getView',$post->slug) }}" >{{ $post->title }}</a></div>
                            </div>
                            <div class="post-author">
                                By <b> {{ $post->author->username }} </b> |
                                <time>{{ $post->created_at->format('Y-m-d') }}</time>
                            </div>
                            <div class="post-description">{{ Str::limit($post->content,150) }}</div>
                            <div class="post-button"><a href="{{action('BlogController@getView',$post->slug) }}" class="btn btn-primary btn-sm">Read more</a></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
{{ $posts->links() }}

@stop
