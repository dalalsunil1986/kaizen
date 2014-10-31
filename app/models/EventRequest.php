<?php

class EventRequest extends BaseModel {

    protected $guarded = array();

    protected $table = 'requests';

    public $timestamps = true;

    public function users()
    {
        return $this->belongsTo('User');
    }

    public function events()
    {
        return $this->belongsTo('EventModel');
    }


}

