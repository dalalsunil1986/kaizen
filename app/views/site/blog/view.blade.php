@extends('site.layouts._one_column')
@section('content')

    {{-- Web site Title --}}
    @section('title')
    {{ $post->title }} ::
    @parent
    @stop
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

                            <p class="text-justify">
                                {{ $post->description }}
                            </p>
               </div>
           </div>
           <div class="col-md-2"></div>
        </div>




@stop
