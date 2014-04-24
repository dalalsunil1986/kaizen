<div class="localeCode
            @if ( LaravelLocalization::getCurrentLocaleName() == 'English')
                pull-right
            @else
                pull-left
            @endif">
    @if ( LaravelLocalization::getCurrentLocaleName() == 'English')
    <?php $localeCode = 'ar' ;?>
    <a rel="alternate" hreflang="{{$localeCode}}" href="{{LaravelLocalization::getLocalizedURL($localeCode) }}">
        العربية
    </a>
    @else
    <?php $localeCode = 'en' ;?>
    <a rel="alternate" hreflang="{{$localeCode}}" href="{{LaravelLocalization::getLocalizedURL($localeCode) }}">
        En
    </a>
    @endif
</div>
