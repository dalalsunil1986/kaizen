@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<h4>Success</h4>
    @if(is_array($message))
        @foreach ($message as $m)
            {{ $m }}
        @endforeach
    @else
        {{ $message }}
    @endif
</div>
@endif

@if ( Session::get('errors') )
<button type="button" class="close" data-dismiss="alert">&times;</button>
<div class="alert alert-danger alert-block"><h2>Please fix the Errors</h2>
    @if(count($errors) >= 1)
        {{ implode('', $errors->all('<p> - :message</p>')) }}
    @else
        <p>: {{ $errors }}</p>
    @endif
</div>
@endif

@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-block">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<h4>Warning</h4>
    @if(is_array($message))
        @foreach ($message as $m)
            {{ $m }}
        @endforeach
            @else
        {{ $message }}
    @endif
</div>
@endif

@if ($message = Session::get('info'))
<div class="alert alert-info alert-block">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<h4>Info</h4>
    @if(is_array($message))
        @foreach ($message as $m)
            {{ $m }}
        @endforeach
            @else
        {{ $message }}
    @endif
</div>
@endif
