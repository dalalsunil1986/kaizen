<?php

class Status extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array(
        'user_id' => 'required | integer',
        'event_id' => 'required | integer',
        'status' => 'required'
    );

    public  function user() {
        return $this->belongsTo('User');
    }

    public  function event() {
        return $this->belongsTo('EventModel');
    }

}
