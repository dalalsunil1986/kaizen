<div class="row">
    {{ Form::open(array('action' => 'EventsController@index','method'=>'get','class'=>'form-inline')) }}
    <div class="col-md-3 padded">
        <div class="form-group">
            <input type="text" class="form-control" id="search" name="search" value="@if(isset($search)) {{ $search }} @endif "  placeholder="Keyword">
        </div>
    </div>
    <div class="col-md-2 padded">

        <div class="form-group">
            {{ Form::select('country', array('0'=>Lang::get('site.event.choose_country') ,$countries), $country ,['class' => 'form-control']) }}
        </div>
    </div>
    <div class="col-md-2 padded">
        <div class="form-group">
            {{ Form::select('category', array('0'=>Lang::get('site.event.choose_category') ,$categories), $category ,['class' => 'form-control']) }}
        </div>
    </div>
    <div class="col-md-2 padded">
        <div class="form-group">
            {{ Form::select('author', array(''=>Lang::get('site.event.choose_author') ,$authors), $author ,['class' => 'form-control']) }}
        </div>
    </div>
    <div class="col-md-1">

        <button type="submit" class="btn btn-default btn-small">{{ Lang::get('site.nav.search') }}</button>

    </div>
    {{ Form::close() }}
</div>
