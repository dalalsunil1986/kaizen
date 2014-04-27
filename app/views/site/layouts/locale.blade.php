<div class="localeCode">
    @if ( LaravelLocalization::getCurrentLocaleName() == 'English')
    <?php $localeCode = 'ar' ;?>
    <a type="button" class="btn btn-default btn-sm" rel="alternate" hreflang="{{$localeCode}}" href="{{LaravelLocalization::getLocalizedURL($localeCode) }}">
        العربية <i class="glyphicon  glyphicon-globe"></i>
    </a>
    @else
    <?php $localeCode = 'en' ;?>
    <a type="button" class="btn btn-default btn-sm" rel="alternate" hreflang="{{$localeCode}}" href="{{LaravelLocalization::getLocalizedURL($localeCode) }}">
        En <i class="glyphicon  glyphicon-globe"></i>
    </a>
    @endif
</div>
