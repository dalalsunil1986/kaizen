<?php

use Acme\Core\LocaleTrait;

class Country extends BaseModel {

    use LocaleTrait;

    protected $guarded = array();

    protected $localeStrings = ['name'];

    protected static $name = 'country';

    public function locations()
    {
        return $this->hasMany('Location');
    }

    public function events()
    {
        return $this->hasManyThrough('EventModel', 'Location');
    }

}
