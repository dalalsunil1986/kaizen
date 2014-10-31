@extends('site.layouts._one_column')
@section('content')

        <div class="col-md-12">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="row">
                    <div class="well well-sm" style="margin-bottom: 10px;">
                        <b>{{ $post->title }} </b>
                        <span class="label label-default
                        @if ( App::getLocale() == 'en')
                            pull-right
                        @else
                            pull-left
                        @endif
                        " style=" padding: 5px; margin:0px; margin-bottom: 5px;">
                        Posted {{ $post->created_at }}
                        </span>
                    </div>

                    @if(count($post->photos))
                        <div class="col-md-6 " style="text-align: center; padding: 15px;">
                            {{ HTML::image('uploads/medium/'.$post->photos[0]->name.'','image1',array('class'=>'img-responsive img-thumbnail')) }}
                        </div>
                    @endif

                    <p class="text-justify">{{ $post->description }}</p>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>

        <div class="col-md-12">
            @if(count($post->comments) > 0)
                <h3><i class=" glyphicon glyphicon-comment"></i>&nbsp;{{trans('word.comment') }}</h3>
                @foreach($post->comments as $comment)
                    <div class="comments_dev">
                        <p>{{ $comment->content }}</p>
                        <p
                        @if ( App::getLocale() == 'en')
                            class="text-left text-primary"
                        @else
                            class="text-right text-primary"
                        @endif
                        >{{ $comment->user->username}}
                        <span class="text-muted"> - {{ $comment->created_at }} </span></p>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="col-md-12">
            @if(Auth::check())
                {{ Form::open(array( 'action' => array('CommentsController@store', $post->id))) }}
                    {{ Form::hidden('commentable_id',$post->id)}}
                    {{ Form::hidden('commentable_type','Blog')}}
                    <div class="form-group">
                        <label for="comment"></label>
                        {{ Form::textarea('content',null,['class'=>'form-control','placehodler'=>trans('word.comment'),'rows'=>3]) }}
                    </div>
                    <button type="submit" class="btn btn-default"> {{ trans('word.add_comment') }}</button>
                {{ Form::close() }}
            @endif
            @if ($errors->any())
                <ul> {{ implode('', $errors->all('<li class="error">:message</li> ')) }} </ul>
            @endif
        </div>

@stop
