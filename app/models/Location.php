<?php

use Acme\Core\LocaleTrait;

class Location extends BaseModel {

    use LocaleTrait;

    protected $guarded = array('');

    protected $localeStrings = ['name'];

    protected static $name = 'location';

    public function country()
    {
        return $this->belongsTo('Country');
    }

    public function events()
    {
        return $this->hasMany('EventModel');
    }
}
