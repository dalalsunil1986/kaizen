@extends('site.layouts.home')
@section('maincontent')

{{-- Web site Title --}}
@section('title')
{{{ String::title($post->title) }}} ::
@parent
@stop

{{-- Update the Meta Title --}}
@section('meta_title')
@parent

@stop

{{-- Update the Meta Description --}}
@section('meta_description')
@parent

@stop

{{-- Update the Meta Keywords --}}
@section('meta_keywords')
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
    Posted {{{ $post->date() }}}</span>
</div>

<p class="text-justify">

    {{ $post->content() }}</p>

<div>

</div>

<!--<a id="comments"></a>-->
<!--<h4>{{{ $comments->count() }}} Comments</h4>-->
<!---->
<!--@if ($comments->count())-->
<!--@foreach ($comments as $comment)-->
<!--<div class="row">-->
<!--	<div class="col-md-1">-->
<!--		<img class="thumbnail" src="http://placehold.it/60x60" alt="">-->
<!--	</div>-->
<!--	<div class="col-md-11">-->
<!--		<div class="row">-->
<!--			<div class="col-md-11">-->
<!--				<span class="muted">{{{ $comment->author->username }}}</span>-->
<!--				&bull;-->
<!--				{{{ $comment->date() }}}-->
<!--			</div>-->
<!---->
<!--			<div class="col-md-11">-->
<!--				<hr />-->
<!--			</div>-->
<!---->
<!--			<div class="col-md-11">-->
<!--				{{{ $comment->content() }}}-->
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->
<!--</div>-->
<!--<hr />-->
@endforeach
@else

@endif

<!--@if ( ! Auth::check())-->
<!--You need to be logged in to add comments.<br /><br />-->
<!--Click <a href="{{{ URL::to('user/login') }}}">here</a> to login into your account.-->
<!--@elseif ( ! $canComment )-->
<!--You don't have the correct permissions to add comments.-->
<!--@else-->
<!---->
<!--@if($errors->has())-->
<!--<div class="alert alert-danger alert-block">-->
<!--<ul>-->
<!--@foreach ($errors->all() as $error)-->
<!--	<li>{{ $error }}</li>-->
<!--@endforeach-->
<!--</ul>-->
<!--</div>-->
<!--@endif-->
<!---->
<!--<h4>Add a Comment</h4>-->
<!--<form  method="post" action="{{{ URL::to($post->slug) }}}">-->
<!--	<input type="hidden" name="_token" value="{{{ Session::getToken() }}}" />-->
<!---->
<!--	<textarea class="col-md-12 input-block-level" rows="4" name="comment" id="comment">{{{ Request::old('comment') }}}</textarea>-->
<!---->
<!--	<div class="form-group">-->
<!--		<div class="col-md-12">-->
<!--			<input type="submit" class="btn btn-default" id="submit" value="Submit" />-->
<!--		</div>-->
<!--	</div>-->
<!--</form>-->
<!--@endif-->
@stop
