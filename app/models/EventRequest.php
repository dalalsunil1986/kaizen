<?php

class EventRequest extends BaseModel {

    protected $guarded = array();

    protected $table = 'requests';

    public $timestamps = true;

    public static $rules = array(
        'user_id' => 'required | integer',
        'event_id' => 'required | integer'
    );

    public function users() {
        return $this->belongsTo('User');
    }

    public  function events() {
        return $this->belongsTo('EventModel');
    }


}

