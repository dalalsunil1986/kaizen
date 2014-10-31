
@if ( Session::get('errors') )

    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <div class="alert alert-danger alert-block"><h3>{{ trans('word.error') }}</h3>

        <div class="padded">
            @if(!is_array($errors))
                @foreach($errors->all('<li>:message</li>') as $message)
                    {{ $message }}
                @endforeach
            @else
                @foreach ($errors as $message)
                    <li>{{ $message }}</li>
                @endforeach
            @endif
        </div>

    </div>

@endif

@if ($message = Session::get('error'))
    <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4>{{ trans('word.error') }}</h4>
        @if(is_array($message))
            @foreach ($message as $m)
            <li>{{ $m }}</li>
            @endforeach
        @else
            {{ $message }}
        @endif
    </div>
@endif

@if ($message = Session::get('warning'))
    <div class="alert alert-warning alert-block">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4>{{ trans('word.error') }}</h4>
        @if(is_array($message))
            @foreach ($message as $m)
                <li>{{ $m }}</li>
            @endforeach
        @else
            {{ $message }}
        @endif
    </div>
@endif

@if ($message = Session::get('info'))
    <div class="alert alert-info alert-block">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4>{{ trans('word.info') }}</h4>
        @if(is_array($message))
            @foreach ($message as $m)
                <li>{{ $m }}</li>
            @endforeach
        @else
            {{ $message }}
        @endif
    </div>
@endif

@if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4>{{ trans('word.success') }}</h4>
        @if(is_array($message))
            @foreach ($message as $m)
                <li>{{ $m }}</li>
            @endforeach
        @else
            {{ $message }}
        @endif
    </div>
@endif
