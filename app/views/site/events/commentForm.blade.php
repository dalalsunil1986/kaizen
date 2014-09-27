<div class="col-md-12">
    @if(Auth::User())
        {{ Form::open(array( 'action' => array('CommentsController@store', $event->id))) }}
            <div class="form-group">
                <label for="comment"></label>
                <textarea type="text" class="form-control" id="content" name="content" placeholder="{{ trans('site.event.comment')}}"></textarea>
            </div>
            <button type="submit" class="btn btn-default"> {{ trans('site.event.addcomment') }}</button>
        {{ Form::close() }}
    @endif
    @if ($errors->any())
        <ul> {{ implode('', $errors->all('<li class="error">:message</li> ')) }} </ul>
    @endif
</div>