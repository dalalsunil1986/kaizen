@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')
	{{-- Edit Blog Form --}}
    {{ Form::model($post, array('method' => 'PATCH', 'action' => array('AdminBlogsController@update', $post->id), 'role'=>'form', 'files' => true)) }}

		<!-- CSRF Token -->
		<!-- ./ csrf token -->
			<!-- General tab -->
        <div class="col-md-12">
            <div class="form-group col-md-6">
                {{ Form::label('user_id', 'Author:',array('class'=>'control-label')) }}
                {{ Form::select('user_id', $author,NULL,array('class'=>'form-control')) }}
            </div>

            <div class="form-group col-md-6">
                {{ Form::label('category_id', 'Category:') }}
                {{ Form::select('category_id', $category,NULL,array('class'=>'form-control')) }}
            </div>
        </div>
        <br><br><br>
				<!-- Post Title -->
        <div class="form-group {{{ $errors->has('title') ? 'error' : '' }}}">
            <div class="col-md-12">
                <label class="control-label" for="title">Post Title</label>
                <input class="form-control" type="text" name="title" id="title" value="{{{ Input::old('title', isset($post) ? $post->title : null) }}}" />
                {{{ $errors->first('title', '<span class="help-inline">:message</span>') }}}
            </div>
        </div>
        <!-- ./ post title -->

        <!-- Content -->
        <div class="form-group {{{ $errors->has('content') ? 'error' : '' }}}">
            <div class="col-md-12">
                <label class="control-label" for="content">Content</label>
                <textarea class="form-control full-width wysihtml5" name="content" value="content" rows="10">{{{ Input::old('content', isset($post) ? $post->content : null) }}}</textarea>
                {{{ $errors->first('content', '<span class="help-inline">:message</span>') }}}
            </div>
        </div>
        <!-- ./ content -->

        <div class="form-group {{{ $errors->has('thumbnail') ? 'error' : '' }}}">
            <div class="col-md-12">
                <label class="control-label" for="meta_keywords">Upload Image</label>
                <input type="file" name="thumbnail" id="thumbnail" />
                {{{ $errors->first('thumbnail', '<span class="help-inline">:message</span>') }}}
            </div>
        </div>



		<!-- Form Actions -->
		<div class="form-group">
			<div class="col-md-12">
				<element class="btn-cancel close_popup">Cancel</element>
				<button type="reset" class="btn btn-default">Reset</button>
				<button type="submit" class="btn btn-success">Update</button>
			</div>
		</div>
		<!-- ./ form actions -->
	</form>
@stop
