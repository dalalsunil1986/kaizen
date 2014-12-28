<?php

use Acme\Core\LocaleTrait;
use McCool\LaravelAutoPresenter\PresenterInterface;

class Setting extends BaseModel implements PresenterInterface {

    use LocaleTrait;

    protected $guarded = ['id'];

    protected $localeStrings = ['vip_benefits', 'online_benefits', 'normal_benefits', 'vip_description', 'online_description', 'normal_description'];

    protected $table = 'settings';

    public function settingable()
    {
        return $this->morphTo();
    }

    public function getPresenter()
    {
        return 'Acme\Setting\Presenter';
    }


    /**
     * @param $type => { VIP, ONLINE, NORMAL }
     * @return \Acme\Core\localized
     */
    public function hasAvailableSeats($type)
    {
        $field = strtolower($type) . '_total_seats';

        return $this->$field > 0 ? true : false;
    }

    /**
     * @param $type => { VIP, ONLINE, NORMAL }
     * @return \Acme\Core\localized
     */
    public function getPriceForType($type)
    {
        $field = strtolower($type) . '_total_seats';

        return $this->$field;
    }



    public function scopeHasAvailableSeatsOfType($query, $type)
    {
        return $query->whereavailableSeats($type);
    }

    /**
     * @param $type
     * @return string
     */
    public function resolveType($type)
    {
        $field = strtolower($type) . '_total_seats';

        return $field;
    }

}
