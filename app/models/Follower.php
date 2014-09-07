<?php

class Follower extends BaseModel {
    protected $guarded = array();

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

