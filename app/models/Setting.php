<?php

use Acme\Core\LocaleTrait;
use McCool\LaravelAutoPresenter\PresenterInterface;

class Setting extends BaseModel implements PresenterInterface{

    use LocaleTrait;

    protected $guarded = ['id'];

    protected $localeStrings = ['vip_benefits','online_benefits','normal_benefits','vip_description','online_description','normal_description'];

    protected $table = 'settings';

    public function settingable()
    {
        return $this->morphTo();
    }

    /**
     * Get the presenter class.
     *
     * @return string The class path to the presenter.
     */
    public function getPresenter()
    {
        return 'Acme\Setting\Presenter';
    }
}
