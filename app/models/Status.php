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


    /**
     * @param $id eventId
     * @param $userId int
     * @return boolean
     * Is User subsribed to this event
     */
    public static function getStatus($id,$userId) {
        $query = Status::where('user_id', '=', $userId)->where('event_id', '=', $id)->first();
        return $query;
    }

}
