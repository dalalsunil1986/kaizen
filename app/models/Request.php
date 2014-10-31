<?php

class Request extends BaseModel {

    protected $guarded = array();

    protected $name = 'request';

    public function users() {
        return $this->belongsTo('User');
    }

    public function events() {
        return $this->belongsTo('EventModel');
    }
}

