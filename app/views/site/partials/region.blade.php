<div class="btn-group btn-group-sm">

    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
        <img src="blank.gif" class="flag flag-{{strtolower($selectedCountry)}}"/>{{ $selectedCountry }}<span class="caret"></span>
    </button>

    <ul class="dropdown-menu" role="menu">
        @foreach($availableCountries as $country )
            <li><a href="{{ action('LocaleController@setCountry',['country'=> $country->iso_code]) }}"><img src="blank.gif" class="flag flag-{{strtolower($country->iso_code)}}"/>{{$country->name}}</a></li>
        @endforeach
    </ul>

</div>