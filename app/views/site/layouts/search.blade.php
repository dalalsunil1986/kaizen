<div class="row">
    {{ Form::open(array('action' => 'EventsController@index','method'=>'get','class'=>'form-inline')) }}

        <div class="form-group col-md-12">
            <input type="text" class="form-control" id="search" name="search" value="@if(isset($search)) {{ $search }} @endif "  placeholder="Keyword">
        </div>
        <div class="form-group col-md-4 top7">
            {{ Form::select('category', $categories, $category ,['class' => 'form-control']) }}
        </div>

        <div class="form-group col-md-3 top7">
            {{ Form::select('country',$countries, $country ,['class' => 'form-control']) }}
        </div>

        <div class="form-group col-md-3 top7">
            {{ Form::select('author', $authors, $author ,['class' => 'form-control']) }}
        </div>

        <div class="form-group col-md-1 top7">
            <button type="submit" class="btn btn-default btn-small">{{ Lang::get('site.nav.search') }}</button>
        </div>

    {{ Form::close() }}
</div>
