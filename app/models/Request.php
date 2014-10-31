<?php

class Request extends BaseModel {

    protected $guarded = [];

    protected $name = 'request';

    public function users()
    {
        return $this->belongsTo('User');
    }

    public function events()
    {
        return $this->belongsTo('EventModel');
    }
}

