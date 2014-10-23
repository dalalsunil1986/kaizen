<div class="btn-group show-on-hover">
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    {{ $selectedCountry }}<span class="caret"></span>
    </button>

    <ul class="dropdown-menu" role="menu">
        @foreach($availableCountries as $country )
            <li><a href="{{ action('LocaleController@setCountry',['country'=> $country->iso_code]) }}">{{$country->name}}</a></li>
        @endforeach
    </ul>
</div>