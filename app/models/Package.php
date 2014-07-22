<?php

class Package extends BaseModel {

    protected $guarded = array('');

    protected static $name = 'package';

    protected $table = 'packages';

    public function subscriptions()
    {
        return $this->morphMany('Subscription', 'subscribable');
    }

    public function settings()
    {
        return $this->morphMany('Setting', 'settings');
    }

}
