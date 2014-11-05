<div class="btn-group btn-group-sm">

    <div class="visible-xs top10"></div>
    <a type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
        <img src="" class="flag flag-{{strtolower($selectedCountry)}}"/>{{ $selectedCountry }}<span class="caret"></span>
    </a>

    <ul class="dropdown-menu" role="menu">
        @foreach($availableCountries as $country )
            <li><a href="{{ action('LocaleController@setCountry',['country'=> $country->iso_code]) }}"><img src="blank.gif" class="flag flag-{{strtolower($country->iso_code)}}"/>{{$country->name}}</a></li>
        @endforeach
    </ul>

</div>